<?php
App::uses('BlogsAppController', 'Blogs.Controller');
/**
 * Blogs Controller
 *
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 *
 * @property BlogEntry $BlogEntry
 */
class BlogsController extends BlogsAppController {

	public $components = array(
		'Paginator',
	);

    public $uses = array(
        'Blogs.BlogEntry',
        'Blogs.BlogBlockSetting',
		'Blogs.BlogCategory',
    );

    /**
 * Scaffold
 *
 * @var mixed
 */
    public function index(){
		$frameId = $this->viewVars['frameId'];
		$html = $this->requestAction(array('controller' => 'blog_entries', 'action' => 'index', $frameId), array('return'));

		$this->set('html', $html);
		return;

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

}