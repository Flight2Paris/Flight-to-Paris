<?php if ( is_a($node,'node') ) : ?>
	<div class="row-fluid node <?= isset($class) ? $class : '' ?>" data-uri="<?= View::e( $node->uri ) ?>" data-score="<?= $node->getScore()->raw() ?>">
		<div class="col-md-2">
		<?php $author = $node->getAuthor() ?>
		<?php if ( is_a($author,'user') ) : ?><a href="<?= View::e($author->uri) ?>" class="author"><?= View::e($author->username) ?></a><?php endif ?>
		</div>

		<?php if ( isset($open) && $open ) : ?>
		<div class="col-md-12 node-full">
		<?= View::markdown($node->content) ?>
		</div>
		<?php else : ?>
		<div class="col-md-10 node-short">
		<?php if ( mb_strlen($node->content) > 140 ) : ?>
		<?= View::markdown(trim(mb_substr($node->content,0,140)).'...',false) ?>
		<?php else : ?>
		<?= View::markdown($node->content,false) ?>
		<?php endif ?>
		</div>

		<?php endif ?>
<?php include('actions.php') ?> 
		<div class="clear"></div>
	</div>
<?php else : ?>

<?php endif ?>
