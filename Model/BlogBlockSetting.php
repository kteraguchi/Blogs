<?php
/**
 * BlogBlockSetting Model
 *
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsAppModel', 'Blogs.Model');

/**
 * Summary for BlogBlockSetting Model
 */
class BlogBlockSetting extends BlogsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'frame_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'blog_title' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mail_new_entry' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'use_comment' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'auto_approve_comment' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'use_sns' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'use_vote' => array(
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

//	/**
//	 * belongsTo associations
//	 *
//	 * @var array
//	 */
//	public $belongsTo = array(
//		'Block' => array(
//			'className' => 'Blocks.Block',
//			'foreignKey' => false,
//			'conditions' => array('BlogBlockSetting.block_key = Block.key'),
//			'fields' => '',
//			'order' => ''
//		)
//	);

	public function getSettingByBlockKey($blockKey) {
		$setting = $this->findByBlockKey($blockKey);
		if ($setting) {
			return $setting['BlogBlockSetting'];
		} else {
			// 設定データがまだないときはつくる
			$this->create();
			$data = array(
				'BlogBlockSetting' => array(
					'block_key' => $blockKey
				)
			);
			$this->save($data);
			$setting = $this->findByBlockKey($blockKey);
			return $setting['BlogBlockSetting'];
		}
	}
}
