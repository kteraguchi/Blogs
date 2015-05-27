<?php echo $this->element('shared_header'); ?>

<?php
echo $this->Html->css(
	'/blogs/css/blogs.css',
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
); ?>
<?php
// Like
echo $this->Html->script(
	'/likes/js/likes.js',
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
echo $this->Html->css(
	'/likes/css/style.css',
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
?>
<?php echo $this->BackTopage->backToPageButton(__d('blogs', 'Move list')) ?>
<div class="blogs_entry_status">
	<?php echo $this->element(
		'NetCommons.status_label',
		array('status' => $blogEntry['BlogEntry']['status'])
	); ?>
</div>

<article>
	<h1><?php echo h($blogEntry['BlogEntry']['title']); ?></h1>

	<?php echo $this->element('entry_meta_info'); ?>

	<div>
		<?php if ($contentCreatable): ?>

			<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
		<a href="<?php echo $this->Html->url(
			array('controller' => 'blog_entries_edit', 'action' => 'edit', $frameId, 'origin_id' => $blogEntry['BlogEntry']['origin_id'])
		) ?>" class="btn btn-primary">
			<span class="glyphicon glyphicon-edit"> </span>
		</a>
	</span>

		<?php endif ?>
	</div>


	<div>
		<?php echo $blogEntry['BlogEntry']['body1']; ?>
	</div>
	<div>
		<?php echo $blogEntry['BlogEntry']['body2']; ?>
	</div>

	<?php echo $this->element('entry_footer'); ?>

	<!-- Tags -->
	<?php if (isset($blogEntry['Tag'])) : ?>
	<div>
		<?php echo __d('blogs', 'tag'); ?>
		<?php foreach ($blogEntry['Tag'] as $blogTag): ?>
			<?php echo $this->Html->link(
				$blogTag['name'],
				array('controller' => 'blog_entries', 'action' => 'tag', $frameId, 'id' => $blogTag['id'])
			); ?>&nbsp;
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<div>
		<?php /* コンテンツコメント */ ?>
		<div class="col-xs-12">
			<?php /* コメントを利用しない or (コメント0件 and コメント投稿できない) */ ?>

			<?php if (!$blogSetting['useComment']) : ?>
				<?php /* 表示しない */ ?>
			<?php else : ?>
				<div class="panel panel-default">
					<?php if ($contentCommentCreatable) : ?>
					<?php echo $this->element('ContentComments.form', array(
						'formName' => 'Blog',
					)); ?>
					<?php endif ?>
					<?php if (count($contentComments) > 0) : ?>
					<?php echo $this->element('ContentComments.index', array(
						'formName' => 'Blog',
					)); ?>
					<?php endif ?>
				</div>
			<?php endif; ?>
		</div>

	</div>
</article>


