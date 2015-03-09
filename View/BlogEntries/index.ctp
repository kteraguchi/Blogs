<div class="blogEntries index">
	<h1><?php echo $listTitle ?></h1>

	<div class="row">
		<div class="col-xs-2">
			<?php if ($contentCreatable): ?>
				<button class="btn btn-success"
						tooltip="<?php echo __d('blogs', 'Add entry'); ?>">
					<span class="glyphicon glyphicon-plus"></span>
				</button>
				<span class="hidden">
					<?php echo __d('blogs', 'Add entry'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="col-xs-3">
			<?php if ($contentCreatable): ?>
				<?php
				//TODO
				$currentStatus = 0;
				$statusOptions = array(
					0 => __d('blogs', 'All status'),
					NetCommonsBlockComponent::STATUS_PUBLISHED   => __d('net_commons', 'Published'),
					NetCommonsBlockComponent::STATUS_APPROVED    => __d('net_commons', 'Approving'),
					NetCommonsBlockComponent::STATUS_DRAFTED     => __d('net_commons', 'Temporary'),
					NetCommonsBlockComponent::STATUS_DISAPPROVED => __d('net_commons', 'Disapproving'),

				);
				?>
				<?php echo $this->Form->select('status', $statusOptions, array('empty' => false, 'class'=> 'form-control', 'value' => $currentStatus)); ?>
			<?php endif; ?>
		</div>

		<div class="col-xs-4">
			<?php $currentCategory = 0 // TODO ?>
			<?php echo $this->Form->select('category', $categoryOptions, array('empty' => false, 'class'=> 'form-control', 'value' => $currentCategory)); ?>
		</div>

		<div class="col-xs-3">
			<?php $currentYearMonth = 0 // TODO ?>
			<?php echo $this->Form->select('year_month', $yearMonthOptions, array('empty' => false, 'class'=> 'form-control', 'value' => $currentYearMonth)); ?>
		</div>

	</div>


	<div>
		<!--記事一覧-->
		<?php foreach ($blogEntries as $blogEntry): ?>

			<div>
				<h2>
					<?php echo $this->Html->link($blogEntry['BlogEntry']['title'], array('controller' => 'blog_entries', 'action' => 'view', $frameId, 'id' => $blogEntry['BlogEntry']['id'])); ?>
				</h2>

				<?php echo $this->element('entry_meta_info'); ?>

				<div>

					<?php echo $blogEntry['BlogEntry']['body1']; ?>
				</div>
				<div>
					TODO　続きがあるときだけ　アコーディオン表示
					続きを読む
				</div>

				<?php echo $this->element('entry_footer'); ?>
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
