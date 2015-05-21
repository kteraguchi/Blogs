<?php echo $this->element('shared_header'); ?>
<?php echo $this->Html->css('/blogs/css/blogs.css'); ?>
<?php echo $this->Html->script('/blogs/js/blogs.js', false); ?>

<?php echo $this->Html->script('/likes/js/likes.js', false); ?>
<?php echo $this->Html->css('/likes/css/style.css', false); ?>


<div class="blogEntries index nc-content-list" ng-controller="Blogs.Entries" ng-init="init(<?php echo $frameId ?>)">
	<h1 class="blogs_blogTitle"><?php echo $listTitle ?></h1>

	<div class="row blogs_navigation_header">
		<?php if ($contentCreatable): ?>
			<div style="text-align: right">

				<a href="/blogs/blog_entries_edit/add/<?php echo $frameId ?>">
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

		<div class="col-xs-7">
			<?php $categories = Hash::combine($categories, '{n}.category.id', '{n}.category.name'); ?>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
					<?php echo $filterDropDownLabel ?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					<li role="presentation"><a role="menuitem" tabindex="-1" href="/blogs/blog_entries/index/<?php echo $frameId?>"><?php echo __d('blogs', 'All Entries') ?></a></li>
					<li role="presentation" class="dropdown-header"><?php echo __d('blogs', 'Category') ?></li>
					<?php foreach($categories as $categoryId => $label): ?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="/blogs/blog_entries/index/<?php echo $frameId?>/category_id:<?php echo $categoryId?>"><?php echo $label ?></a></li>
					<?php endforeach ?>

					<li role="presentation" class="divider"></li>

					<li role="presentation" class="dropdown-header"><?php echo __d('blogs', 'Archive')?></li>
					<?php foreach($yearMonthOptions as $yearMonth => $label): ?>

					<li role="presentation"><a role="menuitem" tabindex="-1" href="/blogs/blog_entries/year_month/<?php echo $frameId?>/year_month:<?php echo $yearMonth?>"><?php echo $label ?></a></li>
					<?php endforeach ?>
				</ul>
			</div>
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
					<?php echo $this->element('entry_footer', array('blogEntry' => $blogEntry, 'index' => true)); ?>
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
