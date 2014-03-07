<div class="row-fluid node-actions">

	<div class="col-sm-5">
	<a href="<?= View::e($node->uri) ?>" class="uri" ><?= View::e($node->uri) ?></a> &nbsp; 
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
	<input type="submit" name="promote" value="2" class="promote btn btn-default" />
	<input type="submit" name="promote" value="3" class="promote btn btn-default" />
	<input type="submit" name="promote" value="5" class="promote btn btn-default" />
	<input type="submit" name="promote" value="8" class="promote btn btn-default" />
	</div>

	<div class="btn-group">
	<div class="input-group">
		<input type="text" name="promote" value="1000" class="form-control" style="max-width:150px" />
		<span class="input-group-btn">
			<button class="btn btn-default submit promote" type="button"><i class="icon-plus-sign"></i></button>
		</span>
	</div>
	</div>

	</div>
	</form>

	<div class="col-sm-2 node-score"><i class="icon-star"></i> <?= $node->getScore() ?></div>
</div>
