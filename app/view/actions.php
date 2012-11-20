		<div class="node-actions right">
			<a href="<?= View::e($node->uri) ?>" class="uri" ><?= View::e($node->uri) ?></a>
			<?php if ( auth::isLoggedIn() ) : ?>
			<a href="<?= View::e($node->uri).'#reply' ?>" class="reply">comentar</a>
			<?php endif ?>
			<form action="<?= View::makeUri('/promote/') ?>" method="POST" class="inline score-form">
			<input type="hidden" value="<?= View::e($node->uri) ?>" name="uri" />
			<input type="submit" name="promote" value="+1" title="Dar 1 punto" class="promote" />
			<input type="submit" name="promote" value="+3" title="Dar 3 puntos" class="promote" />
			<input type="submit" name="promote" value="+5" title="Dar 5 puntos" class="promote" />
			<input type="submit" name="promote" value="+8" title="Dar 8 puntos" class="promote" />
			</form>
			<span class="node-score"><?= $node->getScore()->score ?></span>
		</div>
