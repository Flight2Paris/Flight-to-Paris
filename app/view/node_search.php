<?php require('postform.php') ?>

<?php foreach ( $nodes as $node ) : ?>
	<?php include('singlenode.php') ?>
<?php endforeach ?>

<div class="centerContent"><a href="<?= View::makeUri('/') . '?skip='.($skip+PAGESIZE) ?>" class="btn" id="load-more"><i class="icon-plus-sign"></i> Más</a></div>
