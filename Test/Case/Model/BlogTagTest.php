<?php
/**
 * BlogTag Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogTag', 'Blogs.Model');

/**
 * Summary for BlogTag Test Case
 */
class BlogTagTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_tag',
		'plugin.blogs.block',
		'plugin.blogs.blog_entry_tag_link'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogTag = ClassRegistry::init('Blogs.BlogTag');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogTag);

		parent::tearDown();
	}

}
