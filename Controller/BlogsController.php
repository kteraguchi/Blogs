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
            // contentReadable falseなら何も見えない


            // ε(　　　　 v ﾟωﾟ)　＜ Modelにうつしてテストする
            $conditions = array(
                'BlogCategory.block_id' => $this->viewVars['blockId'],
                'BlogEntry.published_datetime' => $this->getNow(), // ε(　　　　 v ﾟωﾟ)　＜今はどっかにどかしたい
            );
            if($this->viewVars['contentEditable']){
                // 他人の下書き以外は全部見られる
                // where NOT (status = 下書き AND created_user != 自分)
                $conditions['NOT'] = array(
                        'BlogEntry.status' => NetCommonsBlockComponent::STATUS_DRAFTED,
                        'BlogEntry.created_user !=' => $this->Auth->user('id')
                    );
            }elseif($this->viewVars['contentCreatable']){
                // 自分の＋公開が見える
                $conditions['BlogEntry.status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
                $conditions['BlogEntry.created_user'] = $this->Auth->user('id');
            }else{
                // 公開だけ見える
                $conditions['BlogEntry.status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
            }

            $this->Paginator->settings = array(
                'conditions' => $conditions,
                'limit' => 10,
                'order' => 'created DESC'
            );
            $this->BlogEntry->recursive = 0;
            $this->set('blogEntries', $this->Paginator->paginate());

        }else{
            // 何も見せない
        }

    }

}