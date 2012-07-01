<?php if ( auth::isLoggedIn() ) : ?>
<form id="post" action="/" method="POST">
	<textarea name="content" id="post-content" placeholder="<?= View::e($random->content) ?>"></textarea>
	<span class="clear right block">
		<a href="/new" ><img alt="Maximize" title="Maximize" src="<?= View::makeUri('/images/maximize.png') ?>" /></a>
		<input type="image" alt="Save" title="Save" src="<?= View::makeUri('/images/save.png') ?>" />
	</span>
	<span class="block clear"></span>
</form>
<?php endif ?>
<?php foreach ( $nodes as $node ) : ?>
	<div class="node-short">
		<?php $author = $node->getAuthor() ?>
		<?php if ( $author ) : ?><a href="<?= View::e($author->uri) ?>" class="author"><?= View::e($author->username) ?></a><?php endif ?>
		<?php if ( mb_strlen($node->content) > 140 ) : ?>
		<?= View::markdown(trim(mb_substr($node->content,0,140)).'...',false) ?>
		<?php else : ?>
		<?= View::markdown($node->content,false) ?>
		<?php endif ?>
		<div class="node-actions">
			<a href="<?= $node->uri ?>">open</a>
			<?php if ( auth::isLoggedIn() ) : ?>
			<a href="<?= $node->uri.'#reply' ?>" class="reply">reply</a>
			<a href="<?= $node->uri.'?spam=1' ?>" class="spam">spam</a>
			<a href="<?= $node->uri.'?bot=1' ?>" class="bot">bot</a>
			<strong><?= $node->getScore()->score ?></strong>
			<form action="<?= View::makeUri('/promote/') ?>" method="POST" class="inline">
			<input type="hidden" value="<?= View::e($node->uri) ?>" name="uri" />
			<input type="submit" name="promote" value="+1" title="promote" class="promote" />
			<input type="submit" name="promote" value="+3" title="promote" class="promote" />
			<input type="submit" name="promote" value="+7" title="promote" class="promote" />
			<input type="submit" name="promote" value="+11" title="promote" class="promote" />
			</form>
			<?php endif ?>
		</div>
	</div>
<?php endforeach ?>
