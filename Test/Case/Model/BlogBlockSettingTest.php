<?php
/**
 * BlogBlockSetting Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogBlockSetting', 'Blogs.Model');

/**
 * Summary for BlogBlockSetting Test Case
 */
class BlogBlockSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_block_setting'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogBlockSetting = ClassRegistry::init('Blogs.BlogBlockSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogBlockSetting);

		parent::tearDown();
	}

}
