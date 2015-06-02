<?php echo $this->Html->script(
	'/blogs/js/blogs.js',
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
); ?>

<?php
// datetimepicker
echo $this->Html->script(
	array(
		'/components/moment/min/moment.min.js',
		'/components/moment/min/moment-with-locales.min.js',
		'/components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
		'/components/angular-bootstrap-datetimepicker-directive/angular-bootstrap-datetimepicker-directive.js',
	),
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
echo $this->Html->css(
	'/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
?>
<?php
// 編集用
echo $this->Html->script(
	array(
		'/tags/js/tags.js',
		'/blogs/js/blogs_entry_edit.js',
		'/net_commons/js/wysiwyg.js',
	),
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
?>
<?php
if ($this->request->data) {
	$dataJson = json_encode($this->request->data);
} else {
	$dataJson = json_encode($blogEntry);
}
?>
<div class="blogEntries form" ng-controller="Blogs" ng-init="init(<?php echo h($dataJson) ?>)">
	<div class="modal-header">BLOG</div>
	<div class="modal-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="active">
				<a href="" role="tab" data-toggle="tab">
					<?php echo __('Edit') ?>
				</a>
			</li>
		</ul>
		<br/>

		<div class="tab-content">

			<div class="panel panel-default">


				<?php echo $this->Form->create(
					'BlogEntry',
					array(
						'inputDefaults' => array(
							'div' => 'form-group',
							'class' => 'form-control'
						),
						'div' => 'form-control',
						'novalidate' => true
					)
				);
				$this->Form->unlockField('Tag');
				?>
				<?php echo $this->Form->input('origin_id', array('type' => 'hidden')); ?>
				<?php echo $this->Form->input('key', array('type' => 'hidden')); ?>
				<!--		--><?php //echo $this->Form->hidden('Frame.id', array(
				//			'value' => $frameId,
				//		)); ?>

				<div class="panel-body">

					<fieldset>

						<?php
						echo $this->Form->input(
							'title',
							array(
								'label' => __d('blogs', 'Title'),
								'required' => 'required',
								'between' => '<strong class="text-danger h4">*</strong>',
							)
						);
						?>

						<div class="form-group">
							<label class="control-label">
								<?php echo __d('blogs', 'body1'); ?>
							</label>
							<?php echo $this->element('NetCommons.required'); ?>

							<div class="nc-wysiwyg-alert">
								<?php echo $this->Form->textarea(
									'body1',
									[
										'class' => 'form-control',
										'ui-tinymce' => 'tinymce.options',
										'ng-model' => 'blogEntry.body1',
										'rows' => 5,
										'required' => 'required',
									]
								) ?>
							</div>

							<?php echo $this->element(
								'NetCommons.errors',
								[
									'errors' => $this->validationErrors,
									'model' => 'BlogEntry',
									'field' => 'body1',
								]
							) ?>
						</div>

						<label><input type="checkbox" ng-model="writeBody2"/><?php echo __d('blogs', 'Write body2') ?>
						</label>

						<div class="form-group" ng-show="writeBody2">
							<label class="control-label">
								<?php echo __d('blogs', 'body2'); ?>
							</label>

							<div class="nc-wysiwyg-alert">
								<?php echo $this->Form->textarea(
									'body2',
									[
										'class' => 'form-control',
										'ui-tinymce' => 'tinymce.options',
										'ng-model' => 'blogEntry.body2',
										'rows' => 5,
									]
								) ?>
							</div>

							<?php echo $this->element(
								'NetCommons.errors',
								[
									'errors' => $this->validationErrors,
									'model' => 'BlogEntry',
									'field' => 'body2',
								]
							) ?>
						</div>

						<?php

						echo $this->Form->input('published_datetime',
							array('type' => 'text',
								'ng-model' => 'blogEntry.published_datetime',
								'datetimepicker',
								'required' => 'required',
								'between' => '<strong class="text-danger h4">*</strong>',

								'label' => __d('blogs', 'Published datetime')));

						?>
						<?php $categories = Hash::combine($categories, '{n}.category.id', '{n}.category.name'); ?>
						<?php echo $this->Form->input('category_id',
							array(
								'label' => __d('categories', 'Category'),
								'type' => 'select',
								'error' => false,
								'class' => 'form-control',
								'empty' => array(0 => __d('categories', 'Select Category')),
								'options' => $categories,
								'value' => (isset($blogEntry['category_id']) ? $blogEntry['category_id'] : '0')
							)); ?>


						<?php echo $this->element(
								'Tags.tag_form',
								array(
									'tagData' => isset($this->request->data['Tag']) ? $this->request->data['Tag'] : array(),
									'modelName' => 'BlogEntry',
									)
							); ?>


					</fieldset>

				</div>

				<hr/>

				<?php echo $this->element('Comments.form', array('contentStatus' => $blogEntry['BlogEntry']['status'])); ?>

				<div class="panel-footer" style="text-align: center">

					<?php echo $this->element(
						'NetCommons.workflow_buttons',
						array('contentStatus' => $blogEntry['BlogEntry']['status'])
					); ?>

				</div>

				<?php echo $this->Form->end() ?>
				<?php if ($isEdit) : ?>
					<div  class="panel-footer" style="text-align: right;">
						<?php echo $this->Form->create('BlogEntry',
							array(
								'type' => 'delete',
								'url' => array('controller' => 'blog_entries_edit', 'action' => 'delete', $frameId))
						) ?>
						<?php echo $this->Form->input('origin_id', array('type' => 'hidden')); ?>

					<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Delete'); ?>">
						<button class="btn btn-danger" onClick="return confirm('<?php echo __d('net_commons', 'Deleting the %s. Are you sure to proceed?', __d('blogs', 'BlogEntry')) ?>')"><span class="glyphicon glyphicon-trash"> </span></button>


					</span>
						<?php echo $this->Form->end() ?>
					</div>
				<?php endif ?>

			</div>

			<?php echo $this->element('Comments.index'); ?>

		</div>


	</div>

</div>
