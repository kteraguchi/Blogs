<?php
/**
 * BlogSetting Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogSetting', 'Blogs.Model');

/**
 * Summary for BlogSetting Test Case
 */
class BlogSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_setting',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogSetting = ClassRegistry::init('Blogs.BlogSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogSetting);

		parent::tearDown();
	}

/**
 * testGetBlogSetting method
 *
 * @return void
 */
	public function testGetBlogSetting() {
	}

/**
 * testSaveBlogSetting method
 *
 * @return void
 */
	public function testSaveBlogSetting() {
	}

/**
 * testValidateBlogSetting method
 *
 * @return void
 */
	public function testValidateBlogSetting() {
	}

}
