<?php
App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * BlogEntries Controller
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
class BlogEntriesController extends BlogsAppController {

/**
 *
 */
	public $uses = array(
		'Blogs.BlogEntry',
		'Blogs.BlogBlockSetting',
		'Blogs.BlogCategory',
		'Comments.Comment',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		// ゲストアクセスOKのアクションを設定
		$this->Auth->allow('index', 'view', 'category', 'tag', 'year_month');
		parent::beforeFilter();
	}

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Paginator',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit', 'add'),
				'contentCreatable' => array('edit', 'add'),
			),
		)
	);

	protected $_filter = array(
		'categoryId' => 0,
		'status' => 0,
		'yearMonth' => 0,
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->_prepare();
		$this->set('listTitle', $this->_blogTitle);

		$this->_list();
	}

/**
 * カテゴリ別一覧
 *
 * @return void
 */
	public function category() {
		$this->_prepare();
		// indexとの違いはcategoryIdでの絞り込みをするだけ
		$this->_filter['categoryId'] = $this->getNamed('id', 0);

		// カテゴリ名をタイトルに
		$category = $this->BlogCategory->findById($this->_filter['categoryId']);
		$this->set('listTitle', __d('blogs', 'Category') . ':' . $category['BlogCategory']['name']);

		$conditions = array(
			'BlogEntry.blog_category_id' => $this->_filter['categoryId']
		);
		$this->_list($conditions);
	}

/**
 * tag別一覧
 *
 * @return void
 */
	public function tag() {
		$this->_prepare();
		// indexとのちがいはtagIdでの絞り込みだけ
		$tagId = $this->getNamed('id', 0);

		// カテゴリ名をタイトルに
		$tag = $this->BlogEntry->getTagByTagId($tagId);
		$this->set('listTitle', __d('blogs', 'Tag') . ':' . $tag['Tag']['name']);

		//$conditions = array(
		//	'BlogEntryTagLink.blog_tag_id' => $tagId // これを有効にするにはentry_tag_linkもJOINして検索か。
		//);
		$conditions = array(
			'Tag.id' => $tagId // これを有効にするにはentry_tag_linkもJOINして検索か。
		);

		// ε(　　　　 v ﾟωﾟ)　＜ここでPaginator条件セットするのはどうかなぁ。
		//$this->Paginator->settings['joins'][] =
		//	array(
		//		'type' => 'LEFT',
		//		'table' => 'blog_entry_tag_links',
		//		'alias' => 'BlogEntryTagLink',
		//		'conditions' => '`BlogEntry`.`id`=`BlogEntryTagLink`.`blog_entry_id`',
		//	);

		$this->_list($conditions);
	}

/**
 * 年月別一覧
 *
 * @return void
 */
	public function year_month() {
		$this->_prepare();
		// indexとの違いはyear_monthでの絞り込み
		$this->_filter['yearMonth'] = $this->getNamed('year_month', 0);

		// ε(　　　　 v ﾟωﾟ)　＜ 年月をタイトルに
		$this->set('listTitle', $this->_filter['yearMonth']);

		$first = $this->_filter['yearMonth'] . '-1';
		$last = date('Y-m-t', strtotime($first));

		$conditions = array(
			'BlogEntry.published_datetime BETWEEN ? AND ?' => array($first, $last)
		);
		$this->_list($conditions);
	}

/**
 * 設定等の呼び出し
 *
 * @return void
 */
	protected function _prepare() {
		$this->_setupBlogTitle();
		$this->loadBlockSetting();
		$this->loadFrameSetting();
	}

