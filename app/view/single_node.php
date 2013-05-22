	<div class="row-fluid node">
		<div class="span2">
		<?php $author = $node->getAuthor() ?>
		<?php if ( $author ) : ?><a href="<?= View::e($author->uri) ?>" class="author"><?= View::e($author->username) ?></a><?php endif ?>
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
