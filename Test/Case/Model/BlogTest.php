<?php
/**
 * Blog Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
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
