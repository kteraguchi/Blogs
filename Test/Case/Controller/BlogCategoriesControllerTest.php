<?php
/**
 * BlogCategoriesController Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogCategoriesController', 'Blogs.Controller');

/**
 * Summary for BlogCategoriesController Test Case
 */
class BlogCategoriesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_category',
		'plugin.blogs.blog_entry',
	);

/**
 * testIndex
 *
 * @return void
 */
	public function testIndex() {
	}
}
