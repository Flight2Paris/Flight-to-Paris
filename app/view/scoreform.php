<?php if ( auth::isLoggedIn() ) : ?>
	<?php if ( $user->fibo > FIBOHI ) : ?>
		<h1>404 - no se encontraron agujeros negros</h1>
	<?php else : ?>
		<form action="<?= View::makeUri('/score/') ?>" method="post" >
		<?php include('captcha.php') ?>
		</form>
	<?php endif ?>
<?php endif ?>
