<h1><?= View::e($user->username) ?></h1>
<?php if ( trim($user->getAuth()->public_key) ) : ?>
<p><a href="<?= View::makeURI('/u/'.$user->username.'/pubkey') ?>">PUBLIC KEY</a></p>
<?php endif ?>
<p>Puntos: <?= $user->score ?></p>
<p>Puntos del ultimo mes: <?= $user->getMonthlyScore() ?></p>
<?php


$nodes = $user->getNodes(); 

foreach ( $nodes as $node ) :
	include('singlenode.php');
endforeach;
