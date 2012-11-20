<?php if ( trim($url) ) : ?>
<form action="/u/follow" method="POST">
	<strong>¿Querés seguir a <?= View::e($url) ?>?</strong>
	<input type="hidden" value="<?= View::e($url) ?>" name="url" />
	<input type="submit" value="Seguir" />
</form>
<?php endif ?>
