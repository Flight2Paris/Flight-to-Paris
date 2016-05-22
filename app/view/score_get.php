<?php if ( $new ) { ?>
<h1>Bienvenido/a <?= View::e($user->username) ?></h1>
<p>Antes de podes publicar vas a necesitar ganas algunos puntos.</p>
<?php } ?>

<div class="row-fluid">

	<div class="span8">
		<h1>Puntos</h1>
		<p><strong>Cada punto tiene un agujero negro correspondiente en algun lugar del universo.</strong></p>
		<p>Mediante juegos, ganando badges y fluctuaciones al azar algunos de estos agujeros negros son 
			asignados a vos y <strong>podes usarlos para darle peso a un nodo o darselos a otros usuarios</strong>.
		</p>
		<p>Publicar y subir archivos cuesta puntos pero podes ganar mas cada dia solo por friki.</p>

		<?php require('scoreform.php'); ?>
		</div>
	<div class="span4">

		<h1>Puntajes más altos</h1>
		<?php $i = 0 ?>
		<table>
		<?php foreach ( model_user::getLeaders(20) as $leader ) : ?>
		<?php $i ++ ?>
		<tr><td>#<?= $i ?></td><td><a href="<?= $leader->uri ?>"><?= View::e($leader->username) ?></a></td><td><?= score::format($leader->score) ?></td></tr>
		<?php endforeach ?>
		</table>

	</div>
</div>
