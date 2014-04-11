<form enctype="multipart/form-data" action="<?= View::makeUri('/f/') ?>" method="POST" class="form-inline">
<?php if ( isset($redirect) ) : ?>
	<input type="hidden" name="redirect" value="<?= View::e($redirect) ?>" />
<?php endif ?>
	<div class="form-group">
	<input type="file" name="userfile" />
	</div>
	<div class="form-group">
	<button class="submit btn"><i class="icon-upload-alt"></i> Subir</button>
	</div>
</form>
