<?php if ( $node->isReply() ) : 
$replyTo = $node->getReplyTo(); ?>
<div class="node">
	<?php $author = $replyTo->getAuthor() ?>
	<?php if ( $author ) : ?><a href="<?= View::e($author->uri) ?>" class="author"><?= View::e($author->username) ?></a><?php endif ?>
	<?= View::markdown($replyTo->content) ?>
</div>
<?php endif ?>

<div class="node">
	<?php $author = $node->getAuthor() ?>
	<?php if ( $author ) : ?><a href="<?= View::e($author->uri) ?>" class="author"><?= View::e($author->username) ?></a><?php endif ?>
	<?= View::markdown($node->content) ?>
	<?php include('actions.php') ?>
</div>
<?php foreach ( $node->getReplies() as $comment ) : ?>
<div class="comment">
	<?php $author = $comment->getAuthor() ?>
	<?php if ( $author ) : ?><a href="<?= View::e($author->uri) ?>" class="author"><?= View::e($author->username) ?></a><?php endif ?>
	<?= View::markdown($comment->content) ?>
</div>
<?php endforeach ?>

<?php if ( auth::isLoggedIn() ) : ?>
<span class="red">Comentar:</span>
<form id="reply" action="/" method="POST" >
	<input type="hidden" name="type" value="<?= View::makeUri('/reply') ?>" />
	<input type="hidden" name="to" value="<?= View::e($node->uri) ?>" />
	<div class="row-fluid">
	<div class="span10"><textarea name="content" class="input-block-level" id="post-content" placeholder="Comenta o agrega información." ></textarea></div>
	<div class="span2"><button class="btn submit pull-right">
		<i class="icon-save"></i> Guardar
	</button></div>
</form>
<?php endif ?>
