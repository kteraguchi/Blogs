<?php
App::uses('BlogsAppController', 'Blogs.Controller');
/**
 * BlogCategories Controller
 *
 * @property BlogCategory $BlogCategory
 * @property PaginatorComponent $Paginator
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogCategoriesController extends BlogsAppController {

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
		$this->BlogCategory->recursive = 0;
		$this->set('blogCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->BlogCategory->exists($id)) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		$options = array('conditions' => array('BlogCategory.' . $this->BlogCategory->primaryKey => $id));
		$this->set('blogCategory', $this->BlogCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BlogCategory->create();
			if ($this->BlogCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The blog category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog category could not be saved. Please, try again.'));
			}
		}
		$blocks = $this->BlogCategory->Block->find('list');
		$this->set(compact('blocks'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->BlogCategory->exists($id)) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The blog category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogCategory.' . $this->BlogCategory->primaryKey => $id));
			$this->request->data = $this->BlogCategory->find('first', $options);
		}
		$blocks = $this->BlogCategory->Block->find('list');
		$this->set(compact('blocks'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->BlogCategory->id = $id;
		if (!$this->BlogCategory->exists()) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlogCategory->delete()) {
			$this->Session->setFlash(__('The blog category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->BlogCategory->recursive = 0;
		$this->set('blogCategories', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BlogCategory->exists($id)) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		$options = array('conditions' => array('BlogCategory.' . $this->BlogCategory->primaryKey => $id));
		$this->set('blogCategory', $this->BlogCategory->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BlogCategory->create();
			if ($this->BlogCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The blog category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog category could not be saved. Please, try again.'));
			}
		}
		$blocks = $this->BlogCategory->Block->find('list');
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
		if (!$this->BlogCategory->exists($id)) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The blog category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogCategory.' . $this->BlogCategory->primaryKey => $id));
			$this->request->data = $this->BlogCategory->find('first', $options);
		}
		$blocks = $this->BlogCategory->Block->find('list');
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
		$this->BlogCategory->id = $id;
		if (!$this->BlogCategory->exists()) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlogCategory->delete()) {
			$this->Session->setFlash(__('The blog category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
