<?php
/**
 * BlogEntry Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogEntry', 'Blogs.Model');

CakePlugin::load('NetCommons');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
/**
 * Summary for BlogEntry Test Case
 */
class BlogEntryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_entry',
		'plugin.blogs.blog_category',
		'plugin.blogs.blog_entry_tag_link'
	);
s
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogEntry = ClassRegistry::init('Blogs.BlogEntry');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogEntry);

		parent::tearDown();
	}


	public function testGetCondition() {
		$userId = 1;
		$blockId = 2;
		$currentDateTime = '2015-01-01 00:00:00';
		// contentReadable false
		$permissions = array(
			'contentReadable'  => false,
			'contentCreatable' => false,
			'contentEditable'  => false,
		);
		$conditions = $this->BlogEntry->getConditions($blockId,
			$userId, $permissions, $currentDateTime);
		$this->assertSame($conditions, array(
			'BlogCategory.block_id' => $blockId,
			'BlogEntry.id' => 0
		));

		// contentReadable のみ
		$permissions = array(
			'contentReadable' => true,
			'contentCreatable' => false,
			'contentEditable'  => false,
		);
		$conditions = $this->BlogEntry->getConditions($blockId,$userId, $permissions, $currentDateTime);
		$this->assertSame($conditions, array(
			'BlogCategory.block_id' => $blockId,
			'BlogEntry.status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
			'BlogEntry.published_datetime <=' => $currentDateTime
		));

		// 作成権限あり
		$permissions = array(
			'contentReadable' => true,
			'contentCreatable' => true,
			'contentEditable'  => false,
		);
		$conditions = $this->BlogEntry->getConditions($blockId,$userId, $permissions, $currentDateTime);
		$this->assertSame($conditions,
			array(
				'BlogCategory.block_id' => $blockId,
				'OR' => array(
					array(
						'BlogEntry.status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
						'BlogEntry.published_datetime <=' => $currentDateTime
					),
					array(
						'BlogEntry.created_user' => $userId
					)
				)
			)
		);


		// 編集権限あり
		$permissions = array(
			'contentReadable' => true,
			'contentCreatable' => true,
			'contentEditable'  => true,
		);
		$conditions = $this->BlogEntry->getConditions($blockId, $userId, $permissions, $currentDateTime);
		$this->assertSame($conditions,
			array(
				'BlogCategory.block_id' => $blockId,
				'OR' => array(
					array(
						'BlogEntry.created_user' => $userId
					),
					array(
						'BlogEntry.status !=' => NetCommonsBlockComponent::STATUS_DRAFTED
					)
				)
			)
		);
	}


	public function testExecuteConditions() {
		$userId = 1;
		$blockId = 2;
		$currentDateTime = '2015-01-01 00:00:00';

		// contentReadable false
		$permissions = array(
			'contentReadable'  => false,
			'contentCreatable' => false,
			'contentEditable'  => false,
		);
		$conditions = $this->BlogEntry->getConditions($blockId,
			$userId, $permissions, $currentDateTime);

		$result = $this->BlogEntry->find('all', array('conditions' => $conditions));
		$this->assertSame($result, array());

		// contentReadable true
		$permissions = array(
			'contentReadable'  => true,
			'contentCreatable' => false,
			'contentEditable'  => false,
		);
		$conditions = $this->BlogEntry->getConditions($blockId,
			$userId, $permissions, $currentDateTime);

		$blogEntries = $this->BlogEntry->find('all', array('conditions' => $conditions));
		$this->assertEqual($blogEntries[0]['BlogEntry']['id'], 1);

		$publishedEntryIs1 = $this->BlogEntry->find('count', array('conditions' => $conditions));

		$this->assertEqual($publishedEntryIs1, 1);

	}

	public function testFind4CreatableUser() {
		$userId = 1;
		$blockId = 2;
		$currentDateTime = '2015-01-01 00:00:00';

		// contentCreatable true
		$permissions = array(
			'contentReadable'  => true,
			'contentCreatable' => true,
			'contentEditable'  => false,
		);
		$conditions = $this->BlogEntry->getConditions($blockId,
			$userId, $permissions, $currentDateTime);

		$blogEntries = $this->BlogEntry->find('all', array('conditions' => $conditions));

		$publishedAndMyEntriesAre3 = $this->BlogEntry->find('count', array('conditions' => $conditions));

		$this->assertEqual($publishedAndMyEntriesAre3, 3);

	}
	public function testFind4EditableUser() {
		$userId = 1;
		$blockId = 2;
		$currentDateTime = '2015-01-01 00:00:00';

		// contentCreatable true
		$permissions = array(
			'contentReadable'  => true,
			'contentCreatable' => true,
			'contentEditable'  => true,
		);
		$conditions = $this->BlogEntry->getConditions($blockId,
			$userId, $permissions, $currentDateTime);

		$blogEntries = $this->BlogEntry->find('all', array('conditions' => $conditions));

		$entriesAre4 = $this->BlogEntry->find('count', array('conditions' => $conditions));

		$this->assertEqual($entriesAre4, 4);

	}
}
