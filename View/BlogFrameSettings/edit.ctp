<?php
/**
 * blogs frame settings
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', array(
			'tabs' => array(
				'block_index' => array('url' => '/blogs/blog_blocks/index/' . $frameId),
				'frame_settings' => array('url' => '/blogs/blog_frame_settings/edit/' . $frameId),
			),
			'active' => 'frame_settings'
		)); ?>

	<div class="tab-content">
		<?php echo $this->Form->create('BlogFrameSetting', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'BlogFrameSettings',
				'action' => 'edit' . '/' . $frameId,
				'callback' => 'Blogs.BlogFrameSettings/edit_form',
				'cancelUrl' => $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null)
			)); ?>
	</div>
</div>
