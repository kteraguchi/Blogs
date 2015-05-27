<?php
/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 15/05/18
 * Time: 9:56
 */

App::uses('BlogEntriesEditController', 'Blogs.Controller');
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
			'Blogs.BlogEntriesEdit',
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

/**
 * コンテンツ新規登録フォームではゴミ箱アイコン非表示をテスト
 *
 * @return void
 */
	public function testAddFormNoDeleteButton() {
		RolesControllerTest::login($this);

		$view = $this->testAction(
			'/blogs/blog_entries_edit/add/1',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);
		$this->assertTextNotContains('glyphicon-trash', $view, print_r($view, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * コンテンツ編集フォームではゴミ箱アイコンが表示されるテスト
 *
 * @return void
 */
	public function testEditFormWithDeleteButton() {
		RolesControllerTest::login($this);

		$view = $this->testAction(
			'/blogs/blog_entries_edit/edit/1/origin_id:3',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);
		$this->assertTextContains('glyphicon-trash', $view, print_r($view, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * testDelete
 *
 * @return void
 */
	public function testDelete() {
		RolesControllerTest::login($this);

		$this->testAction(
			'/blogs/blog_entries_edit/delete/1/origin_id:3',
			array(
				'method' => 'post',
				'return' => 'view',
			)
		);
		$this->assertRegExp('#/blogs/blog_entries/index#', $this->headers['Location']);

		AuthGeneralControllerTest::logout($this);
	}

}

