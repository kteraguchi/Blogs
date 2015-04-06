<div class="blogTags index">
	<h2><?php echo __('Blog Tags'); ?></h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('block_id'); ?></th>
			<th><?php echo $this->Paginator->sort('key'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($blogTags as $blogTag): ?>
			<tr>
				<td><?php echo h($blogTag['BlogTag']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link(
						$blogTag['Block']['name'],
						array('controller' => 'blocks', 'action' => 'view', $blogTag['Block']['id'])
					); ?>
				</td>
				<td><?php echo h($blogTag['BlogTag']['key']); ?>&nbsp;</td>
				<td><?php echo h($blogTag['BlogTag']['name']); ?>&nbsp;</td>
				<td><?php echo h($blogTag['BlogTag']['created_user']); ?>&nbsp;</td>
				<td><?php echo h($blogTag['BlogTag']['created']); ?>&nbsp;</td>
				<td><?php echo h($blogTag['BlogTag']['modified_user']); ?>&nbsp;</td>
				<td><?php echo h($blogTag['BlogTag']['modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $blogTag['BlogTag']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $blogTag['BlogTag']['id'])); ?>
					<?php echo $this->Form->postLink(
						__('Delete'),
						array('action' => 'delete', $blogTag['BlogTag']['id']),
						null,
						__('Are you sure you want to delete # %s?', $blogTag['BlogTag']['id'])
					); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<p>
		<?php
		echo $this->Paginator->counter(
			array(
				'format' => __(
					'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
				)
			)
		);
		?>    </p>

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
		<li><?php echo $this->Html->link(__('New Blog Tag'), array('action' => 'add')); ?></li>
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
