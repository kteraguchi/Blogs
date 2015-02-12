<?php
App::uses('BlogsAppController', 'Blogs.Controller');
/**
 * BlogBlockSettings Controller
 *
 * @property BlogBlockSetting $BlogBlockSetting
 * @property PaginatorComponent $Paginator
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogBlockSettingsController extends BlogsAppController {

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
		$this->BlogBlockSetting->recursive = 0;
		$this->set('blogBlockSettings', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BlogBlockSetting->exists($id)) {
			throw new NotFoundException(__('Invalid blog block setting'));
		}
		$options = array('conditions' => array('BlogBlockSetting.' . $this->BlogBlockSetting->primaryKey => $id));
		$this->set('blogBlockSetting', $this->BlogBlockSetting->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BlogBlockSetting->create();
			if ($this->BlogBlockSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The blog block setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog block setting could not be saved. Please, try again.'));
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
		if (!$this->BlogBlockSetting->exists($id)) {
			throw new NotFoundException(__('Invalid blog block setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogBlockSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The blog block setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog block setting could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogBlockSetting.' . $this->BlogBlockSetting->primaryKey => $id));
			$this->request->data = $this->BlogBlockSetting->find('first', $options);
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
		$this->BlogBlockSetting->id = $id;
		if (!$this->BlogBlockSetting->exists()) {
			throw new NotFoundException(__('Invalid blog block setting'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlogBlockSetting->delete()) {
			$this->Session->setFlash(__('The blog block setting has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog block setting could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
