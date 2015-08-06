<?php
/**
 * BlogEntry Model
 *
 * @property BlogCategory $BlogCategory
 * @property BlogEntryTagLink $BlogEntryTagLink
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsAppModel', 'Blogs.Model');

/**
 * Summary for BlogEntry Model
 */
class BlogEntry extends BlogsAppModel {

/**
 * @var int recursiveはデフォルトアソシエーションなしに
 */
	public $recursive = -1;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Trackable',
		'Tags.Tag',
		'NetCommons.OriginalKey',
		'Likes.Like'
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CategoryOrder' => array(
			'className' => 'Categories.CategoryOrder',
			'foreignKey' => false,
			'conditions' => 'CategoryOrder.category_key=Category.key',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * バリデーションルールを返す
 *
 * @return array
 */
	protected function _getValidateSpecification() {
		$validate = array(
			'title' => array(
				'title' => [
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('blogs', 'Title')),
					//'allowEmpty' => false,
					'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				],
			),
			'body1' => array(
				'body1' => [
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('blogs', 'Body1')),
					//'allowEmpty' => false,
					'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				],
			),
			'published_datetime' => array(
				'published_datetime' => [
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('blogs', 'Published datetime')),
					//'allowEmpty' => false,
					'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				],
			),
			'category_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					'allowEmpty' => true,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			//'key' => array(
			//	'notEmpty' => array(
			//		'rule' => array('notEmpty'),
			//		//'message' => 'Your custom message here',
			//		//'allowEmpty' => false,
			//		//'required' => false,
			//		//'last' => false, // Stop validation after this rule
			//		//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//	),
			//),
			'status' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'is_auto_translated' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
		return $validate;
	}

/**
 * 空の新規データを返す
 *
 * @return array
 */
	public function getNew() {
		$new = parent::getNew();
		$new['BlogEntry']['published_datetime'] = date('Y-m-d H:i:s');
		return $new;
	}
/**
 * ε(　　　　 v ﾟωﾟ)　＜ 考え方が違った。editable以上なら下書きも見られる
 * ε(　　　　 v ﾟωﾟ)　＜ 同一key 複数idへの対応
 * UserIdと権限から参照可能なEntryを取得するCondition配列を返す
 *
 * @param int $blockId ブロックId
 * @param int $userId アクセスユーザID
 * @param array $permissions 権限
 * @param datetime $currentDateTime 現在日時
 * @return array condition
 */
	public function getConditions($blockId, $userId, $permissions, $currentDateTime) {
		// デフォルト絞り込み条件
		$conditions = array(
			'BlogEntry.block_id' => $blockId
		);

		if ($permissions['contentEditable']) {
			// 編集権限
			$conditions['BlogEntry.is_latest'] = 1;
			return $conditions;
		}

		if ($permissions['contentCreatable']) {
			// 作成権限
			$conditions['OR'] = array(
				array_merge(
					$this->_getPublishedConditions($currentDateTime),
					array('BlogEntry.created_user !=' => $userId)
				),
				array('BlogEntry.created_user' => $userId,
						'BlogEntry.is_latest' => 1)
			);
			return $conditions;
		}

		if ($permissions['contentReadable']) {
			// 公開中コンテンツだけ
			$conditions = array_merge(
				$conditions,
				$this->_getPublishedConditions($currentDateTime));
			return $conditions;
		}

		// contentReadable falseなら何も見えない
		$conditions = array_merge(
			$conditions,
			array('BlogEntry.id' => 0) // ありえない条件でヒット0にしてる
		);

		return $conditions;
	}

/**
 * 年月毎の記事数を返す
 *
 * @param int $blockId ブロックID
 * @param int $userId ユーザID
 * @param array $permissions 権限
 * @param datetime $currentDateTime 現在日時
 * @return array
 */
	public function getYearMonthCount($blockId, $userId, $permissions, $currentDateTime) {
		$conditions = $this->getConditions($blockId, $userId, $permissions, $currentDateTime);
		// 年月でグループ化してカウント→取得できなかった年月をゼロセット
		$this->virtualFields['year_month'] = 0; // バーチャルフィールドを追加
		$this->virtualFields['count'] = 0; // バーチャルフィールドを追加
		//$this->recursive = 0;
		$result = $this->find(
			'all',
			array(
				'fields' => array(
					'DATE_FORMAT(BlogEntry.published_datetime, \'%Y-%m\') AS BlogEntry__year_month',
					'count(*) AS BlogEntry__count'
				),
				'conditions' => $conditions,
				'group' => array('BlogEntry__year_month'), //GROUP BY YEAR(record_date), MONTH(record_date)
				'recursive' => 0,
			)
		);
		$ret = array();
		// $retをゼロ埋め
		//　一番古い記事を取得
		$oldestEntry = $this->find('first',
			array(
				'conditions' => $conditions,
				'order' => 'published_datetime ASC',
				'recursive' => 0,
			)
		);
		// 一番古い記事の年月から現在までを先にゼロ埋め
		if (isset($oldestEntry['BlogEntry'])) {
			$currentYearMonthDay = date('Y-m-01', strtotime($oldestEntry['BlogEntry']['published_datetime']));
		} else {
			$currentYearMonthDay = date('Y-m-01');
		}
		while ($currentYearMonthDay <= $currentDateTime) {
			$ret[substr($currentYearMonthDay, 0, 7)] = 0;
			$currentYearMonthDay = date('Y-m-01', strtotime($currentYearMonthDay . ' +1 month'));
		}

		// 記事がある年月は記事数を上書きしておく
		foreach ($result as $yearMonth) {
			$ret[$yearMonth['BlogEntry']['year_month']] = $yearMonth['BlogEntry']['count'];
		}

		//年月降順に並び替える
		krsort($ret);
		return $ret;
	}

/**
 * 記事の保存。タグも保存する
 *
 * @param int $blockId ブロックID
 * @param array $data 登録データ
 * @return bool
 * @throws InternalErrorException
 */
	public function saveEntry($blockId, $data) {
		$this->begin();
		try {
			$this->recursive = -1;

			$this->loadModels(array('Comment' => 'Comments.Comment'));
			$this->create(); // 常に新規登録
			// 先にvalidate 失敗したらfalse返す
			$this->set($data);
			if (!$this->validates($data)) {
				$this->rollback();
				return false;
			}
			if (($savedData = $this->save($data, false)) === false) {
				//このsaveで失敗するならvalidate以外なので例外なげる
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// validate comment
			if (!$this->Comment->validateByStatus($savedData, array('caller' => $this->name))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				$this->rollback();
				return false;
			}

			//コメントの登録
			if ($this->Comment->data) {
				if (! $this->Comment->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			$this->commit();
			return $savedData;

		} catch (Exception $e) {
			$this->rollback();
			//エラー出力
			CakeLog::error($e);
			throw $e;
		}
	}

/**
 * beforeSave ステータスが公開になったらis_activeをつけなおす
 *
 * @param array $options beforeSave options
 * @return bool
 */
	public function beforeSave($options = array()) {
		//  beforeSave はupdateAllでも呼び出される。
		if (isset($this->data[$this->name]['id']) && ($this->data[$this->name]['id'] > 0)) {
			// updateのときは何もしない
			return true;
		}
		if ($this->data[$this->name]['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED) {
			// statusが公開ならis_activeを付け替える
			//  is_activeをセットする
			$this->data[$this->name]['is_active'] = 1;
			if ($this->data[$this->name]['origin_id'] > 0) {
				// 今のis_activeを外す（同じorigin_id, 同じlanguage_id）
				$isActiveConditions = array(
					$this->name . '.origin_id' => $this->data[$this->name]['origin_id'],
					$this->name . '.language_id' => $this->data[$this->name]['language_id'],
					$this->name . '.is_active' => 1,
				);
				$this->updateAll(
					array(
						$this->name . '.is_active' => 0
					),
					$isActiveConditions
				);
			}
		}
		if ($this->data[$this->name]['origin_id'] > 0) {
			//  今のis_latestを外す
			$isLatestConditions = array(
				$this->name . '.origin_id' => $this->data[$this->name]['origin_id'],
				$this->name . '.language_id' => $this->data[$this->name]['language_id'],
				$this->name . '.is_latest' => 1,
			);
			$this->updateAll(
				array(
					$this->name . '.is_latest' => 0
				),
				$isLatestConditions
			);
		}
		// 新規レコードを登録するときは必ずis_latest =1
		if (empty($this->data[$this->name]['id'])) {
			$this->data[$this->name]['is_latest'] = 1;
		}
		return true;
	}

/**
 * 記事削除
 *
 * @param int $originId オリジンID
 * @return bool
 */
	public function deleteEntryByOriginId($originId) {
		// ε(　　　　 v ﾟωﾟ)　＜タグリンク削除
		// 記事削除
		$conditions = array('origin_id' => $originId);
		return $this->deleteAll($conditions, true, true);
	}

/**
 * 公開データ取得のconditionsを返す
 *
 * @param datetime $currentDateTime 現在の日時
 * @return array
 */
	protected function _getPublishedConditions($currentDateTime) {
		return array(
			$this->name . '.is_active' => 1,
			'BlogEntry.published_datetime <=' => $currentDateTime,
		);
	}

}
