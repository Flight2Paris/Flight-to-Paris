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
			<textarea id="post-content" class="input-block-level" name="content" placeholder="Compartí algo"></textarea><br />
		</div>
		<div class="span2"><button class="btn submit"><i class="icon-save"></i> Publicar</button></div>
	</div>
</form>
<?php endif ?>
