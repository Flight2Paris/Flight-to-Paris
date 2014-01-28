<form enctype="multipart/form-data" action="<?= View::makeUri('/f/') ?>" method="POST">
<?php if ( isset($redirect) ) : ?>
	<input type="hidden" name="redirect" value="<?= View::e($redirect) ?>" />
<?php endif ?>
	<input type="file" name="userfile" /><br />
	<button class="submit btn"><i class="icon-upload-alt"></i> Subir</button><br />
</form>
