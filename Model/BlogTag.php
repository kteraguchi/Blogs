<?php
/**
 * Tag Model
 *
 * @property Block $Block
 * @property BlogEntryTagLink $BlogEntryTagLink
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsAppModel', 'Blogs.Model');

/**
 * Summary for Tag Model
 */
class BlogTag extends BlogsAppModel {

/**
 * recursive
 *
 * @var int
 */
	public $recursive = -1;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Trackable',
//		'NetCommons.Publishable'

	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	public $hasAndBelongsToMany = array(
		'BlogEntry' => array(
			'className' => 'Blogs.BlogEntry',
			'joinTable' => 'blog_entry_tag_links',
			'foreignKey' => 'blog_tag_id',
			'associationForeignKey' => 'blog_entry_id',
			'unique' => false,
			'dependent' => false,
			'with' => 'Blogs.BlogEntryTagLink',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	// OK
	public function getTagsByEntryId($entryId) {
		$conditions = array(
			'BlogEntryTagLink.blog_entry_id' => $entryId,
		);
		$options = array(
			'conditions' => $conditions,
		);
		$options['joins'] = array(
			array('table' => 'blog_entry_tag_links',
				'alias' => 'BlogEntryTagLink',
				'type' => 'LEFT',
				'conditions' => array(
					'BlogTag.id = BlogEntryTagLink.blog_tag_id',
				)
			)
		);
		$tags = $this->find('all', $options);
		return $tags;
	}

	// OK
	public function getTagsListByEntryId($entryId) {
		$tags = $this->getTagsByEntryId($entryId);
		$list = array();
		foreach ($tags as $tag) {
			$list[] = $tag['BlogTag'];
		}
		return $list;

	}

	// OK
	public function saveTags($blockId, $entryId, $tags) {
		if (!is_array($tags)) {
			$tags = array();
		}
		// 存在しないタグを保存
		// タグへのリンクを保存
		$tagNameList = array();
		foreach ($tags as $tag) {
			if (isset($tag['name'])) {
				$tagNameList[] = $tag['name'];
			}
		}
		foreach ($tagNameList as $tagName) {
			//
			$savedTag = $this->findByBlockIdAndName($blockId, $tagName);
			if (!$savedTag) {
				// $tagがないなら保存
				$data = $this->create();

				$data['BlogTag']['name'] = $tagName;
				$data['BlogTag']['block_id'] = $blockId;
				if ($this->save($data)) {
					$savedTag = $this->findById($this->id);
				} else {
					return false;
				}
			}
			// save link
			$link = $this->BlogEntryTagLink->create();
			$link['BlogEntryTagLink']['blog_entry_id'] = $entryId;
			$link['BlogEntryTagLink']['blog_tag_id'] = $savedTag['BlogTag']['id'];

			if (!$this->BlogEntryTagLink->save($link)) {
				return false;
			}
		}
		return true;
	}

/**
 * origin_idがセットされてなかったらorigin_id=idとしてアップデート
 *
 * @param bool $created created
 * @param array $options options
 * @return void
 */
	public function afterSave($created, $options = array()) {
		if ($created) {
			if (empty($this->data[$this->name]['origin_id'])) {
				// origin_id がセットされてなかったらkey=idでupdate
				$this->originId = $this->data[$this->name]['id'];
				$this->saveField('origin_id', $this->data[$this->name]['id'], array('callbacks' => false)); // ここで$this->dataがリセットされる
			}
		}
	}

}
