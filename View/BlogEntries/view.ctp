<?php echo $this->Html->link(__d('blogs', 'Move list'), array('controller' => 'blog_entries', 'action' => 'index', $frameId)); ?>

<h1><?php echo h($blogEntry['BlogEntry']['title']); ?></h1>

<?php echo $this->element('entry_meta_info'); ?>

<div>
	TODO 編集
	TODO 削除
</div>


<div>
	<?php echo $blogEntry['BlogEntry']['body1']; ?>
</div>
<div>
	<?php echo $blogEntry['BlogEntry']['body2']; ?>
</div>

<?php echo $this->element('entry_footer'); ?>

TODO タグ

TODO コメント

