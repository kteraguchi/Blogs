<?php

App::uses('AppController', 'Controller');

class BlogsAppController extends AppController {

	protected $_blogTitle;

	protected $_blockSetting;

	protected $_frameSetting;

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('setting', 'token', 'edit') // TODO これは何？
			),
			//コンテンツのワークフロー設定(公開権限チェック)
			'workflowActions' => array('edit'),
			'workflowModelName' => 'Blogs',
		),
	);

	public $helpers = array(
		'Blogs.BlogsFormat',
	);

	public $uses = array(
		'Blogs.BlogBlockSetting',
		'Blogs.BlogFrameSetting'
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}


/**
 * 現在時刻を返す。テストしやすくするためにメソッドに切り出した。
 *
 * @return int
 */
	protected function _getNow() {
		return time();
	}

/**
 * 現在の日時を返す
 *
 * @return string datetime
 */
	protected function _getCurrentDateTime() {
		return date('Y-m-d H:i:s', $this->_getNow());
	}

/**
 * ブロック名をブログタイトルとしてセットする
 *
 * @return void
 */
	protected function _setupBlogTitle() {
		$this->loadModel('NetCommonsBlock.Block');
		$block = $this->Block->findById($this->viewVars['blockId']);
		$this->_blogTitle = $block['Block']['name'];
	}

/**
 * ブロック設定を読みこむ
 *
 * @return void
 */
	protected function loadBlockSetting() {
		$this->_blockSetting = $this->BlogBlockSetting->getSettingByBLockKey($this->viewVars['blockKey']);
		$this->set('blockSetting', $this->_blockSetting);
	}

/**
 * フレーム設定を読みこむ
 *
 * @return void
 */
	protected function loadFrameSetting() {
		$this->_frameSetting = $this->BlogFrameSetting->getSettingByFrameKey($this->viewVars['frameKey']);
	}

/**
 * デフォルト値 named
 *
 * @return int|string
 */
	protected function getNamed($name, $default = null) {
		$value = isset($this->request->params['named'][$name]) ? $this->request->params['named'][$name] : $default;
		return $value;
	}

}
