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
		'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
		'mail_new_entry' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'mail new entry | メール通知を使う |   | '),
		'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'use comment | コメントを使う |  | '),
		'auto_approve_comment' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'use_sns' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'use sns | SNSボタンをつかう |   | '),
		'use_vote' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'use vote | 投票を使う |  | '),
		'use_minus_vote' => array('type' => 'boolean', 'null' => false, 'default' => null),
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
			'block_key' => 'block1',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 1,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 1,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 2,
			'block_key' => 'block2',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 2,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 2,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 3,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 3,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 3,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 4,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 4,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 4,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 5,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 5,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 5,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 6,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 6,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 6,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 7,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 7,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 7,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 8,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 8,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 8,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 9,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 9,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 9,
			'modified' => '2015-02-26 09:39:13'
		),
		array(
			'id' => 10,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'mail_new_entry' => 1,
			'use_comment' => 1,
			'auto_approve_comment' => 1,
			'use_sns' => 1,
			'use_vote' => 1,
			'use_minus_vote' => 1,
			'created_user' => 10,
			'created' => '2015-02-26 09:39:13',
			'modified_user' => 10,
			'modified' => '2015-02-26 09:39:13'
		),
	);

}
