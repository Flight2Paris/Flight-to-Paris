<?php if ( is_a($node,'node') ) : ?>
	<div class="row-fluid <?= isset($class) ? $class : 'node' ?>" data-uri="<?= View::e( $node->uri ) ?>" data-score="<?= $node->getScore()->raw() ?>">
		<div class="span2">
		<?php $author = $node->getAuthor() ?>
		<?php if ( is_a($author,'user') ) : ?><a href="<?= View::e($author->uri) ?>" class="author"><?= View::e($author->username) ?></a><?php endif ?>
		</div>

		<div class="span10 node-short">
		<?php if ( mb_strlen($node->content) > 140 ) : ?>
		<?= View::markdown(trim(mb_substr($node->content,0,140)).'...',false) ?>
		<?php else : ?>
		<?= View::markdown($node->content,false) ?>
		<?php endif ?>
		</div>
<?php include('actions.php') ?> 
		<div class="clear"></div>
	</div>
<?php endif ?>
