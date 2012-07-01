<form action="<?= View::makeUri('/') ?>" method="POST">
	<?php if ( $uri ) : ?>
	<h1><?= View::e($uri) ?></h1>
	<?php endif ?>
	<span class="clear right">
	<input type="image" alt="Save" title="Save" src="<?= View::makeUri('/images/save.png') ?>" />
	</span><br />
	<?php if ( $uri ) : ?>
	<input type="hidden" value="<?= View::e($uri) ?>" name="uri" />
	<?php endif ?>
	<textarea class="bigmarkdown" name="content" placeholder="<?= View::e($random->content) ?>"></textarea>
</form>
