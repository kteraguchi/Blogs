<div class="blogEntries index">
	<h1><?php echo $listTitle ?></h1>

	TODO 追加ボタン　作成権限以上

	TODO ステータス絞り込み　作成権限以上

	TODO カテゴリドロップダウン

	TODO　年月一覧

	<div>
		<!--記事一覧-->
		<?php foreach ($blogEntries as $blogEntry): ?>

			<div>
				<h2>
					<?php echo $this->Html->link($blogEntry['BlogEntry']['title'], array('controller' => 'blog_entries', 'action' => 'view', $blogEntry['BlogEntry']['id'])); ?>
				</h2>
				<div>
					TODO 多言語化　日付フォーマット
					投稿日時:<?php echo h($blogEntry['BlogEntry']['published_datetime']); ?>&nbsp;

					TODO 投稿者アバター
					TODO　投稿者名
					<?php echo h($blogEntry['BlogEntry']['created_user']); ?>&nbsp;

					カテゴリ:<?php echo $this->Html->link($blogEntry['BlogCategory']['name'], array('controller' => 'blog_entries', 'action' => 'category', $blogEntry['BlogCategory']['id'])); ?>

				</div>

				<div>
					TODO ステータス表示
					<?php echo h($blogEntry['BlogEntry']['status']); ?>&nbsp;
				</div>

				<div>

					<?php echo $blogEntry['BlogEntry']['body1']; ?>
				</div>
				<div>
					TODO　続きがあるときだけ　アコーディオン表示
					続きを読む
				</div>
				<div>
					TODO SNSボタン

					TODO　いいいね　やだねボタン

					TODO　コメントリンク　コメント数
				</div>
			</div>


		<?php endforeach; ?>
	</div>

	<div>
		<!--TODO ページャ-->
		<p>
			<?php
			echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
			?>
		</p>
		<div class="paging">
			<?php
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</div>
	</div>
</div>
