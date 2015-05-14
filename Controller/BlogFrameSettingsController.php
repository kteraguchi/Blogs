<?php
/**
 * BlogFrameSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * BlogFrameSettings Controller
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Blogs\Controller
 */
class BlogFrameSettingsController extends BlogsAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Blogs.Blog',
		'Blogs.BlogFrameSetting',
		//'Blogs.BlogPost',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('edit'),
			),
		),
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token'
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->__initBlogFrameSetting();

		if ($this->request->isPost()) {
			$data = $this->data;
			$this->BlogFrameSetting->saveBlogFrameSetting($data);

			if ($this->handleValidationError($this->BlogFrameSetting->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/blogs/blogs/index/' . $this->viewVars['frameId']);
				}
				return;
			}

			$results = $this->camelizeKeyRecursive($data);
			$this->set($results);
		}
	}

/**
 * initBlog
 *
 * @return void
 */
	private function __initBlogFrameSetting() {
		if (! $blogFrameSetting = $this->BlogFrameSetting->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'frame_key' => $this->viewVars['frameKey']
			)
		))) {
			$blogFrameSetting = $this->BlogFrameSetting->create(
				array(
					'frame_key' => $this->viewVars['frameKey']
				)
			);
		}
		$blogFrameSetting = $this->camelizeKeyRecursive($blogFrameSetting);
		$this->set($blogFrameSetting);
	}

}
