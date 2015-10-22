<?php require('postform.php') ?>
<?php require('nodestream.php') ?>

<div class="centerContent"><a href="<?= View::makeUri('/') . '?skip='.($skip+PAGESIZE) ?>" class="btn" id="load-more"><i class="icon-plus-sign"></i> Más</a></div>
