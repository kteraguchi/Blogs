<?php
/**
 * BlogEntryTagLink Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogEntryTagLink', 'Blogs.Model');

/**
 * Summary for BlogEntryTagLink Test Case
 */
class BlogEntryTagLinkTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_entry_tag_link',
		'plugin.blogs.blog_entry',
		'plugin.blogs.blog_tag'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogEntryTagLink = ClassRegistry::init('Blogs.BlogEntryTagLink');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogEntryTagLink);

		parent::tearDown();
	}

}
