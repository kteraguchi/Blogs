<?php
/**
 * BlogFrameSetting Model
 *
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsAppModel', 'Blogs.Model');

/**
 * Summary for BlogFrameSetting Model
 */
class BlogFrameSetting extends BlogsAppModel {

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
		'display_number' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function getSettingByFrameKey($frameKey) {
		$setting = $this->findByFrameKey($frameKey);
		if ($setting) {
			return $setting['BlogFrameSetting'];
		} else {
			// 設定データがまだないときはつくる
			$this->create();
			$data = array(
				'BlogFrameSetting' => array(
					'frame_key' => $frameKey
				)
			);
			$this->save($data);
			$setting = $this->findByFrameKey($frameKey);
			return $setting['BlogFrameSetting'];
		}

	}
}
