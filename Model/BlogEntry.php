<?php
/**
 * BlogEntry Model
 *
 * @property BlogCategory $BlogCategory
 * @property BlogEntryTagLink $BlogEntryTagLink
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsAppModel', 'Blogs.Model');

/**
 * Summary for BlogEntry Model
 */
class BlogEntry extends BlogsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'blog_category_id' => array(
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
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'vote_number' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_auto_translated' => array(
			'boolean' => array(
				'rule' => array('boolean'),
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
		'BlogCategory' => array(
			'className' => 'BlogCategory',
			'foreignKey' => 'blog_category_id',
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
			'className' => 'BlogEntryTagLink',
			'foreignKey' => 'blog_entry_id',
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
	 * UserIdと権限から参照可能なEntryを取得するCondition配列を返す
	 * @param $userId
	 * @param $permissions
	 * @param $currentDateTime
	 * @return array condition
	 */
	public function getConditions($blockId, $userId, $permissions, $currentDateTime) {

		// デフォルト絞り込み条件
		$conditions = array(
			'BlogCategory.block_id' => $blockId
		);

		if($permissions['contentReadable']){


			if ($permissions['contentEditable']) {
				// 編集権限
				// 他人の下書き以外は全部見られる
				$conditions = array_merge(
					$conditions,
					array(
						'OR' => array(
							array(
								'BlogEntry.created_user' => $userId
							),
							array(
								'BlogEntry.status !=' => NetCommonsBlockComponent::STATUS_DRAFTED
							)
						)
					)
				);

			} elseif ($permissions['contentCreatable']){
				// 作成権限
				$conditions = array_merge(
					$conditions,
					array(
						'OR' => array(
							$this->getPublishedConditions($currentDateTime),
							array(
								'BlogEntry.created_user' => $userId
							)
						)
					)
				);
			}else{
				// 閲覧権限のみ
				$conditions = array_merge(
					$conditions,
					$this->getPublishedConditions($currentDateTime)
				);

			}

		}else{
			// contentReadable falseなら何も見えない
			$conditions = array_merge(
				$conditions,
				array('BlogEntry.id' => 0) // ありえない条件でヒット0にしてる
			);
		}

		return $conditions;
	}

	protected function getPublishedConditions($currentDateTime) {
		return array(
			'BlogEntry.status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
			'BlogEntry.published_datetime <=' => $currentDateTime,
		);
	}

}
