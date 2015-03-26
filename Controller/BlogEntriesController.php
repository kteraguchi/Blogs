<?php
App::uses('BlogsAppController', 'Blogs.Controller');
/**
 * BlogEntries Controller
 *
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License

 * @property BlogEntry $BlogEntry
 * @property PaginatorComponent $Paginator
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

// TODO allowedAction
//'NetCommons.NetCommonsRoomRole' => array(
//	//コンテンツの権限設定
//'allowedActions' => array(
//'contentEditable' => array('edit'),
//),
//),

//TODO ゲストOKアクションの指定
//NetCommonsAppControllerのbeforeFilterで$this->Auth->allow('index', 'view');しています。
/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Paginator',
		'NetCommons.NetCommonsWorkflow',
		);


	protected $filter = array(
		'categoryId' => 0,
		'status' => 0,
		'year_month' => 0,
	);

	public function index(){
		$this->set('listTitle', $this->blogTitle);

		$this->_list();
	}

	public function category() {
		// indexとの違いはcategoryIdでの絞り込みをするだけ
		$this->filter['categoryId'] = $this->getNamed('id', 0);

		// カテゴリ名をタイトルに
		$category = $this->BlogCategory->findById($this->filter['categoryId']);
		$this->set('listTitle', __d('blogs', 'Category') . ':' .  $category['BlogCategory']['name']);

		$conditions = array(
			'BlogEntry.blog_category_id' => $this->filter['categoryId']
		);
		$this->_list($conditions);
	}

	public function tag(){
		// indexとのちがいはtagIdでの絞り込みだけ
		$tagId = $this->getNamed('id', 0);

		// カテゴリ名をタイトルに
		$tag = $this->BlogTag->findById($tagId);
		$this->set('listTitle', __d('blogs', 'Tag') . ':' .  $tag['BlogTag']['name']);

		$conditions = array(
			'BlogEntryTagLink.blog_tag_id' => $tagId // これを有効にするにはentry_tag_linkもJOINして検索か。
		);
//		$this->BlogEntry->hasMany['BlogEntryTagLink']['conditions'] = array(
//			'BlogEntryTagLink.blog_tag_id' => $tagId
//		);
//		$conditions = array();
		$this->_list($conditions);
	}

	public function year_month(){
		// indexとの違いはyear_monthでの絞り込み
		$this->filter['yearMonth'] = $this->getNamed('year_month', 0);

		// TODO 年月をタイトルに
		$this->set('listTitle',   $this->filter['yearMonth']);

		$first = $this->filter['yearMonth'] . '-1';
		$last = date('Y-m-t', strtotime($first));

		$conditions = array(
			'BlogEntry.published_datetime BETWEEN ? AND ?' => array($first, $last));
		$this->_list($conditions);
	}


	protected function _list($extraConditions = array()){
		$this->filter['status'] = $this->getNamed('status', 0);
		$this->set('currentFilterStatus', $this->filter['status']);

		$this->set('currentCategoryId', $this->filter['categoryId']);

		$this->set('currentYearMonth', $this->filter['yearMonth']);

		$this->setupBlogTitle();
		$this->loadBlockSetting();
		$this->loadFrameSetting();

		$this->setCategoryOptions();
		$this->setYearMonthOptions();

		if($this->viewVars['contentReadable']){
			$conditions = $this->BlogEntry->getConditions(
				$this->viewVars['blockId'],
				$this->Auth->user('id'),
				$this->viewVars,
				$this->getCurrentDateTime()
			);
			if($this->filter['status']){
				//  status絞り込み
				$conditions['BlogEntry.status'] = $this->filter['status'];
			}
			if($extraConditions){
				$conditions = Hash::merge($conditions, $extraConditions);
			}

			$this->Paginator->settings = array(
				'conditions' => $conditions,
				'limit' => $this->frameSetting['display_number'],
				'order' => 'published_datetime DESC',
				'joins' => array(
					array(
						'type' => 'LEFT',
						'table' => 'blog_entry_tag_links',
						'alias' => 'BlogEntryTagLink',
						'conditions' => '`BlogEntry`.`id`=`BlogEntryTagLink`.`blog_entry_id`', //ε(　　　　 v ﾟωﾟ)　＜タグ絞り込みしないときは不要
					)
				)
			);
			$this->BlogEntry->recursive = 0;
			$this->set('blogEntries', $this->Paginator->paginate());

		}else{
			// 何も見せない
		}
		$this->render('index');
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
			$this->BlogEntry->begin();
			$this->BlogEntry->create();
			// set status
			$status = $this->NetCommonsWorkflow->parseStatus();
			$this->request->data['BlogEntry']['status'] = $status;

			// set key
			// 新規の時
			$key = $this->BlogEntry->makeKey();
			$this->request->data['BlogEntry']['key'] = $key;
			try{
                if (! $this->BlogEntry->saveEntry($this->viewVars['blockId'], $this->request->data)) {

					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					// @codeCoverageIgnoreEnd
				}

				$this->BlogEntry->commit();

				$this->Session->setFlash(__('The blog entry has been saved.'));

				return $this->redirect(array('action' => 'view', $this->viewVars['frameId'], 'id' => $this->BlogEntry->id));

			}catch (Exception $e){
				$this->BlogEntry->rollback();
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

		$this->render('form');	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit() {
        $id = $this->request->params['named']['id'];
        $blogEntry = $this->BlogEntry->findById($id);
        if(empty($blogEntry)){
            // TODO 404 NotFound
            throw new NotFoundException();
            // 新規なら空配列作成
            //		$blogEntry = $this->BlogEntry->getNew();
        }


        if ($this->request->is(array('post', 'put'))) {
			$this->BlogEntry->begin();
			$this->BlogEntry->create();
			// set status
			$status = $this->NetCommonsWorkflow->parseStatus();
			$this->request->data['BlogEntry']['status'] = $status;

			try{
                $data = Hash::merge($blogEntry, $this->request->data);
				if (! $this->BlogEntry->saveEntry($this->viewVars['blockId'], $data)) {
					// @codeCoverageIgnoreStart
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					// @codeCoverageIgnoreEnd
				}

				$this->BlogEntry->commit();

				$this->Session->setFlash(__('The blog entry has been saved.'));

				return $this->redirect(array('action' => 'view', $this->viewVars['frameId'], 'id' => $this->BlogEntry->id));

			}catch (Exception $e){
				$this->BlogEntry->rollback();
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));

			}
		}else{

			$options = array('conditions' => array('BlogEntry.' . $this->BlogEntry->primaryKey => $id));
			$this->request->data = $this->BlogEntry->find('first', $options);
			$tags = $this->BlogTag->getTagsListByEntryId($this->request->data['BlogEntry']['id']);
			$this->request->data['BlogTag'] = $tags;
			// TODO 編集できる記事か？

		}
		//  このブロックのカテゴリだけに絞り込む
		$blogCategories = $this->BlogCategory->getCategoriesList($this->viewVars['blockId']);
		$this->set(compact('blogCategories'));

		$this->set('blogEntry', $blogEntry);

		$comments = $this->Comment->getComments(
			array(
				'plugin_key' => 'blogentries', // ε(　　　　 v ﾟωﾟ)　＜ Commentプラグインでセーブするときにモデル名をstrtolowerして複数形になおして保存してるのでこんな名前。なんとかしたい
				'content_key' => isset($blogEntry['BlogEntry']['key']) ? $blogEntry['BlogEntry']['key'] : null,
			)
		);
		$this->set('comments', $comments);

		$this->render('form');
	}


// ε(　　　　 v ﾟωﾟ)　＜　この下まだ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝



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
