<?php

App::uses('AppController', 'Controller');

class BlogsAppController extends AppController {

	protected $blogTitle;
	protected $blockSetting;
	protected $frameSetting;


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
