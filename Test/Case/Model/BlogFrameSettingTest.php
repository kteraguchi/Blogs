<?php
/**
 * BlogFrameSetting Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogFrameSetting', 'Blogs.Model');

/**
 * Summary for BlogFrameSetting Test Case
 */
class BlogFrameSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blogs.blog_frame_setting'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogFrameSetting = ClassRegistry::init('Blogs.BlogFrameSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogFrameSetting);

		parent::tearDown();
	}

}
