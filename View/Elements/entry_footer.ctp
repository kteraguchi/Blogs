<div class="blogs_entry_reaction row">
	<?php if ($blogSetting['useSns']) : ?>
		<!--Facebook-->
		<div class="fb-like col-xs-3" data-href="<?php echo FULL_BASE_URL ?>/blogs/blog_entries/view/<?php echo $frameId ?>/origin_id:<?php echo $blogEntry['BlogEntry']['origin_id'] ?>" data-layout="button_count" data-action="like"
			 data-show-faces="false" data-share="false"></div>
		<!--Twitter-->
		<div class="col-xs-3">
			<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
			<script>!function (d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
					if (!d.getElementById(id)) {
						js = d.createElement(s);
						js.id = id;
						js.src = p + '://platform.twitter.com/widgets.js';
						fjs.parentNode.insertBefore(js, fjs);
					}
				}(document, 'script', 'twitter-wjs');</script>
		</div>
	<?php else : ?>
		<div class="col-xs-6"></div>
	<?php endif ?>
	<div class="col-xs-2">
		<!--		TODO　いいね-->

	</div>
	<div class="col-xs-2">
		<!--		TODO　やだね-->

	</div>
	<div class="col-xs-2">
		<!--		TODO　コメントリンク　コメント数-->
	</div>

</div>
