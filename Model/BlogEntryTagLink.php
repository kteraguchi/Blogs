<?php
/**
 * BlogEntryTagLink Model
 *
 * @property BlogEntry $BlogEntry
 * @property BlogTag $BlogTag
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlogsAppModel', 'Blogs.Model');

/**
 * Summary for BlogEntryTagLink Model
 */
class BlogEntryTagLink extends BlogsAppModel {

/**
 * recursive
 *
 * @var int
 */
	public $recursive = -1;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Trackable',
//		'NetCommons.Publishable'

	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'blog_tag_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'BlogEntry' => array(
			'className' => 'Blogs.BlogEntry',
			'foreignKey' => 'blog_entry_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BlogTag' => array(
			'className' => 'Blogs.BlogTag',
			'foreignKey' => 'blog_tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
