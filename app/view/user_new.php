<h1 class="red">Registrate</h1>
<form action="<?= View::makeUri('/u/new') ?>" method="post" id="register">
	<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span> <input type="text" name="username" placeholder="Usuario" title="Usuario" /></div> <br />
	<div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span> <input type="password" name="password" placeholder="*****************" title="Password" /></div> <br />
	<?= View::markdown('Acepto que todo sera compartido bajo licencia [CC-BY-SA 3.0](https://creativecommons.org/licenses/by-sa/3.0/) y no puede ser eliminado. **Los bots aburridos seran perseguidos**. All your base are belong to us.') ?>
	<?php include('captcha.php') ?>
</form>

