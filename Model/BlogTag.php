<?php
/**
 * BlogTag Model
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
 * Summary for BlogTag Model
 */
class BlogTag extends BlogsAppModel {

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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'BlogEntryTagLink' => array(
			'className' => 'Blogs.BlogEntryTagLink',
			'foreignKey' => 'blog_tag_id',
			'dependent' => false,
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

	public function getTagsByEntryId($entryId) {
		App::uses('BlogEntryTagLink', 'Blogs.Model');
//		$BlogEntryTagLink = ClassRegistry::init('Blogs.BlogEntryTagLink'); // この書き方だとAppModelになってしまう。
		$BlogEntryTagLink = new BlogEntryTagLink();

		$conditions = array(
			'BlogEntryTagLink.blog_entry_id' => $entryId,
		);
		$options = array(
			'conditions' => $conditions,
		);


		$tags = $BlogEntryTagLink->find('all', $options);

		return $tags;
	}

	public function getTagsListByEntryId($entryId) {
		$tags = $this->getTagsByEntryId($entryId);
		$list = array();
		foreach($tags as $tag){
			$list[] = $tag['BlogTag'];
		}
		return $list;

	}

	public function saveEntryTags($blockId, $entryId, $tags) {
        if(!is_array($tags)){
            $tags = array();
        }
        $tagNameList = array();
        foreach($tags as $tag){
            $tagNameList[] = $tag['name'];
        }
        // 記事にリンクされたタグを取得
        $linkedTags = $this->getTagsByEntryId($entryId);
        // $tagsにないタグとのリンクを削除
        foreach($linkedTags as $tmpTag){
            $index = array_search($tmpTag['BlogTag']['name'], $tagNameList);
            if($index === false){
                // 記事から削除されたタグ　リンク削除
                $this->BlogEntryTagLink->delete($tmpTag['BlogEntryTagLink']['id']);
            }else{
                // 記事とリンク済みのタグ DB処理不要
                unset($tagNameList[$index]);
            }
        }
		foreach($tagNameList as $tagName){
			//
			$savedTag = $this->findByBlockIdAndName($blockId, $tagName);
			if( !$savedTag){
				// $tagがないなら保存
				$data = $this->create();

				$data['BlogTag']['name'] = $tagName;
				$data['BlogTag']['block_id'] = $blockId;
				$data['BlogTag']['key'] = $this->makeKey();
				if($this->save($data)) {
					$savedTag = $this->findById($this->id);
				}else{
					return false;
				}
			}
			// save link
			$savedLink = $this->BlogEntryTagLink->findByBlogEntryIdAndBlogTagId($entryId, $savedTag['BlogTag']['id']);
			if(!$savedLink){
				$link = $this->BlogEntryTagLink->create();
				$link['BlogEntryTagLink']['blog_entry_id'] = $entryId;
				$link['BlogEntryTagLink']['blog_tag_id'] = $savedTag['BlogTag']['id'];

				if( !$this->BlogEntryTagLink->save($link)){
					return false;
				}
			}
		}
		return true;
	}


}
