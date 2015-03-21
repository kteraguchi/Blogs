<?php echo $this->element('shared_header'); ?>
<?php echo $this->Html->css('/blogs/css/blogs.css'); ?>


<div class="blogEntries index">
	<h1 class="blogs_blogTitle"><?php echo $listTitle ?></h1>

	<div class="row blogs_navigation_header">
		<div class="col-xs-2">
			<?php if ($contentCreatable): ?>
				<a href="/blogs/blog_entries/add/<?php echo $frameId ?>">
				<button class="btn btn-success"
						tooltip="<?php echo __d('blogs', 'Add entry'); ?>">
					<span class="glyphicon glyphicon-plus"></span>
				</button>
				<span class="hidden">
					<?php echo __d('blogs', 'Add entry'); ?>
				</span></a>

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
					NetCommonsBlockComponent::STATUS_IN_DRAFT     => __d('net_commons', 'Temporary'),
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

			<div class="blogs_entry">
				<h2 class="blogs_entry_title">
					<?php echo $this->Html->link($blogEntry['BlogEntry']['title'], array('controller' => 'blog_entries', 'action' => 'view', $frameId, 'id' => $blogEntry['BlogEntry']['id'])); ?>
				</h2>
				<?php echo $this->element('entry_meta_info', array('blogEntry' => $blogEntry)); ?>

				<div class="blogs_entry_body1">
					<?php echo $blogEntry['BlogEntry']['body1']; ?>
				</div>
				<div>
					<a href="">TODO 続きを読む</a>
				</div>

				<?php echo $this->element('entry_footer', array('blogEntry' => $blogEntry)); ?>
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
