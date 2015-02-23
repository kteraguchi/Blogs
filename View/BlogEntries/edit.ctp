<div class="blogEntries form">
<?php echo $this->Form->create('BlogEntry'); ?>
	<fieldset>
		<legend><?php echo __('Edit Blog Entry'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('blog_category_id');
		echo $this->Form->input('key');
		echo $this->Form->input('status');
		echo $this->Form->input('title');
		echo $this->Form->input('body1');
		echo $this->Form->input('body2');
		echo $this->Form->input('vote_number');
		echo $this->Form->input('is_auto_translated');
		echo $this->Form->input('translation_engine');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('BlogEntry.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('BlogEntry.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Blog Entries'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Blog Categories'), array('controller' => 'blog_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Category'), array('controller' => 'blog_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blog Entry Tag Links'), array('controller' => 'blog_entry_tag_links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Entry Tag Link'), array('controller' => 'blog_entry_tag_links', 'action' => 'add')); ?> </li>
	</ul>
</div>
