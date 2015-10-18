<div class="col-md-3" id="sidebar">
	<h1><?= View::e($user->username) ?></h1>
	<?php if ( trim($user->getAuth()->public_key) ) : ?>
		<p><a href="<?= View::makeURI('/u/'.$user->username.'/pubkey') ?>">PUBLIC KEY</a></p>
	<?php endif ?>
	<h3>Score <?= $user->score ?></h3>
	<p></p>
	<p><small>mes: <?= $user->getMonthlyScore() ?></small></p>
</div>
<div class="col-md-9">
<?php
$nodes = $user->getNodes(); 
require('nodestream.php');
?>
</div>
