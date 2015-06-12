<?php
/**
 * Blog Test Case
 *
* @author Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link http://www.netcommons.org NetCommons Project
* @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Blog', 'Blogs.Model');

/**
 * Summary for Blog Test Case
 */
class BlogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog',
		'plugin.blogs.block',
		'plugin.blogs.user',
		'plugin.blogs.role',
		'plugin.blogs.group',
		'plugin.blogs.room',
		'plugin.blogs.space',
		'plugin.blogs.box',
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
		$this->Blog = ClassRegistry::init('Blogs.Blog');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Blog);

		parent::tearDown();
	}

/**
 * testGetBlog method
 *
 * @return void
 */
	public function testGetBlog() {
	}

/**
 * testSaveBlog method
 *
 * @return void
 */
	public function testSaveBlog() {
	}

/**
 * testValidateBlog method
 *
 * @return void
 */
	public function testValidateBlog() {
	}

/**
 * testDeleteBlog method
 *
 * @return void
 */
	public function testDeleteBlog() {
	}

}
