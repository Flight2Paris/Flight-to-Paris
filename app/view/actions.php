<div class="row-fluid node-actions">

	<div class="col-sm-5">
	<?= nice_link($node->uri, false, 'uri') ?> &nbsp; 
	<a href="<?= View::e($node->uri.'.json') ?>" class="label label-info">json</a>
	<a href="<?= View::e($node->uri.'.md') ?>" class="label label-info">markdown</a>
	<a href="<?= View::e($node->uri.'.rdf') ?>" class="label label-info">rdf</a>
	<a href="<?= View::e($node->uri.'.rss') ?>" class="label label-info">rss</a>
	<a href="<?= View::e($node->uri.'.atom') ?>" class="label label-info">atom</a>
	</div>

	<form action="<?= View::makeUri('/promote/') ?>" method="POST" class="col-sm-5 score-form">
		<input type="hidden" value="<?= View::e($node->uri) ?>" name="uri" />
		<div class="btn-toolbar">
			<div class="btn-group">
				<input type="submit" name="promote" value="1" class="promote btn btn-default" />
				<input type="submit" name="promote" value="3" class="promote btn btn-default" />
				<input type="submit" name="promote" value="8" class="promote btn btn-default" />
				<input type="submit" name="promote" value="21" class="promote btn btn-default" />
				<input type="submit" name="promote" value="55" class="promote btn btn-default" />
				<input type="submit" name="promote" value="144" class="promote btn btn-default" />
				<input type="submit" name="promote" value="377" class="promote btn btn-default" />
				<input type="submit" name="promote" value="987" class="promote btn btn-default" />
			</div>
		</div>
	</form>

	<div class="col-sm-2 node-score"><i class="icon-star"></i> <?= $node->getScore() ?></div>
</div>
