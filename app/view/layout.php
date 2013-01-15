<!doctype html>
<html land="es">
<head>
	<meta charset="UTF-8" />
	<title><?= $title?$title.' - ':'' ?>esfriki</title>
	<meta name="description" content="Ciencia, tecnologia, documentales, noticias y cosas frikis. Comparte informacion, archivos y enlaces. Crea posts con enlaces cortos." />

	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/font-awesome.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/main.css') ?>" />
</head>
<body>
	<header class="clear">
		<div class="pageWidth center clear">
			<a id="logo" class="white" href="<?= View::makeUri('/') ?>">esfriki</a>

			<form action="<?= View::makeUri('/') ?>" action="post" id="search" class="form-search inline">
				<div class="input-append">
				<input type="search" name="q" id="searchField" class="input-large search-query" placeholder="Que estas buscando?" />
				<button type="submit" class="btn" id="searchButton"><i class="icon-search"></i> Buscar</a>
				</div>
			</form>

			<?php if ( auth::isLoggedIn() ) : ?>
			<a href="<?= View::makeUri('/score') ?>" id="score" class="white"><?= auth::getUser()->score ?></a>

			<div class="btn-group inline right">
				<a class="btn btn-success" href="<?= View::e(auth::getUser()->uri) ?>"><i class="icon-user"></i> <?= View::e(auth::getUser()->username) ?></a>
				<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?= View::makeUri('/auth/changepassword') ?>"><i class="icon-lock"></i> Cambiar contraseña</a></li>
					<li><a href="<?= View::makeUri('/auth/pubkey') ?>"><i class="icon-key"></i> Agregar llave</a></li>
					<li class="divider"></li>
					<li><a href="<?= View::makeUri('/auth/logout') ?>"><i class="icon-signout"></i> Salir</a></li>
				</ul>
			</div>
			<?php else : ?>
			<div class="btn-group inline right">
				<a class="btn btn-danger" href="/u/new"><i class="icon-signin"></i> Entrar</a>
				<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
				<ul class="dropdown-menu" style="padding: 10px">
					<form action="<?= View::makeUri('/auth/login') ?>" method="post">
					<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span> <input id="input-username" type="text" name="username" placeholder="Usuario" /></div>
					<div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span> <input type="password" name="password" placeholder="*****************" /></div>
					<button type="submit" class="btn">("\(^o^)/")</button>
					</form>
					<li class="divider"></>
					<li><a href="<?= View::makeUri('/u/new') ?>"><i class="icon-plus-sign"></i> Registrate</a></li>
				</ul>
			</div>
			<?php endif ?>
		</div>
	</header>


	<div id="wrapper" class="center pageWidth clear">
		<content>
			<?php if ( Flight::get('error') ) : ?><span class="red"><i class="icon-exclamation-sign"></i> <?= Flight::get('error') ?></span><?php endif ?>
			<?php if ( Flight::get('notice') ) : ?><span><i class="icon-exclamation-sign"></i> <?= Flight::get('notice') ?></span><?php endif ?>
			<?= $content ?>
		</content>
		<span class="clear"></span>
	</div>

	<footer class="center pageWidth clear">
		<a href="https://creativecommons.org/licenses/by-sa/3.0/" target="_blank" rel="nofollow"><img src="<?= View::makeUri('/assets/img/cc-by-sa.png') ?>" alt="Creative Commons Attribution-ShareAlike 3.0" title="Creative Commons Attribution-ShareAlike 3.0"/></a>
		<a href="https://github.com/rata0071/Flight-to-Paris" target="_blank" title="Flight to Paris - github" ><img src="<?= View::makeUri('/assets/img/github.png') ?>" alt="Github" /></a>
	</footer>

	<script src="<?= View::makeUri('/assets/js/jquery.js') ?>"></script>
	<script>$(document).ready(function(){$('.dropdown-menu').find('form').click(function(e){e.stopPropagation();});});</script>
	<script src="<?= View::makeUri('/assets/js/bootstrap.min.js') ?>"></script>
	<script>var logged = <?= auth::isLoggedIn() ? 'true' : 'false' ?>, skip=<?= (int)$skip ?>, pagesize=<?= PAGESIZE ?>, query='<?= View::e($query) ?>', before=<?= (int)$before ?>, after=<?= (int)$after ?>, domain='<?= View::e(DOMAIN) ?>';</script>
	<script src="<?= View::makeUri('/assets/js/main.js') ?>"></script>
</body>
</html>
