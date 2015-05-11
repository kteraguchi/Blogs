<?php echo $this->element('shared_header'); ?>
<?php echo $this->Html->css('/blogs/css/blogs.css'); ?>
<?php echo $this->Html->script('/blogs/js/blogs.js', false); ?>


<div class="blogEntries index" ng-controller="Blogs.Entries" ng-init="init(<?php echo $frameId ?>)">
	<h1 class="blogs_blogTitle"><?php echo $listTitle ?></h1>

	<div class="row blogs_navigation_header">
		<?php if ($contentCreatable): ?>
			<div style="text-align: right">

				<a href="/blogs/blog_entries/add/<?php echo $frameId ?>">
					<button class="btn btn-success"
							tooltip="<?php echo __d('blogs', 'Add entry'); ?>">
						<span class="glyphicon glyphicon-plus"></span>
					</button>
				<span class="hidden">
					<?php echo __d('blogs', 'Add entry'); ?>
				</span></a>
			</div>

		<?php endif; ?>

		<div class="col-xs-2">
		</div>

		<div class="col-xs-3">
		</div>

		<div class="col-xs-4">
			<?php echo $this->Form->select(
				'category',
				$categoryOptions,
				array(
					'empty' => false,
					'class' => 'form-control',
					'value' => $currentCategoryId,
					'ng-change' => 'filterCategory()',
					'ng-model' => 'selectCategory',
					'ng-init' => 'selectCategory=' . $currentCategoryId
				)
			); ?>
		</div>

		<div class="col-xs-3">
			<?php echo $this->Form->select(
				'year_month',
				$yearMonthOptions,
				array(
					'empty' => false,
					'class' => 'form-control',
					'value' => $currentYearMonth,
					'ng-change' => 'moveYearMonth()',
					'ng-model' => 'selectYearMonth',
					'ng-init' => 'selectYearMonth="' . $currentYearMonth . '"'
				)
			); ?>
		</div>

	</div>


	<div>
		<!--記事一覧-->
		<?php foreach ($blogEntries as $blogEntry): ?>

			<div class="blogs_entry" ng-controller="Blogs.Entries.Entry">
				<div class="blogs_entry_status">
					<?php echo $this->element(
						'NetCommons.status_label',
						array('status' => $blogEntry['BlogEntry']['status'])
					); ?>

				</div>

				<article>
					<h2 class="blogs_entry_title">
						<?php echo $this->Html->link(
							$blogEntry['BlogEntry']['title'],
							array(
								'controller' => 'blog_entries',
								'action' => 'view',
								$frameId,
								'origin_id' => $blogEntry['BlogEntry']['origin_id']
							)
						); ?>
					</h2>
					<?php echo $this->element('entry_meta_info', array('blogEntry' => $blogEntry)); ?>

					<div class="blogs_entry_body1">
						<?php echo $blogEntry['BlogEntry']['body1']; ?>
					</div>
					<?php if ($blogEntry['BlogEntry']['body2']) : ?>
						<div ng-hide="isShowBody2">
							<a ng-click="showBody2()">続きを読む</a>
						</div>
						<div ng-show="isShowBody2">
							<?php echo $blogEntry['BlogEntry']['body2'] ?>
						</div>
						<div ng-show="isShowBody2">
							<a ng-click="hideBody2()">閉じる</a>
						</div>
					<?php endif ?>
					<?php echo $this->element('entry_footer', array('blogEntry' => $blogEntry)); ?>
				</article>

			</div>


		<?php endforeach; ?>
	</div>

	<div>
		<ul class="pagination">
			<?php echo $this->Paginator->numbers(
				array(
					'tag' => 'li',
					'currentTag' => 'a',
					'currentClass' => 'active',
					'separator' => '',
					'first' => false,
					'last' => false,
					'modulus' => '4',
				)
			); ?>
		</ul>
	</div>
</div>
