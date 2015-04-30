<div class="form-group"
	 ng-controller="Blogs.BlogTagEdit"
	 ng-init="init( <?php echo h(json_encode($tagData)); ?> )">
	<label class="control-label">
		<?php echo __d('blogs', 'tag'); ?>
	</label>
	<input type="text" ng-model="newTag"/>
	<button type="button" class="btn btn-success btn-xs" ng-click="addTag()">
		<span class=""><?php echo __d('blogs', 'Add tag') ?></span>
	</button>

	<div>
		<div ng-repeat="tag in tags" class="badge">
			{{tag.name}}
			&nbsp;
			<button type="button" ng-click="removeTag(tag)" class="btn btn-xs">
										<span class="glyphicon glyphicon-remove small"><span
												class="sr-only">Remove tags</span> </span>
			</button>
			<input type="hidden" name="data[BlogTag][{{$index}}][name]" value="{{tag.name}}"/>
		</div>
	</div>
</div>
