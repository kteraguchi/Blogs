<?php
App::uses('BlogsAppController', 'Blogs.Controller');
/**
 * Blogs Controller
 *
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogsController extends BlogsAppController {

    /**
     * use components
     *
     * @var array
     */
    public $components = array(
        'NetCommons.NetCommonsBlock', //Use Announcement model
        'NetCommons.NetCommonsFrame',
        'NetCommons.NetCommonsRoomRole' => array(
            //コンテンツの権限設定
            'allowedActions' => array(
                'contentEditable' => array('setting', 'token', 'edit')
            ),
            //コンテンツのワークフロー設定(公開権限チェック)
            'workflowActions' => array('edit'),
            'workflowModelName' => 'Announcement',
        ),
        'Paginator',
    );


    public $uses = array(
        'Blogs.BlogEntry'
    );

    /**
 * Scaffold
 *
 * @var mixed
 */
    public function index(){
        if($this->viewVars['contentReadable']){
			$conditions = $this->BlogEntry->getConditions(
				$this->viewVars['blockId'],
				$this->Auth->user('id'),
				$this->viewVars,
				$this->getCurrentDateTime()
			);

            $this->Paginator->settings = array(
                'conditions' => $conditions,
                'limit' => 10,
                'order' => 'published_datetime DESC'
            );
            $this->BlogEntry->recursive = 0;
            $this->set('blogEntries', $this->Paginator->paginate());

        }else{
            // 何も見せない
        }

    }

}