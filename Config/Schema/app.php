<?php

class AppSchema extends CakeSchema {

/**
 * before
 *
 * @param array $event savent
 * @return bool
 */
	public function before($event = array()) {
		return true;
	}

/**
 * after
 *
 * @param array $event event
 * @return void
 */
	public function after($event = array()) {
	}

	public $blog_block_settings = array(
		'id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'key' => 'primary',
			'comment' => 'ID |  |  | '
		),
		'block_key' => array(
			'type' => 'string',
			'null' => false,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'frame key | フレームKey | frames.key | ',
			'charset' => 'utf8'
		),
		'mail_new_entry' => array(
			'type' => 'boolean',
			'null' => false,
			'default' => '0',
			'comment' => 'mail new entry | メール通知を使う |   | '
		),
		'use_comment' => array(
			'type' => 'boolean',
			'null' => false,
			'default' => '0',
			'comment' => 'use comment | コメントを使う |  | '
		),
		'auto_approve_comment' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'use_sns' => array(
			'type' => 'boolean',
			'null' => false,
			'default' => '0',
			'comment' => 'use sns | SNSボタンをつかう |   | '
		),
		'use_vote' => array(
			'type' => 'boolean',
			'null' => false,
			'default' => '0',
			'comment' => 'use vote | 投票を使う |  | '
		),
		'use_minus_vote' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'created_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'created user | 作成者 | users.id | '
		),
		'created' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'created datetime | 作成日時 |  | '
		),
		'modified_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'modified user | 更新者 | users.id | '
		),
		'modified' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'modified datetime | 更新日時 |  | '
		),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $blog_categories = array(
		'id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'key' => 'primary',
			'comment' => 'ID |  |  | '
		),
		'block_id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'comment' => 'block id |  ブロックID | blocks.id | '
		),
		'key' => array(
			'type' => 'string',
			'null' => false,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'category key | カテゴリーKey |  | ',
			'charset' => 'utf8'
		),
		'name' => array(
			'type' => 'string',
			'null' => true,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'category name | カテゴリー名 |  | ',
			'charset' => 'utf8'
		),
		'created_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'created user | 作成者 | users.id | '
		),
		'created' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'created datetime | 作成日時 |  | '
		),
		'modified_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'modified user | 更新者 | users.id | '
		),
		'modified' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'modified datetime | 更新日時 |  | '
		),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $blog_category_orders = array(
		'id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'key' => 'primary',
			'comment' => 'ID |  |  | '
		),
		'blog_category_key' => array(
			'type' => 'string',
			'null' => false,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'category key | カテゴリーKey | blog_categories.key | ',
			'charset' => 'utf8'
		),
		'block_key' => array(
			'type' => 'string',
			'null' => false,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'block key | ブロックKey | blocks.key | ',
			'charset' => 'utf8'
		),
		'weight' => array(
			'type' => 'integer',
			'null' => false,
			'default' => '0',
			'comment' => 'The weight of the display(display order) | 表示の重み(表示順序) |  | '
		),
		'created_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'created user | 作成者 | users.id | '
		),
		'created' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'created datetime | 作成日時 |  | '
		),
		'modified_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'modified user | 更新者 | users.id | '
		),
		'modified' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'modified datetime | 更新日時 |  | '
		),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $blog_entries = array(
		'id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'key' => 'primary',
			'comment' => 'ID |  |  | '
		),
		'blog_category_id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'comment' => 'category id | カテゴリーID | blog_categories.id | '
		),
		'key' => array(
			'type' => 'string',
			'null' => false,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'entry key | エントリーキー | Hash値 | ',
			'charset' => 'utf8'
		),
		'status' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'length' => 4,
			'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '
		),
		'title' => array(
			'type' => 'string',
			'null' => true,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'title | タイトル |  | ',
			'charset' => 'utf8'
		),
		'body1' => array(
			'type' => 'text',
			'null' => true,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'entry body1 | 本文1 |  | ',
			'charset' => 'utf8'
		),
		'body2' => array(
			'type' => 'text',
			'null' => true,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'entry body2 | 本文2 |  | ',
			'charset' => 'utf8'
		),
		'plus_vote_number' => array(
			'type' => 'integer',
			'null' => false,
			'default' => '0',
			'comment' => 'plus vote number | プラス投票数 |  | '
		),
		'minus_vote_number' => array(
			'type' => 'integer',
			'null' => false,
			'default' => '0',
			'comment' => 'minus vote number | マイナス投票数 |  | '
		),
		'published_datetime' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'is_auto_translated' => array(
			'type' => 'boolean',
			'null' => false,
			'default' => '0',
			'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '
		),
		'translation_engine' => array(
			'type' => 'string',
			'null' => true,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'translation engine | 翻訳エンジン |  | ',
			'charset' => 'utf8'
		),
		'created_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => '0',
			'comment' => 'created user | 作成者 | users.id | '
		),
		'created' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'created datetime | 作成日時 |  | '
		),
		'modified_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => '0',
			'comment' => 'modified user | 更新者 | users.id | '
		),
		'modified' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'modified datetime | 更新日時 |  | '
		),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $blog_entry_tag_links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'blog_entry_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 45),
		'blog_tag_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 45),
		'created_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'created user | 作成者 | users.id | '
		),
		'created' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'created datetime | 作成日時 |  | '
		),
		'modified_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'modified user | 更新者 | users.id | '
		),
		'modified' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'modified datetime | 更新日時 |  | '
		),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $blog_frame_settings = array(
		'id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'key' => 'primary',
			'comment' => 'ID |  |  | '
		),
		'frame_key' => array(
			'type' => 'string',
			'null' => false,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'frame key | フレームKey | frames.key | ',
			'charset' => 'utf8'
		),
		'display_number' => array(
			'type' => 'integer',
			'null' => false,
			'default' => '10',
			'comment' => 'display number | 表示件数 |  | '
		),
		'created_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'created user | 作成者 | users.id | '
		),
		'created' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'created datetime | 作成日時 |  | '
		),
		'modified_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'modified user | 更新者 | users.id | '
		),
		'modified' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'modified datetime | 更新日時 |  | '
		),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $blog_tags = array(
		'id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'key' => 'primary',
			'comment' => 'ID |  |  | '
		),
		'block_id' => array(
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'comment' => 'block id |  ブロックID | blocks.id | '
		),
		'key' => array(
			'type' => 'string',
			'null' => false,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'tag key | タグKey |  | ',
			'charset' => 'utf8'
		),
		'name' => array(
			'type' => 'string',
			'null' => true,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'comment' => 'tag name | タグ名 |  | ',
			'charset' => 'utf8'
		),
		'created_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'created user | 作成者 | users.id | '
		),
		'created' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'created datetime | 作成日時 |  | '
		),
		'modified_user' => array(
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'comment' => 'modified user | 更新者 | users.id | '
		),
		'modified' => array(
			'type' => 'datetime',
			'null' => true,
			'default' => null,
			'comment' => 'modified datetime | 更新日時 |  | '
		),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
