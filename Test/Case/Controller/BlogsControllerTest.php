<?php
/**
 * BlogEntriesController Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsController', 'Blogs.Controller');
App::uses('BlogsAppControllerTest', 'Blogs.Test/Case/Controller');

/**
 * Summary for BlogEntriesController Test Case
 */
class BlogsControllerTest extends BlogsAppControllerTest {

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
 * ε(　　　　 v ﾟωﾟ)　＜ testIndex
 *
 * @return void
 */
	public function testIndex() {
		//$this->testAction(
		//	'/blogs/blog_entries/index/1',
		//	array(
		//		'method' => 'get',
		//		//'return' => 'view',
		//	)
		//);
		//$this->assertInternalType('array', $this->vars['blogEntries']);
	}

}
