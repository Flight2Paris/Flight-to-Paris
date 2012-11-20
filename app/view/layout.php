<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	<title><?= $title?$title.' - ':'' ?>esfriki</title>
	<meta name="description" content="Publica enlaces, mensajes o articulos sin entregar datos personales. Red social para el cambio de conciencia." />
	<meta name="keywords" content="red social, horizontalidad, desarrollo sostenible, tierra, libertad, privacidad, ecologia" />
	<link rel="shortcut icon" type="image/x-icon" href="<?= View::makeUri('/favicon.ico') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/css/normalize.css') ?>" charset="utf-8" />
	<link rel="stylesheet" href="<?= View::makeUri('/css/main.css') ?>" charset="utf-8" />
	<script src="<?= View::makeUri('/js/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?= View::makeUri('/js/pagedown/Markdown.Converter.js') ?>"></script>
	<script type="text/javascript" src="<?= View::makeUri('/js/pagedown/Markdown.Sanitizer.js') ?>"></script>
	<script type="text/javascript" src="<?= View::makeUri('/js/pagedown/Markdown.Editor.js') ?>"></script>
	<script>
		$(document).ready(function(){
			$('#login-dropdown').hide();
			$('#login-link').toggle(function(){
				$('#login-dropdown').show();
				$('#input-username').focus();
			}, function(){
				$('#login-dropdown').hide();
			});
			$('#user-dropdown').hide();
			$('#user-link').toggle(function(){
				$('#user-dropdown').show();
			}, function(){
				$('#user-dropdown').hide();
			});
		});
	</script>
</head>
<body>
	<header class="clear">
		<div class="pageWidth center clear">
			<a id="logo" href="<?= View::makeUri('/') ?>">esfriki</a>
			<?php if ( auth::isLoggedIn() ) : ?>
			<a href="javascript:void()" id="user-link"><?= View::e(auth::getUser()->username) ?></a> 
			<a title="Click aqui para ver más detalles" href="<?= View::makeUri('/score') ?>"><span id="score"><?= auth::getUser()->score ?></span></a>
			<?php else : ?>
			<a href="javascript:void()" id="login-link">entrar</a>
			<?php endif ?>

			<form action="/search/" action="post" id="search" class="right">
				<input type="search" name="q" id="searchField" placeholder="buscar..." />
				<input type="image" id="searchButton" src="<?= View::makeUri('/images/search.png') ?>" alt="search" />
			</form>
		</div>
		<div class="pageWidth center clear">
		<?php if ( auth::isLoggedIn() ) : ?>
		<div id="user-dropdown">
				<a href="<?= View::makeUri('/auth/changepassword') ?>">Cambiar contraseña</a><br />
				<a href="<?= View::makeUri('/auth/pubkey') ?>">Agregar llave pública</a><br />
				<a href="<?= View::makeUri('/auth/logout') ?>">Salir</a><br />
		</div>
		<?php else : ?>
		<div id="login-dropdown">
			<form action="<?= View::makeUri('/auth/login') ?>" method="post">
				<input id="input-username" type="text" name="username" placeholder="Usuario" class="block" title="Usuario" />
				<input type="password" name="password" placeholder="*****************" title="Password" class="block" />
				<input type="submit" value='("\(^o^)/")' class="blocl"/>
			</form>
			<a href="<?= View::makeUri('/u/new') ?>" class="small">registrate</a>
		</div>
		<?php endif ?>
		</div>
	</header>


	<div id="wrapper" class="center pageWidth clear">

		<noscript><img id="noscript" src="<?= View::makeUri('/images/noscript.png') ?>" alt="Habilita JavaScript para chucherias :)" title="Habilita JavaScript para chucherias :)" onload="$('#noscript').hide();" /></noscript>

		<content>
			<?php if ( Flight::get('login-error') ) : ?> <span class="red"><?= Flight::get('login-error') ?></span><?php endif ?>
			<?php if ( Flight::get('error') ) : ?><span class="red"><?= Flight::get('error') ?></span><?php endif ?>
			<?php if ( Flight::get('notice') ) : ?><span><?= Flight::get('notice') ?></span><?php endif ?>
			<?= $content ?>
		</content>
		<span class="clear"></span>
	</div>
	<footer class="center pageWidth clear">
		<a href="https://creativecommons.org/licenses/by-sa/3.0/" target="_blank" rel="nofollow"><img src="<?= View::makeUri('/images/cc-by-sa.png') ?>" alt="Creative Commons Attribution-ShareAlike 3.0" title="Creative Commons Attribution-ShareAlike 3.0"/></a>
		<a href="https://github.com/rata0071/Flight-to-Paris" target="_blank" title="Flight to Paris - github" ><img src="<?= View::makeUri('/images/github.png') ?>" alt="Github" /></a>
	</footer>
        <script type="text/javascript">
            (function () {
                var converter = Markdown.getSanitizingConverter();
                var editor = new Markdown.Editor(converter);
        //        editor.run();
			})();

        </script>
</body>
</html>
