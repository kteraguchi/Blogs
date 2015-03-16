<?php echo $this->element('shared_header'); ?>

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

<div>
	<?php echo __d('blogs', 'tag'); ?>
	<?php foreach($blogTags as $blogTag): ?>
		<?php echo $this->Html->link($blogTag['BlogTag']['name'], array('controller' => 'blog_entries', 'action' => 'tag', $frameId, 'id' => $blogTag['BlogTag']['id'])); ?>&nbsp;
	<?php endforeach; ?>

</div>

<div>
<!-- ε(　　　　 v ﾟωﾟ)　＜ Coreで開発されたらコメント機能を組み込む-->
	<?php //echo $this->element('Comments.index'); ?>

</div>

