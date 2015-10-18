<div class="col-md-3" id="sidebar">

<?php if (auth::isLoggedIn()) : ?>
	<h3>Siguiendo</h3>
	<?php foreach ( auth::getUser()->following() as $fo ) : ?>
		<div class="following"><?= nice_link($fo->to) ?></div>
	<?php endforeach ?>
<?php endif ?>
</div>
<div class="col-md-9">

<?php require('postform.php') ?>
<?php require('nodestream.php') ?>

<div class="centerContent"><a href="<?= View::makeUri('/') . '?skip='.($skip+PAGESIZE) ?>" class="btn" id="load-more"><i class="icon-plus-sign"></i> Más</a></div>
</div>
