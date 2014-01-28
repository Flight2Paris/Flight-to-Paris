<?php if ( auth::isLoggedIn() ) : ?>

<div class="row-fluid clearfix">
<form action="<?= View::makeUri('/') ?>" method="POST" enctype="multipart/form-data">
	<?php if ( $uri ) : ?>
	<h1><?= View::e($uri) ?></h1>
	<input type="hidden" value="<?= View::e($uri) ?>" name="uri" />
	<?php endif ?>

	<?php if ( isset($inReplyTo) ) : ?>
		<input type="hidden" name="type" value="<?= View::e(REPLY_URI) ?>" />
		<input type="hidden" name="to" value="<?= View::e($inReplyTo) ?>" />
	<?php endif ?>

	<div class="col-sm-5">
<?php 
		if ( $post = Flight::flash('post') ) {
			Flight::clearFlash('post');
			$content = array_pop($post);
		} 
?>
		<textarea class="form-control post-content" name="content" placeholder="Compartí algo; ¡Es bueno!"><?= View::e($content) ?></textarea><br />
		<?php if ( $content ) : ?>
			<script>
			$(document).ready(function(){
				$('.post-content').focus();
			});
			</script>
		<?php endif ?>
	</div>

	<div  id="preview"class="col-sm-5 hidden-xs">
	</div>

	<div class="col-sm-2">
		<button class="btn btn-default submit"><i class="icon-save"></i> Publicar</button>
	</div>
</form>
</div>
<?php endif ?>
