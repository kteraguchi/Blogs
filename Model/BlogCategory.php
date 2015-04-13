<?php
/**
 * BlogCategory Model
 *
 * @property Block $Block
 * @property BlogEntry $BlogEntry
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsAppModel', 'Blogs.Model');

/**
 * Summary for BlogCategory Model
 */
class BlogCategory extends BlogsAppModel {

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
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'BlogEntry' => array(
			'className' => 'Blogs.BlogEntry',
			'foreignKey' => 'blog_category_id',
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

/**
 * 指定されたブロックIDのカテゴリデータを返す
 *
 * @param int $blockId ブロックID
 * @return array
 */
	public function getCategories($blockId) {
		$conditions = array(
			'block_id' => $blockId,
		);

		$this->unbindModel(
			array(
				'belongsTo' => array('Block'),
				'hasMany' => array('BlogEntry'),
			)
		);

		// ソート順はblog_category_ordersテーブル参照
		$categories = $this->find(
			'all',
			array(
				'conditions' => $conditions,
				'order' => 'weight ASC',
			)
		);

		return $categories;
	}

/**
 * カテゴリIDをキーとしたカテゴリ一覧の連想配列を返す
 *
 * @param int $blockId ブロックID
 * @return array
 */
	public function getCategoriesList($blockId) {
		$categories = $this->getCategories($blockId);
		$ret = array();
		foreach ($categories as $category) {
			$ret[$category['BlogCategory']['id']] = $category['BlogCategory']['name'];
		}
		return $ret;
	}

}
