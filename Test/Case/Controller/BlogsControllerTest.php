<?php
/**
 * BlogsController Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsController', 'Blogs.Controller');

/**
 * Summary for BlogsController Test Case
 */
class BlogsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
//		'plugin.blogs.blog',
		'plugin.blogs.site_setting'
	);

	public function testIndex() {
		// ε(　　　　 v ﾟωﾟ)　＜fixture不足でうごきません  https://github.com/NetCommons3/Announcements/blob/master/Test/Case/Controller/AnnouncementsAppTest.php を参考におまじないが大量にいりそう
		$result = $this->testAction('/blogs/blogs/index');
//		$result = $this->testAction(array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index'));
	}
}
