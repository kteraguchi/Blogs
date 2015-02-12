<?php
/**
 * BlogBlockSettingFixture
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for BlogBlockSettingFixture
 */
class BlogBlockSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
		'blog_title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'blog title | ブログタイトル |  | 
', 'charset' => 'utf8'),
		'mail_new_entry' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'mail new entry | メール通知を使う |   | '),
		'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'use comment | コメントを使う |  | '),
		'auto_approve_comment' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'use_sns' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'use sns | SNSボタンをつかう |   | '),
		'use_vote' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'use vote | 投票を使う |  | '),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'frame_key' => 'Lorem ipsum dolor sit amet',
			'blog_title' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'created_user' => 1,
			'created' => '2015-02-12 10:51:11',
			'modified_user' => 1,
			'modified' => '2015-02-12 10:51:11'
		),
	);

}
