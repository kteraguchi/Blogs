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
		'Security',
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
	protected function _loadBlockSetting() {
		$this->_blockSetting = $this->BlogBlockSetting->getSettingByBLockKey($this->viewVars['blockKey']);
		$this->set('blockSetting', $this->_blockSetting);
	}

/**
 * フレーム設定を読みこむ
 *
 * @return void
 */
	protected function _loadFrameSetting() {
		$this->_frameSetting = $this->BlogFrameSetting->getSettingByFrameKey($this->viewVars['frameKey']);
	}

/**
 * 設定等の呼び出し
 *
 * @return void
 */
	protected function _prepare() {
		$this->_setupBlogTitle();
		$this->_loadBlockSetting();
		$this->_loadFrameSetting();
	}

/**
 * namedパラメータ取得
 * 
 * @param string $name namedパラメータ名
 * @param null $default パラメータが存在しなかったときのデフォルト値
 * @return int|string
 */
	protected function _getNamed($name, $default = null) {
		$value = isset($this->request->params['named'][$name]) ? $this->request->params['named'][$name] : $default;
		return $value;
	}

}
