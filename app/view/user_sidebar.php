<?php 
if ( Flight::request()->url != '/score' ) {
	 include 'scoreform.php';
}
?>

<a href="<?= View::makeUri('/auth/changepassword') ?>"><i class="icon-lock"></i> Cambiar contraseña</a><br >
<a href="<?= View::makeUri('/auth/pubkey') ?>"><i class="icon-key"></i> Cambiar llave criptográfica</a><br >
<a href="<?= View::makeUri('/auth/logout') ?>"><i class="icon-signout"></i> Salir</a><br />

<hr>

<h3>Siguiendo</h3>
<?php foreach ( auth::getUser()->following() as $fo ) : ?>
	<div class="following"><?= nice_link($fo->to) ?></div>
<?php endforeach ?>
