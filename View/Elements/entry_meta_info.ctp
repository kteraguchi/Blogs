<div class="blogs_entry_meta">
	<div>

		<?php echo __d(
			'blogs',
			'posted : %s',
			$this->BlogsFormat->publishedDatetime($blogEntry['BlogEntry']['published_datetime'])
		); ?>&nbsp;

		<!--	TODO 投稿者アバター-->
		<!--	TODO　投稿者名 リンク-->
		<?php echo $this->Html->link($blogEntry['TrackableCreator']['username'], array()); ?>&nbsp;
		<?php echo __d('blogs', 'Category') ?>:<?php echo $this->Html->link(
			$blogEntry['Category']['name'],
			array(
				'controller' => 'blog_entries',
				'action' => 'index',
				$frameId,
				'category_id' => $blogEntry['BlogEntry']['category_id']
			)
		); ?>
	</div>
</div>
