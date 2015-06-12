<?php
/**
 * BlogAppModel Test Case
 *
* @author Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link http://www.netcommons.org NetCommons Project
* @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogAppModel', 'Blogs.Model');

/**
 * Summary for BlogAppModel Test Case
 */
class BlogAppModelTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogAppModel = ClassRegistry::init('Blogs.BlogAppModel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogAppModel);

		parent::tearDown();
	}

}
