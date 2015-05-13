<?php
App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * BlogBlockSettings Controller
 *
 * @property BlogBlockSetting $BlogBlockSetting
 * @property PaginatorComponent $Paginator
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogBlockSettingsController extends BlogsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
}
