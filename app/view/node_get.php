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
	<textarea name="content" id="post-content" placeholder="Responde algo" ></textarea>
	<span class="clear right block">
		<input type="image" alt="Save" title="Save" src="<?= View::makeUri('/images/save.png') ?>" />
	</span>
	<span class="block clear"></span>
</form>
<?php endif ?>
