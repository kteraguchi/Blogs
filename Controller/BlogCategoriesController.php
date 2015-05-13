<?php
/**
 * BlogCategoriesController
 */
App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * BlogCategories Controller
 *
 * @property BlogCategory $BlogCategory
 * @property PaginatorComponent $Paginator
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogCategoriesController extends BlogsAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

}
