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

//		$blogBlockSetting = $this->BlogBlockSetting->find('first',array('conditions' => array('Block.id' => $this->viewVars['blockId'])));
//		if($blogBlockSetting){
//			$this->blockSetting = $blogBlockSetting;
//		}else{
//			// TODO blog_block_settingsにまだデータがないときはデフォルトデータを書き込む
//		}
//		var_dump($this);
////		var_dump($blogBlockSetting);

		// TODO blog_block_settingsロード
		// TODO blog_frame_settingsロード
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
	}

	protected function loadFrameSetting() {
		$this->frameSetting = $this->BlogFrameSetting->getSettingByFrameKey($this->viewVars['frameKey']);
	}
}
