<?php
/**
 * Block edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', $blockSettingTabs); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'BlogBlocks',
				'action' => h($this->request->params['action']) . '/' . $frameId . '/' . $blockId,
				'callback' => 'Blogs.Blocks/edit_form',
				'cancelUrl' => '/blogs/blocks/index/' . $frameId
			)); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'controller' => 'BlogBlocks',
					'action' => 'delete/' . $frameId . '/' . $blockId,
					'callback' => 'Blogs.Blocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
