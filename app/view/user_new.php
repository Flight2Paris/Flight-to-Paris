<p><em><a href="<?= View::makeUri('/u/new') ?>">Become an esfriki citizen</a></em></p>
<form action="<?= View::makeUri('/u/new') ?>" method="post" id="register">
	<input type="text" name="username" placeholder="Username" />
	<input type="password" name="password" placeholder="******************" />
	<?= View::markdown('I accept everything published will be shared under [CC-BY-SA 3.0 license](https://creativecommons.org/licenses/by-sa/3.0/) and cannot be deleted. **Boring bots will be pursued**. All your base are belong to us.') ?>

	<textarea class="markdown" name="homepage" placeholder="i **love** [justin bieber](http://www.frikipedia.es/friki/Justin_Bieber)"></textarea>
	<p>Where is the meme? <input name="reload-captcha" type="image" alt="reload captcha" src="<?= View::makeUri('/images/reload.png') ?>" id="reload-captcha" class="inline-button" /></p>
	<input type="image" name="captcha" src="<?= View::makeUri('/captcha/') ?>" alt="captcha" />
</form>
