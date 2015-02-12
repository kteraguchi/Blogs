<?php
/**
 * BlogCategory Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogCategory', 'Blogs.Model');

/**
 * Summary for BlogCategory Test Case
 */
class BlogCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_category',
		'plugin.blogs.block',
		'plugin.blogs.blog_entry'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogCategory = ClassRegistry::init('Blogs.BlogCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogCategory);

		parent::tearDown();
	}

}
