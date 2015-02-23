<div class="blogEntries view">
<h2><?php echo __('Blog Entry'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Blog Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($blogEntry['BlogCategory']['name'], array('controller' => 'blog_categories', 'action' => 'view', $blogEntry['BlogCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Key'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Body1'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['body1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Body2'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['body2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vote Number'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['vote_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Auto Translated'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['is_auto_translated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Translation Engine'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['translation_engine']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created User'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['created_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified User'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['modified_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($blogEntry['BlogEntry']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Blog Entry'), array('action' => 'edit', $blogEntry['BlogEntry']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Blog Entry'), array('action' => 'delete', $blogEntry['BlogEntry']['id']), null, __('Are you sure you want to delete # %s?', $blogEntry['BlogEntry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Blog Entries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Entry'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blog Categories'), array('controller' => 'blog_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Category'), array('controller' => 'blog_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blog Entry Tag Links'), array('controller' => 'blog_entry_tag_links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog Entry Tag Link'), array('controller' => 'blog_entry_tag_links', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Blog Entry Tag Links'); ?></h3>
	<?php if (!empty($blogEntry['BlogEntryTagLink'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Blog Entry Id'); ?></th>
		<th><?php echo __('Blog Tag Id'); ?></th>
		<th><?php echo __('Created User'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified User'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($blogEntry['BlogEntryTagLink'] as $blogEntryTagLink): ?>
		<tr>
			<td><?php echo $blogEntryTagLink['id']; ?></td>
			<td><?php echo $blogEntryTagLink['blog_entry_id']; ?></td>
			<td><?php echo $blogEntryTagLink['blog_tag_id']; ?></td>
			<td><?php echo $blogEntryTagLink['created_user']; ?></td>
			<td><?php echo $blogEntryTagLink['created']; ?></td>
			<td><?php echo $blogEntryTagLink['modified_user']; ?></td>
			<td><?php echo $blogEntryTagLink['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'blog_entry_tag_links', 'action' => 'view', $blogEntryTagLink['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'blog_entry_tag_links', 'action' => 'edit', $blogEntryTagLink['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'blog_entry_tag_links', 'action' => 'delete', $blogEntryTagLink['id']), null, __('Are you sure you want to delete # %s?', $blogEntryTagLink['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Blog Entry Tag Link'), array('controller' => 'blog_entry_tag_links', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
