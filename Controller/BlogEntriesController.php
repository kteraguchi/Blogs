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
 */
class BlogEntriesController extends BlogsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->BlogEntry->recursive = 0;
		$this->set('blogEntries', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->BlogEntry->exists($id)) {
			throw new NotFoundException(__('Invalid blog entry'));
		}
		$options = array('conditions' => array('BlogEntry.' . $this->BlogEntry->primaryKey => $id));
		$this->set('blogEntry', $this->BlogEntry->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
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
