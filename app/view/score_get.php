<?php if ( $new ) { ?>
<h1>Bienvenido/a <?= View::e($user->username) ?></h1>
<p>Antes de podes publicar vas a necesitar ganas algunos puntos.</p>
<?php } ?>

<h1>Puntos</h1>
<p><strong>Cada punto tiene un agujero negro correspondiente en algun lugar del universo.</strong> Mediante juegos, ganando badges y fluctuaciones al azar algunos de estos agujeros negros son asignados a vos y podes usarlos para darle peso a un nodo o darselos a otros usuarios.</p>
<?php if ( auth::isLoggedIn() ) : ?>
	<?php if ( $user->fibo > 7 ) : ?>
		<p><strong>Volvé más tarde.</strong></p>
	<?php else : ?>
		<form action="<?= View::makeUri('/score/') ?>" method="post" >
		<?php include('captcha.php') ?>
		</form>
	<?php endif ?>
<?php endif ?>

<h1>Puntajes más altos</h1>
<?php $i = 0 ?>
<table>
<?php foreach ( model_user::getLeaders(20) as $leader ) : ?>
<?php $i ++ ?>
<tr><td>#<?= $i ?></td><td><a href="<?= $leader->uri ?>"><?= View::e($leader->username) ?></a></td><td><?= $leader->score ?></td></tr>
<?php endforeach ?>
</table>
