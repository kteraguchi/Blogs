<?php
App::uses('BlogsAppController', 'Blogs.Controller');
/**
 * BlogEntries Controller
 *
 * @property BlogEntry $BlogEntry
 * @property PaginatorComponent $Paginator
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 * @property BlogEntry $BlogEntry
 * @property BlogTag $BlogTag
 */

class BlogEntriesController extends BlogsAppController {

	/**
	 *
	 */
	public $uses = array(
		'Blogs.BlogEntry',
		'Blogs.BlogBlockSetting',
		'Blogs.BlogCategory',
		'Blogs.BlogTag',
		'Comments.Comment',
	);


/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Paginator',
		'NetCommons.NetCommonsWorkflow',
		);

	public function index(){
		$this->setupBlogTitle();
		$this->loadBlockSetting();
		$this->loadFrameSetting();

		// TODO リストタイプ毎にタイトルは変更する
		$this->set('listTitle', $this->blogTitle);

		$this->setCategoryOptions();
		$this->setYearMonthOptions();

		if($this->viewVars['contentReadable']){
			$conditions = $this->BlogEntry->getConditions(
				$this->viewVars['blockId'],
				$this->Auth->user('id'),
				$this->viewVars,
				$this->getCurrentDateTime()
			);

			$this->Paginator->settings = array(
				'conditions' => $conditions,
				'limit' => $this->frameSetting['display_number'],
				'order' => 'published_datetime DESC'
			);
			$this->BlogEntry->recursive = 0;
			$this->set('blogEntries', $this->Paginator->paginate());

		}else{
			// 何も見せない
		}
	}
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view() {
		$this->loadBlockSetting();
		$this->loadFrameSetting();

		$id = $this->request->params['named']['id'];
		if($this->viewVars['contentReadable']){
			$conditions = $this->BlogEntry->getConditions(
				$this->viewVars['blockId'],
				$this->Auth->user('id'),
				$this->viewVars,
				$this->getCurrentDateTime()
			);

			$conditions['BlogEntry.id'] = $id;

		}else{
			// 何も見せない
			throw new NotFoundException(__('Invalid blog entry'));
		}

		$options = array('conditions' => $conditions);
		$blogEntry = $this->BlogEntry->find('first', $options);
		if($blogEntry){
			$this->set('blogEntry', $blogEntry);
			// tag取得
			$blogTags = $this->BlogTag->getTagsByEntryId($id);
			$this->set('blogTags', $blogTags);

			// ε(　　　　 v ﾟωﾟ)　＜ コメント取得

		}else{
			// 表示できない記事へのアクセスなら403
			throw new NotFoundException(__('Invalid blog entry'));
		}
	}

	protected function setCategoryOptions() {
		$categories = $this->BlogCategory->getCategories($this->viewVars['blockId']);
		$options = array(
			0 => __d('blogs', 'All categories'),
		);
		foreach($categories as $category){
			$options[$category['BlogCategory']['id']] = $category['BlogCategory']['name'];
		}
		$this->set('categoryOptions', $options);
	}

	protected function setYearMonthOptions() {
		// 年月と記事数
		$yearMonthCount = $this->BlogEntry->getYearMonthCount(
			$this->viewVars['blockId'],
			$this->Auth->user('id'),
			$this->viewVars,
			$this->getCurrentDateTime()
		);
		$options = array(
			0 => '----'
		);
		foreach($yearMonthCount as $yearMonth => $count){
			list($year, $month) = explode('-', $yearMonth);
			$options[$yearMonth] = __d('blogs', '%d-%d (%s)', $year, $month, $count);
		}
		$this->set('yearMonthOptions', $options);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BlogEntry->create();
			// set status
			$status = $this->NetCommonsWorkflow->parseStatus();
			$this->request->data['BlogEntry']['status'] = $status;

			// set key
			$key = $this->BlogEntry->makeKey();
			$this->request->data['BlogEntry']['key'] = $key;
			if ($this->BlogEntry->save($this->request->data)) {

				// save tags
				if($this->BlogTag->saveEntryTags($this->viewVars['blockId'], $this->BlogEntry->id, $this->request->data['BlogTag'])){
					// save entry_tag_links

					$this->Session->setFlash(__('The blog entry has been saved.'));
					return $this->redirect(array('action' => 'view', $this->viewVars['frameId'], 'id' => $this->BlogEntry->id));

				}else{
					$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));
			}
		}
		//  このブロックのカテゴリだけに絞り込む
		$blogCategories = $this->BlogCategory->getCategoriesList($this->viewVars['blockId']);
		$this->set(compact('blogCategories'));

		$blogEntry = $this->BlogEntry->getNew();
		$this->set('blogEntry', $blogEntry);

		$comments = $this->Comment->getComments(
			array(
				'plugin_key' => 'blogs',
				'content_key' => isset($blogEntry['BlogEntry']['key']) ? $blogEntry['BlogEntry']['key'] : null,
			)
		);
		$this->set('comments', $comments);

	}


// ε(　　　　 v ﾟωﾟ)　＜　この下まだ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝


/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->BlogEntry->exists($id)) {
			throw new NotFoundException(__('Invalid blog entry'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogEntry->save($this->request->data)) {
				$this->Session->setFlash(__('The blog entry has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogEntry.' . $this->BlogEntry->primaryKey => $id));
			$this->request->data = $this->BlogEntry->find('first', $options);
		}
		$blogCategories = $this->BlogEntry->BlogCategory->find('list');
		$this->set(compact('blogCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->BlogEntry->id = $id;
		if (!$this->BlogEntry->exists()) {
			throw new NotFoundException(__('Invalid blog entry'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlogEntry->delete()) {
			$this->Session->setFlash(__('The blog entry has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog entry could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->BlogEntry->recursive = 0;
		$this->set('blogEntries', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BlogEntry->exists($id)) {
			throw new NotFoundException(__('Invalid blog entry'));
		}
		$options = array('conditions' => array('BlogEntry.' . $this->BlogEntry->primaryKey => $id));
		$this->set('blogEntry', $this->BlogEntry->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BlogEntry->create();
			if ($this->BlogEntry->save($this->request->data)) {
				$this->Session->setFlash(__('The blog entry has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));
			}
		}
		$blogCategories = $this->BlogEntry->BlogCategory->find('list');
		$this->set(compact('blogCategories'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->BlogEntry->exists($id)) {
			throw new NotFoundException(__('Invalid blog entry'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogEntry->save($this->request->data)) {
				$this->Session->setFlash(__('The blog entry has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogEntry.' . $this->BlogEntry->primaryKey => $id));
			$this->request->data = $this->BlogEntry->find('first', $options);
		}
		$blogCategories = $this->BlogEntry->BlogCategory->find('list');
		$this->set(compact('blogCategories'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->BlogEntry->id = $id;
		if (!$this->BlogEntry->exists()) {
			throw new NotFoundException(__('Invalid blog entry'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlogEntry->delete()) {
			$this->Session->setFlash(__('The blog entry has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog entry could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
