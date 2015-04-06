<div class="blogs_entry_meta">
	<div>

		<!--	TODO 多言語化　日付フォーマット-->
		<?php echo __d(
			'blogs',
			'posted : %s',
			$this->BlogsFormat->published_datetime($blogEntry['BlogEntry']['published_datetime'])
		); ?>&nbsp;

		<!--	TODO 投稿者アバター-->
		<!--	TODO　投稿者名 リンク-->
		<?php echo $this->Html->link($blogEntry['TrackableCreator']['username'], array()); ?>&nbsp;
		カテゴリ:<?php echo $this->Html->link(
			$blogEntry['BlogCategory']['name'],
			array(
				'controller' => 'blog_entries',
				'action' => 'category',
				$frameId,
				'id' => $blogEntry['BlogCategory']['id']
			)
		); ?>
	</div>
	<div class="blogs_entry_status">
		<?php echo $this->element(
			'NetCommons.status_label',
			array('status' => $blogEntry['BlogEntry']['status'])
		); ?>

	</div>
</div>
