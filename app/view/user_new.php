<p><em><a href="<?= View::makeUri('/u/new') ?>">REGISTER</a></em></p>
<form action="<?= View::makeUri('/u/new') ?>" method="post" id="register">
	<input type="text" name="username" placeholder="Username" />
	<input type="password" name="password" placeholder="******************" />
	<small>Not stored.</small>
	<input type="email" name="email" placeholder="Email" /> 
	<?= View::markdown('I accept everything published will be shared under [CC-BY-SA 3.0 license](https://creativecommons.org/licenses/by-sa/3.0/) and cannot be deleted. A confirmation email will be sent to the provided email address but will never be stored in our databases. **Bots will be pursued**. All your base are belong to us.') ?>
	<input type="checkbox" name="accept" />
	<br/>

	<textarea class="markdown" name="homepage" placeholder="i **love** [justin bieber](http://www.frikipedia.es/friki/Justin_Bieber)"></textarea>
	<input type="submit" value="register" />
</form>
