<?php
/**
 * BlogSetting Test Case
 *
* @author Jun Nishikawa <topaz2@m0n0m0n0.com>
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
		'plugin.blogs.user',
		'plugin.blogs.role',
		'plugin.blogs.group',
		'plugin.blogs.room',
		'plugin.blogs.space',
		'plugin.blogs.box',
		'plugin.blogs.block',
		'plugin.blogs.page',
		'plugin.blogs.language',
		'plugin.blogs.groups_language',
		'plugin.blogs.groups_user',
		'plugin.blogs.user_attribute',
		'plugin.blogs.user_attributes_user',
		'plugin.blogs.user_select_attribute',
		'plugin.blogs.user_select_attributes_user'
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