/**
 * 一覧
 *
 * @param array $extraConditions 追加conditions
 * @return void
 */
	protected function _list($extraConditions = array()) {
		$this->set('currentCategoryId', $this->_filter['categoryId']);

		$this->set('currentYearMonth', $this->_filter['yearMonth']);

		$this->_setCategoryOptions();
		$this->_setYearMonthOptions();

		if ($this->viewVars['contentReadable']) {
			$conditions = $this->BlogEntry->getConditions(
				$this->viewVars['blockId'],
				$this->Auth->user('id'),
				$this->viewVars,
				$this->_getCurrentDateTime()
			);
			if ($extraConditions) {
				$conditions = Hash::merge($conditions, $extraConditions);
			}

			$this->Paginator->settings = array_merge(
				$this->Paginator->settings,
				array(
					'conditions' => $conditions,
					'limit' => $this->_frameSetting['display_number'],
					'order' => 'published_datetime DESC',
					//
				)
			);
			$this->BlogEntry->recursive = 0;
			$this->set('blogEntries', $this->Paginator->paginate());

		} else {
			// 何も見せない
		}
		$this->render('index');
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @return void
 */
	public function view() {
		$this->loadBlockSetting();
		$this->loadFrameSetting();

		$originId = $this->request->params['named']['origin_id'];
		if ($this->viewVars['contentReadable']) {
			$conditions = $this->BlogEntry->getConditions(
				$this->viewVars['blockId'],
				$this->Auth->user('id'),
				$this->viewVars,
				$this->_getCurrentDateTime()
			);

			$conditions['BlogEntry.origin_id'] = $originId;

		} else {
			// 何も見せない
			throw new NotFoundException(__('Invalid blog entry'));
		}
		$options = array('conditions' => $conditions, 'recursive' => 0);
		$blogEntry = $this->BlogEntry->find('first', $options);
		if ($blogEntry) {
			$this->set('blogEntry', $blogEntry);
			// tag取得
			//$blogTags = $this->BlogTag->getTagsByEntryId($blogEntry['BlogEntry']['id']);
			//$this->set('blogTags', $blogTags);

			// ε(　　　　 v ﾟωﾟ)　＜ コメント取得

		} else {
			// 表示できない記事へのアクセスなら403
			throw new NotFoundException(__('Invalid blog entry'));
		}
	}

/**
 * カテゴリ選択肢をViewへセット
 *
 * @return void
 */
	protected function _setCategoryOptions() {
		$categories = $this->BlogCategory->getCategories($this->viewVars['blockId']);
		$options = array(
			0 => __d('blogs', 'All categories'),
		);
		foreach ($categories as $category) {
			$options[$category['BlogCategory']['id']] = $category['BlogCategory']['name'];
		}
		$this->set('categoryOptions', $options);
	}

/**
 * 年月選択肢をViewへセット
 *
 * @return void
 */
	protected function _setYearMonthOptions() {
		// 年月と記事数
		$yearMonthCount = $this->BlogEntry->getYearMonthCount(
			$this->viewVars['blockId'],
			$this->Auth->user('id'),
			$this->viewVars,
			$this->_getCurrentDateTime()
		);
		$options = array(
			0 => '----'
		);
		foreach ($yearMonthCount as $yearMonth => $count) {
			list($year, $month) = explode('-', $yearMonth);
			$options[$yearMonth] = __d('blogs', '%d-%d (%s)', $year, $month, $count);
		}
		$this->set('yearMonthOptions', $options);
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
					array('action' => 'view', $this->viewVars['frameId'], 'origin_id' => $this->BlogEntry->originId)
				);

			} catch (Exception $e) {
				$this->BlogEntry->rollback();
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));

			}
		} else {
			$this->request->data['Tag'] = array();
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
				//  ここでマージしちゃうとTag配列を減らせなくなるので取りやめ
				//$data = Hash::merge($blogEntry, $this->request->data);
				$data = $this->request->data;

				unset($data['BlogEntry']['id']); // 常に新規保存
				if (!$this->BlogEntry->saveEntry($this->viewVars['blockId'], $data)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}

				$this->BlogEntry->commit();

				$this->Session->setFlash(__('The blog entry has been saved.'));
				return $this->redirect(
					array('action' => 'view', $this->viewVars['frameId'], 'origin_id' => $data['BlogEntry']['origin_id'])
				);

			} catch (Exception $e) {
				$this->BlogEntry->rollback();
				$this->Session->setFlash(__('The blog entry could not be saved. Please, try again.'));

			}
		} else {

			$this->request->data = $blogEntry;
			// ε(　　　　 v ﾟωﾟ)　＜ 編集できる記事か？

		}
		//  このブロックのカテゴリだけに絞り込む
		$blogCategories = $this->BlogCategory->getCategoriesList($this->viewVars['blockId']);
		$this->set(compact('blogCategories'));

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
		$originId = $this->getNamed('origin_id', 0);

		$this->request->onlyAllow('post', 'delete');

		if ($this->BlogEntry->deleteEntryByOriginId($originId)) {
			$this->Session->setFlash(__('The blog entry has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog entry could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
