
		<div class="row-fluid">
			<form action="<?= View::makeUri('/u/new') ?>" method="post" id="register">
			<div class="col-md-4">
				<h2>Registrate</h2>
					<div class="form-group">
						<label for="input-username"><i class="icon-user"></i> Usuario</label>
						<input id="input-username" class="form-control nosubmit" type="text" name="username" placeholder="Usuario" />
					</div>
					<div class="form-group">
						<label for="input-password"><i class="icon-lock"></i> Contraseña</label>
						<input id="input-password" class="form-control nosubmit" type="password" name="password" placeholder="*****************" />
					</div>
					<div class="form-group">
						<label for="input-password-repeat"><i class="icon-lock"></i> Repeti la contraseña</label>
						<input id="input-password-repeat" class="form-control nosubmit" type="password" name="password-repeat" placeholder="*****************" />
					</div>
			</div>
			<div class="col-md-4">
				<?= View::markdown('Acepto que todo sera compartido bajo licencia [CC-BY-SA 3.0](https://creativecommons.org/licenses/by-sa/3.0/) y no puede ser eliminado. **Los bots aburridos seran perseguidos**. All your base are belong to us.') ?>
				<?php include('captcha.php') ?>
			</div>
			</form>
			<div class="col-md-4">
				<h2>Entrá</h2>
					<form action="<?= View::makeUri('/auth/login') ?>" method="post">
					<div class="form-group">
						<label for="input-username"><i class="icon-user"></i> Usuario</label>
						<input id="input-username" class="form-control" type="text" name="username" placeholder="Usuario" />
					</div>
					<div class="form-group">
						<label for="input-password"><i class="icon-lock"></i> Contraseña</label>
						<input class="form-control" type="password" name="password" placeholder="*****************" />
					</div>
					<button type="submit" class="btn btn-default">("\(^o^)/")</button>
					</form>
			</div>
		</div>
