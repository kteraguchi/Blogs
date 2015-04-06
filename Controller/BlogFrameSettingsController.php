<?php
App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * BlogFrameSettings Controller
 *
 * @property BlogFrameSetting $BlogFrameSetting
 * @property PaginatorComponent $Paginator
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogFrameSettingsController extends BlogsAppController {

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
		$this->BlogFrameSetting->recursive = 0;
		$this->set('blogFrameSettings', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BlogFrameSetting->exists($id)) {
			throw new NotFoundException(__('Invalid blog frame setting'));
		}
		$options = array('conditions' => array('BlogFrameSetting.' . $this->BlogFrameSetting->primaryKey => $id));
		$this->set('blogFrameSetting', $this->BlogFrameSetting->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BlogFrameSetting->create();
			if ($this->BlogFrameSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The blog frame setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog frame setting could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->BlogFrameSetting->exists($id)) {
			throw new NotFoundException(__('Invalid blog frame setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogFrameSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The blog frame setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog frame setting could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogFrameSetting.' . $this->BlogFrameSetting->primaryKey => $id));
			$this->request->data = $this->BlogFrameSetting->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->BlogFrameSetting->id = $id;
		if (!$this->BlogFrameSetting->exists()) {
			throw new NotFoundException(__('Invalid blog frame setting'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlogFrameSetting->delete()) {
			$this->Session->setFlash(__('The blog frame setting has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog frame setting could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
