<?php
App::uses('BlogsAppController', 'Blogs.Controller');
/**
 * BlogTags Controller
 *
 * @property BlogTag $BlogTag
 * @property PaginatorComponent $Paginator
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogTagsController extends BlogsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->BlogTag->recursive = 0;
		$this->set('blogTags', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BlogTag->exists($id)) {
			throw new NotFoundException(__('Invalid blog tag'));
		}
		$options = array('conditions' => array('BlogTag.' . $this->BlogTag->primaryKey => $id));
		$this->set('blogTag', $this->BlogTag->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BlogTag->create();
			if ($this->BlogTag->save($this->request->data)) {
				$this->Session->setFlash(__('The blog tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog tag could not be saved. Please, try again.'));
			}
		}
		$blocks = $this->BlogTag->Block->find('list');
		$this->set(compact('blocks'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->BlogTag->exists($id)) {
			throw new NotFoundException(__('Invalid blog tag'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogTag->save($this->request->data)) {
				$this->Session->setFlash(__('The blog tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog tag could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogTag.' . $this->BlogTag->primaryKey => $id));
			$this->request->data = $this->BlogTag->find('first', $options);
		}
		$blocks = $this->BlogTag->Block->find('list');
		$this->set(compact('blocks'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->BlogTag->id = $id;
		if (!$this->BlogTag->exists()) {
			throw new NotFoundException(__('Invalid blog tag'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlogTag->delete()) {
			$this->Session->setFlash(__('The blog tag has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog tag could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
