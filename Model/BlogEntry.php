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

	public $recursive = -1;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Trackable',
		'Tags.Tag',
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'BlogCategory' => array(
			'className' => 'Blogs.BlogCategory',
			'foreignKey' => 'blog_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	// TODO
	//public $hasAndBelongsToMany = array(
	//	'Tag' => array(
	//		'className' => 'Tags.Tag',
	//		'joinTable' => 'blog_entry_tag_links',
	//		'foreignKey' => 'blog_entry_id',
	//		'associationForeignKey' => 'blog_tag_id',
	//		'unique' => false,
	//		'dependent' => false,
	//		'with' => 'Blogs.BlogEntryTagLink',
	//		'conditions' => '',
	//		'fields' => '',
	//		'order' => '',
	//		'limit' => '',
	//		'offset' => '',
	//		'exclusive' => '',
	//		'finderQuery' => '',
	//		'counterQuery' => ''
	//	)
	//);

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
					'message' => __d('blogs', 'require title'),
					//'allowEmpty' => false,
					'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				],
			),
			'blog_category_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
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
 * TODO 考え方が違った。editable以上なら下書きも見られる
 * TODO 同一key 複数idへの対応
 * UserIdと権限から参照可能なEntryを取得するCondition配列を返す
 *
 * @param int $blockId ブロックID
 * @param int $userId アクセスユーザID
 * @param array $permissions 権限
 * @param datetime $currentDateTime 現在日時
 * @return array condition
 */
	public function getConditions($blockId, $userId, $permissions, $currentDateTime) {
		// デフォルト絞り込み条件
		$conditions = array(
			'BlogCategory.block_id' => $blockId
		);

		if ($permissions['contentEditable']) {
			// 編集権限
			$conditions['is_latest'] = 1;
			return $conditions;
		}

		if ($permissions['contentCreatable']) {
			// 作成権限
			$conditions['OR'] = array(
				$this->_getPublishedConditions($currentDateTime),
				'created_user' => $userId, // 自分のコンテンツはステータス関係なく閲覧可能
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
		$currentYearMonthDay = date('Y-m-01', strtotime($oldestEntry['BlogEntry']['published_datetime']));
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
 */
	public function saveEntry($blockId, $data) {
		$this->recursive = -1;

		$this->loadModels(array('Comment' => 'Comments.Comment'));
		$this->create(); // 常に新規登録
		if (($returnData = $this->save($data)) === false) {
			return false;
		}

		//if (isset($data['BlogTag'])) {
		//	if (!$this->BlogTag->saveEntryTags($blockId, $this->id, $data['BlogTag'])) {
		//		return false;
		//	}
		//}
		if (!$this->Comment->validateByStatus($data, array('caller' => $this->name))) {
			$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
			return false;
		} else {
			if ($this->Comment->data) {
				if (!$this->Comment->save(null, true)) {
					return false;
				}
			}
		}
		return $returnData;
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
				$currentIsActiveConditions = array(
					$this->name . '.origin_id' => $this->data[$this->name]['origin_id'],
					$this->name . '.language_id' => $this->data[$this->name]['language_id'],
					$this->name . '.is_active' => 1,
				);
				$this->updateAll(
					array(
						$this->name . '.is_active' => 0
					),
					$currentIsActiveConditions
				);
			}
		}
		if ($this->data[$this->name]['origin_id'] > 0) {
			//  今のis_latestを外す
			$currentIsLatestConditions = array(
				$this->name . '.origin_id' => $this->data[$this->name]['origin_id'],
				$this->name . '.language_id' => $this->data[$this->name]['language_id'],
				$this->name . '.is_latest' => 1,
			);
			$this->updateAll(
				array(
					$this->name . '.is_latest' => 0
				),
				$currentIsLatestConditions
			);
		}
		// 新規レコードを登録するときは必ずis_latest =1
		if (empty($this->data[$this->name]['id'])) {
			$this->data[$this->name]['is_latest'] = 1;
		}
		return true;
	}

/**
 * origin_idがセットされてなかったらorigin_id=idとしてアップデート
 *
 * @param bool $created created
 * @param array $options options
 * @return void
 */
	public function afterSave($created, $options = array()) {
		if ($created) {
			if (empty($this->data[$this->name]['origin_id'])) {
				// origin_id がセットされてなかったらkey=idでupdate
				$this->originId = $this->data[$this->name]['id'];
				$this->saveField('origin_id', $this->data[$this->name]['id'], array('callbacks' => false)); // ここで$this->dataがリセットされる
				//$this->data[$this->name]['origin_id'] = $this->data[$this->name]['id'];
				//$this->save($this->data, array('callbacks' => false));
				//$this->updateAll(array('origin_id' => $this->data[$this->name]['id']), array('id' => $this->data[$this->name]['id']));
			}
		}
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
