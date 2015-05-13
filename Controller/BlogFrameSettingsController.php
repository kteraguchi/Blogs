<?php
App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * BlogFrameSettings Controller
 *
 * @property BlogFrameSetting $BlogFrameSetting
 * @property PaginatorComponent $Paginator
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogFrameSettingsController extends BlogsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

}
