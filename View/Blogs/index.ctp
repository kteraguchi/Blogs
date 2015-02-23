<div class="blogEntries index">
	<h2><?php echo __('Blog Entries'); ?></h2>

	<?php foreach ($blogEntries as $blogEntry): ?>

	<div>
		<?php echo h($blogEntry['BlogEntry']['id']); ?>&nbsp;

		<?php echo $this->Html->link($blogEntry['BlogCategory']['name'], array('controller' => 'blog_categories', 'action' => 'view', $blogEntry['BlogCategory']['id'])); ?>

		<?php echo h($blogEntry['BlogEntry']['key']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['status']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['title']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['body1']); ?>&nbsp;
		<!--		--><?php //echo h($blogEntry['BlogEntry']['body2']); ?><!--&nbsp;-->
		<?php echo h($blogEntry['BlogEntry']['vote_number']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['is_auto_translated']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['translation_engine']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['created_user']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['created']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['modified_user']); ?>&nbsp;
		<?php echo h($blogEntry['BlogEntry']['modified']); ?>&nbsp;
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $blogEntry['BlogEntry']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $blogEntry['BlogEntry']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $blogEntry['BlogEntry']['id']), null, __('Are you sure you want to delete # %s?', $blogEntry['BlogEntry']['id'])); ?>
	</div>

		
<?php endforeach; ?>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Blog Entry'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Blog Categories'), array('controller' => 'blog_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Category'), array('controller' => 'blog_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blog Entry Tag Links'), array('controller' => 'blog_entry_tag_links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Entry Tag Link'), array('controller' => 'blog_entry_tag_links', 'action' => 'add')); ?> </li>
	</ul>
</div>
