<h2 class="inline">¿Donde esta la meme?</h2>
<button id="refresh-captcha" name="refresh-captcha"><i class="icon-refresh"></i> Otra</button>
<input name="captcha" src="<?= View::makeUri('/lib/captcha/').'?'.time() ?>" alt="El captcha no cargo..." type="image" id="captcha">
