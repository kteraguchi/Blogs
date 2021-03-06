<?php
/**
 * BlogAppModel
 */
App::uses('AppModel', 'Model');

/**
 * Class BlogsAppModel
 */
class BlogsAppModel extends AppModel {

/**
 * @var null 新規空データ
 */
	protected $_newRecord = null;

/**
 * プラリマリキーを除いた新規レコード配列を返す
 * ex) array('ModelName' => array('filedName' => default, ...));
 * 
 * @return array
 */
	public function getNew() {
		if (is_null($this->_newRecord)) {
			$newRecord = array();
			foreach ($this->_schema as $fieldName => $fieldDetail) {
				if ($fieldName != $this->primaryKey) {
					$newRecord[$this->name][$fieldName] = $fieldDetail['default'];
				}
			}
			$this->_newRecord = $newRecord;
		}
		return $this->_newRecord;
	}

/**
 * transaction begin
 *
 * @return void
 */
	public function begin() {
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();
	}

/**
 * transaction commit
 *
 * @return void
 */
	public function commit() {
		$dataSource = $this->getDataSource();
		$dataSource->commit();
	}

/**
 * transaction rollback
 *
 * @return void
 */
	public function rollback() {
		$dataSource = $this->getDataSource();
		$dataSource->rollback();
	}

/**
 * バリデートメッセージ多言語化対応のためのラップ
 *
 * @param array $options options
 * @return bool
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge(
			$this->validate,
			$this->_getValidateSpecification()
		);

		return parent::beforeValidate($options);
	}

/**
 * バリデート仕様を返す（継承した各モデルで実装）
 *
 * @return array
 */
	protected function _getValidateSpecification() {
		return array();
	}

}
