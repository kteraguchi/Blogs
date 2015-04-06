<div class="blogTags form">
	<?php echo $this->Form->create('BlogTag'); ?>
	<fieldset>
		<legend><?php echo __('Edit Blog Tag'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('block_id');
		echo $this->Form->input('key');
		echo $this->Form->input('name');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(
				__('Delete'),
				array('action' => 'delete', $this->Form->value('BlogTag.id')),
				null,
				__('Are you sure you want to delete # %s?', $this->Form->value('BlogTag.id'))
			); ?></li>
		<li><?php echo $this->Html->link(__('List Blog Tags'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(
				__('List Blocks'),
				array('controller' => 'blocks', 'action' => 'index')
			); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(
				__('List Blog Entry Tag Links'),
				array('controller' => 'blog_entry_tag_links', 'action' => 'index')
			); ?> </li>
		<li><?php echo $this->Html->link(
				__('New Blog Entry Tag Link'),
				array('controller' => 'blog_entry_tag_links', 'action' => 'add')
			); ?> </li>
	</ul>
</div>
