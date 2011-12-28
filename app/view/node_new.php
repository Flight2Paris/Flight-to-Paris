<form action="<?= View::makeUri(View::e('/new')) ?>" method="POST">
<h1><?= View::makeUri($uri) ?></h1>
<span class="clear right">
<input type="image" alt="Save" title="Save" src="<?= View::makeUri('/images/save.png') ?>" />
</span><br />
<textarea class="bigmarkdown" name="content"></textarea>
</form>
