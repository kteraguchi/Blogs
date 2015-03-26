<?php

App::uses('AppController', 'Controller');

class BlogsAppController extends AppController {

	protected $blogTitle;
	protected $blockSetting;
	protected $frameSetting;

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

	public function beforeFilter() {
		parent::beforeFilter();

	}


	/**
	 * 現在時刻を返す。テストしやすくするためにメソッドに切り出した。
	 * @return int
	 */
	protected function getNow() {
		return time();
	}

	protected function getCurrentDateTime(){
		return date('Y-m-d H:i:s', $this->getNow());
	}


	protected function setupBlogTitle() {
		$block = $this->NetCommonsBlock->Block->findById($this->viewVars['blockId']);
		$this->blogTitle = $block['Block']['name'];
	}



	protected function loadBlockSetting() {
		$this->blockSetting = $this->BlogBlockSetting->getSettingByBLockKey($this->viewVars['blockKey']);
		$this->set('blockSetting', $this->blockSetting);
	}

	protected function loadFrameSetting() {
		$this->frameSetting = $this->BlogFrameSetting->getSettingByFrameKey($this->viewVars['frameKey']);
	}

	protected function getNamed($name, $default = null){
		$value = isset($this->request->params['named'][$name]) ? $this->request->params['named'][$name] : $default;
		return $value;
	}

}
