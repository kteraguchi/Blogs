<?php
/**
 * BlogEntriesController Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogEntriesController', 'Blogs.Controller');
App::uses('BlogsAppControllerTest', 'Blogs.Test/Case/Controller');

/**
 * Summary for BlogEntriesController Test Case
 */
class BlogEntriesControllerTest extends BlogsAppControllerTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
		//$this->generate(
		//	'Blogs.BlogEntries',
		//	[
		//		'components' => [
		//			'Auth' => ['user'],
		//			'Session',
		//			'Security',
		//		]
		//	]
		//);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//Configure::write('Config.language', null);
		//CakeSession::write('Auth.User', null);
		parent::tearDown();
	}

/**
 * testIndex
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction(
			'/blogs/blog_entries/index/1',
			array(
				'method' => 'get',
				//'return' => 'view',
			)
		);
		$this->assertInternalType('array', $this->vars['blogEntries']);
	}


	public function testIndexTitle() {
		$return = $this->testAction(
			'/blogs/blog_entries/index/1',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);
		$this->assertRegExp('/<h1.*>ブログ名<\/h1>/', $return);

	}

/**
 * testTag
 *
 * @return void
 */
	public function testTag() {
		$this->testAction(
			'/blogs/blog_entries/tag/1/id:1',
			array(
				'method' => 'get',
				//'return' => 'view',
			)
		);
		$this->assertInternalType('array', $this->vars['blogEntries']);
	}

/**
 * testYearMonth
 *
 * @return void
 */
	public function testYearMonth() {
		$this->testAction(
			'/blogs/blog_entries/year_month/1/year_month:2014-02',
			array(
				'method' => 'get',
				//'return' => 'view',
			)
		);
		$this->assertInternalType('array', $this->vars['blogEntries']);
	}

/**
 * testView
 *
 * @return void
 */
	public function testView() {
		$this->testAction(
			'/blogs/blog_entries/view/1/origin_id:1',
			array(
				'method' => 'get',
				//'return' => 'view',
			)
		);
		$this->assertInternalType('array', $this->vars['blogEntry']);
	}

}
