<h4 class="inline">Hace click en el captcha</h4>
<button id="refresh-captcha" name="refresh-captcha" type="button"><i class="icon-refresh"></i> Cargar otra imagen</button><br />
<br />
<input name="captcha" src="<?= View::makeUri('/lib/captcha/').'?'.time() ?>" alt="El captcha no cargo..." type="image" id="captcha" /><br />
