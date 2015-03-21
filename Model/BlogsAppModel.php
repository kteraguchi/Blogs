<?php

App::uses('AppModel', 'Model');

class BlogsAppModel extends AppModel {

	protected $newRecord = null;

	/**
	 * プラリマリキーを除いた新規レコード配列を返す
	 * ex) array('ModelName' => array('filedName' => default, ...));
	 * @return array
	 */
	public function getNew() {
		if(is_null($this->newRecord)){
			$newRecord = array();
			foreach($this->_schema as $fieldName => $fieldDetail){
				if($fieldName != $this->primaryKey){
					$newRecord[$this->name][$fieldName] = $fieldDetail['default'];
				}
			}
		}
		return $this->newRecord;
	}

	public function makeKey() {
		$className = get_class($this);
		return (Security::hash($className . mt_rand() . microtime(), 'md5'));
	}

	public function begin() {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
	}
	public function commit() {
		$dataSource = $this->getDataSource();
		$dataSource->commit();

	}
	public function rollback() {
		$dataSource = $this->getDataSource();
		$dataSource->rollback();
	}


	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate,
			$this->getValidateSpecification()
		);

		return parent::beforeValidate($options);
	}

	protected function getValidateSpecification() {
		return array();
	}

}
