<?php
/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 15/05/18
 * Time: 9:56
 */

App::uses('BlogsController', 'Blogs.Controller');
App::uses('BlogsAppControllerTest', 'Blogs.Test/Case/Controller');

/**
 * BlogsController Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Blogs\Test\Case\Controller
 */
class BlogsEntriesEditControllerTest extends BlogsAppControllerTest {

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
		$this->generate(
			'Blogs.Blogs',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		Configure::write('Config.language', null);
		CakeSession::write('Auth.User', null);
		parent::tearDown();
	}


	public function testAddFormNoDeleteButton() {
		RolesControllerTest::login($this);

		$view = $this->testAction(
			'/blogs/blogs/index/1',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);
debug($view);
		//$this->assertTextContains('nc-announcements-1', $view, print_r($view, true));

		AuthGeneralControllerTest::logout($this);
	}
}

