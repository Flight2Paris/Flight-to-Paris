<?php if ( auth::isLoggedIn() ) : ?>
<form action="<?= View::makeUri('/') ?>" method="POST" enctype="multipart/form-data">
	<?php if ( $uri ) : ?>
		<h1><?= View::e($uri) ?></h1>
	<?php endif ?>
	<div class="row-fluid">
		<?php if ( $uri ) : ?>
			<input type="hidden" value="<?= View::e($uri) ?>" name="uri" />
		<?php endif ?>
		<div class="span10">
		<?php 
			if ( $post = Flight::flash('post') ) {
				Flight::clearFlash('post');
				$content = array_pop($post);
			} 
		?>
			<textarea id="post-content" class="input-block-level" name="content" placeholder="Compartí algo"><?= View::e($content) ?></textarea><br />
			<?php if ( $content ) : ?>
				<script>
				$(document).ready(function(){
					$('#post-content').focus();
				});
				</script>
			<?php endif ?>
		</div>
		<div class="span2"><button class="btn submit"><i class="icon-save"></i> Publicar</button></div>
	</div>
</form>
<?php endif ?>
