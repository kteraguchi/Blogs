<?php
/**
 * BlogEntriesEdit
 */
App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * BlogEntriesEdit Controller
 *
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 * @property NetCommonsWorkflow $NetCommonsWorkflow
 * @property PaginatorComponent $Paginator
 * @property BlogEntry $BlogEntry
 * @property BlogCategory $BlogCategory
 */
class BlogEntriesEditController extends BlogsAppController {

/**
 * @var array use models
 */
	public $uses = array(
		'Blogs.BlogEntry',
		'Categories.Category',
		'Blogs.BlogCategory',
		'Comments.Comment',
	);

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit', 'add'),
				'contentCreatable' => array('edit', 'add'),
			),
		),
		'Categories.Categories',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Categories->initCategories();
	}

/**
 * add method
 *
 * @throws InternalErrorException
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BlogEntry->begin();
			$this->BlogEntry->create();
			// set status
			$status = $this->NetCommonsWorkflow->parseStatus();
			$this->request->data['BlogEntry']['status'] = $status;

			// set block_id
			$this->request->data['BlogEntry']['block_id'] = $this->viewVars['blockId'];
			// set language_id
			$this->request->data['BlogEntry']['language_id'] = $this->viewVars['languageId'];

			try {
				if (($this->BlogEntry->saveEntry($this->viewVars['blockId'], $this->request->data)) === false) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}

				$this->BlogEntry->commit();

				$this->Session->setFlash(__('The blog entry has been saved.'));
				return $this->redirect(
					array('controller' => 'blog_entries', 'action' => 'view', $this->viewVars['frameId'], 'origin_id' => $this->BlogEntry->originId)
				);

			} catch (Exception $e) {
				$this->BlogEntry->rollback();
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));

			}
		} else {
			$blogEntry = $this->BlogEntry->getNew();
			$this->request->data = $blogEntry;
			$this->set('blogEntry', $blogEntry);
			$this->request->data['Tag'] = array();
		}


		$comments = $this->Comment->getComments(
			array(
				'plugin_key' => 'blogs',
				'content_key' => isset($blogEntry['BlogEntry']['key']) ? $blogEntry['BlogEntry']['key'] : null,
			)
		);
		$this->set('comments', $comments);

		$this->render('form');
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @throws InternalErrorException
 * @return void
 */
	public function edit() {
		$originId = $this->request->params['named']['origin_id'];

		//  origin_idのis_latstを元に編集を開始
		$blogEntry = $this->BlogEntry->findByOriginIdAndIsLatest($originId, 1);

		if (empty($blogEntry)) {
			//  404 NotFound
			throw new NotFoundException();
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->BlogEntry->begin();
			$this->BlogEntry->create();
			// set status
			$status = $this->NetCommonsWorkflow->parseStatus();
			$this->request->data['BlogEntry']['status'] = $status;

			// set block_id
			$this->request->data['BlogEntry']['block_id'] = $this->viewVars['blockId'];
			// set language_id
			$this->request->data['BlogEntry']['language_id'] = $this->viewVars['languageId'];

			try {
				$data = $this->request->data;

				unset($data['BlogEntry']['id']); // 常に新規保存
				if (!$this->BlogEntry->saveEntry($this->viewVars['blockId'], $data)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}

				$this->BlogEntry->commit();

				$this->Session->setFlash(__('The blog entry has been saved.'));
				return $this->redirect(
					array('controller' => 'blog_entries', 'action' => 'view', $this->viewVars['frameId'], 'origin_id' => $data['BlogEntry']['origin_id'])
				);

			} catch (Exception $e) {
				$this->BlogEntry->rollback();
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));

			}
		} else {

			$this->request->data = $blogEntry;
			// ε(　　　　 v ﾟωﾟ)　＜ 編集できる記事か？

		}

		$this->set('blogEntry', $blogEntry);

		$comments = $this->Comment->getComments(
			array(
				'plugin_key' => 'blogentries',
				// ε(　　　　 v ﾟωﾟ)　＜ Commentプラグインでセーブするときにモデル名をstrtolowerして複数形になおして保存してるのでこんな名前。なんとかしたい
				'content_key' => isset($blogEntry['BlogEntry']['key']) ? $blogEntry['BlogEntry']['key'] : null,
			)
		);
		$this->set('comments', $comments);

		$this->render('form');
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @return void
 */
	public function delete() {
		$originId = $this->_getNamed('origin_id', 0);

		$this->request->onlyAllow('post', 'delete');

		if ($this->BlogEntry->deleteEntryByOriginId($originId)) {
			$this->Session->setFlash(__('The blog entry has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog entry could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('controller' => 'blog_entries', 'action' => 'index'));
	}

}
