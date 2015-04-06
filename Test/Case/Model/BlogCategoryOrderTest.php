<?php
/**
 * BlogCategoryOrder Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogCategoryOrder', 'Blogs.Model');

/**
 * Summary for BlogCategoryOrder Test Case
 */
class BlogCategoryOrderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_category_order'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogCategoryOrder = ClassRegistry::init('Blogs.BlogCategoryOrder');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogCategoryOrder);

		parent::tearDown();
	}

}
