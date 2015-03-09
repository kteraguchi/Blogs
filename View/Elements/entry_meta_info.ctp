<div>
	TODO 多言語化　日付フォーマット
	<?php echo __d('blogs', 'posted : %s', $this->BlogsFormat->published_datetime($blogEntry['BlogEntry']['published_datetime'])); ?>&nbsp;

	TODO 投稿者アバター
	TODO　投稿者名
	<?php echo h($blogEntry['BlogEntry']['created_user']); ?>&nbsp;

	カテゴリ:<?php echo $this->Html->link($blogEntry['BlogCategory']['name'], array('controller' => 'blog_entries', 'action' => 'category', $blogEntry['BlogCategory']['id'])); ?>

</div>

<div>
	TODO ステータス表示
	<?php echo h($blogEntry['BlogEntry']['status']); ?>&nbsp;
</div>
