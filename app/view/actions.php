<div class="node-actions right">
	<a href="<?= View::e($node->uri) ?>" class="uri" ><?= View::e($node->uri) ?></a>
	<form action="<?= View::makeUri('/promote/') ?>" method="POST" class="inline score-form">
	<input type="hidden" value="<?= View::e($node->uri) ?>" name="uri" />
	<div class="btn-group">
	<input type="submit" name="promote" value="1" class="promote btn" />
	<input type="submit" name="promote" value="2" class="promote btn" />
	<input type="submit" name="promote" value="3" class="promote btn" />
	<input type="submit" name="promote" value="5" class="promote btn" />
	<input type="submit" name="promote" value="8" class="promote btn" />
	</div>
	</form>
	<span class="node-score"><?= $node->getScore()->score ?></span>
</div>
