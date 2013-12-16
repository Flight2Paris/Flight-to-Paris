<div class="row-fluid node-actions">
	<div class="span4">
	<a href="<?= View::e($node->uri) ?>" class="uri" ><?= View::e($node->uri) ?></a>
	<a href="<?= View::e($node->uri.'.json') ?>" class="label label-info">json</a>
	<a href="<?= View::e($node->uri.'.md') ?>" class="label label-info">markdown</a>
	<a href="<?= View::e($node->uri.'.rdf') ?>" class="label label-info">rdf</a>
	<a href="<?= View::e($node->uri.'.rss') ?>" class="label label-info">rss</a>
	</div>
	<form action="<?= View::makeUri('/promote/') ?>" method="POST" class="span6 score-form">
	<input type="hidden" value="<?= View::e($node->uri) ?>" name="uri" />
	<div class="btn-group">
	<input type="submit" name="promote" value="1" class="promote btn" />
	<input type="submit" name="promote" value="2" class="promote btn" />
	<input type="submit" name="promote" value="3" class="promote btn" />
	<input type="submit" name="promote" value="5" class="promote btn" />
	<input type="submit" name="promote" value="8" class="promote btn" />

	<input type="text" name="promote" value="1000" class="input-small" style="margin-bottom:0"/>

	<button class="btn submit"><i class="icon-plus-sign"></i></button>
	</div>
	</form>
	<div class="span2 node-score"><i class="icon-star"></i> <?= $node->getScore() ?></div>
</div>
