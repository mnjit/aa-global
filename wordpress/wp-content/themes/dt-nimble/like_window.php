<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta charset="UTF-8" />
<title></title>
<style>
html,
body {
	padding: 0;
	margin: 0;
	background: #fff;
	line-height: 20px;
}

body {
	padding: 20px;
	text-align: left;
}
.thumbnail {
	display: inline-block;
	padding: 4px 4px 4px 4px;
	background: rgba(0, 0, 0, 0.2);

	line-height: 0px;
	margin-bottom: 20px;
}

.like-holder{
	display: block;
	line-height: 0;
	padding-bottom: 10px;
}
</style>
</head>
	<body>

		<?php if( !empty($_GET['img']) ): ?>
			<div class="thumbnail"><img src="<?php echo urldecode( $_GET['img'] ); ?>" /></div>
		<?php endif; ?>

		<?php
		if( ! empty( $_GET['src'] ) ){
			$src = urldecode($_GET['src']);
			$use_custom = !empty( $_GET['use_custom'] );
			
			if( !empty($_GET['fb']) && !$use_custom ): ?>

			<div class="like-holder">
				<!-- faceboock SDK -->
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
  					var js, fjs = d.getElementsByTagName(s)[0];
  					if (d.getElementById(id)) return;
  					js = d.createElement(s); js.id = id;
  					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>

				<div class="fb-like" data-send="false" data-width="120" data-show-faces="false" data-layout="button_count" data-href="<?php echo $src; ?>"></div>
				
			</div>

			<?php endif;
			
			if( !empty($_GET['tw']) && !$use_custom ): ?>
					
			<div class="like-holder">
				<!-- twitter -->
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

				<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-url="<?php echo $src; ?>">Tweet</a>
			</div>

			<?php endif;

			if( !empty($_GET['gp']) && !$use_custom ): ?>

			<div class="like-holder">
				<!-- google plus -->
				<script type="text/javascript">
  					(function() {
    					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    					po.src = 'https://apis.google.com/js/plusone.js';
    					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>

				<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="120" data-href="<?php echo $src; ?>"></div>
			</div>

			<?php endif;
			
			if( !empty($_GET['pin']) && !$use_custom && ! empty( $_GET['full'] ) ): ?>

			<div class="like-holder">
				<!-- pinterest -->
				<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
				
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo $src; ?>&media=<?php echo urldecode( $_GET['full'] ); ?>"><img title="Pin It" src="//assets.pinterest.com/images/PinExt.png" alt="" border="0" /></a>
			</div>

			<?php endif;
			
			if( $use_custom ) {
				ob_start();
				include 'socials_code.php';
				$html = ob_get_clean();

				echo str_replace( array('%POST_PERMALINK%'), array($src), $html );
			}

		}else {?>

			<p>Bad request!</p>

		<?php } ?>

	</body>
</html>
