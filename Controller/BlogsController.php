<?php
/**
 * BlogsController
 */
App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * Blogs Controller
 *
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 *
 * @property BlogEntry $BlogEntry
 */
class BlogsController extends BlogsAppController {

/**
 * index
 *
 * @return void
 */
	public function index() {
		if (! $this->viewVars['blockId']) {
			$this->autoRender = false;
			return;
		}

		$frameId = $this->viewVars['frameId'];
		$html = $this->requestAction(
			array('controller' => 'blog_entries', 'action' => 'index', $frameId),
			array('return')
		);

		$this->set('html', $html);
	}

}