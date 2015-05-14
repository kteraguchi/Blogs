<?php if ($blogSetting['useSns']) : ?>
	<div id="fb-root"></div>
	<script>(function (d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<a class="btn btn-default " title="setting" href="/blogs/blocks/index/<?php echo $frameId?>">
		<span class="glyphicon glyphicon-cog"> </span>
		<span class="sr-only">Show flame setting</span>
	</a>
<?php endif;

