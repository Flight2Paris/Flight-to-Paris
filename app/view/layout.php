<!doctype html>
<html lang="es" prefix="og: http://ogp.me/ns#">
<head>
	<meta charset="UTF-8" />
    <title><?= $title? htmlentities($title).' - ':'' ?><?= htmlentities(SITE_TITLE) ?></title>
    <meta name="description" content="<?= htmlspecialchars(SITE_DESCRIPTION) ?>" />

<?php if ( $node ) : ?>
	<meta property="og:title" content="<?= View::e(trim($node->getTitle())) ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?= View::e($node->uri) ?>" />
	<meta property="og:image" content="" />
    <meta property="og:site_name" content="<?= htmlspecialchars(SITE_TITLE)  ?>" />
<?php endif ?>

	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/font-awesome.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/main.css') ?>" />
</head>
<body>

<header>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">

		<div class="pull-left span7">
        <a class="brand" href="<?= View::makeUri('/') ?>"><?= htmlentities(SITE_TITLE) ?></a>

		<form action="<?= View::makeUri('/') ?>" action="post" id="search" class="form-search navbar-form">
			<div class="input-append">
			<input type="search" name="q" class="input-largei search-query" placeholder="Que estas buscando?" />
			<button type="submit" class="btn"><i class="icon-search"></i> Buscar</button>
			</div>
		</form>

		</div>

		<div class="pull-right span4">
		<ul class="nav pull-right">
		<?php if ( auth::isLoggedIn() ) : ?>
			<li><a href="<?= View::makeUri('/f/') ?>"><i class="icon-upload-alt"></i>upload</a></li>
			<li><a href="<?= View::makeUri('/score') ?>"><i class="icon-star"></i><?= score::format(auth::getUser()->score) ?></a></li>
			<li>
				<div class="btn-group">
					<a class="btn btn-success" href="<?= View::e(auth::getUser()->uri) ?>"><i class="icon-user"></i> <?= View::e(auth::getUser()->username) ?></a>
					<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= View::makeUri('/auth/changepassword') ?>"><i class="icon-lock"></i> Cambiar contraseña</a></li>
						<li><a href="<?= View::makeUri('/auth/pubkey') ?>"><i class="icon-key"></i> Agregar llave</a></li>
						<li class="divider"></li>
						<li><a href="<?= View::makeUri('/auth/logout') ?>"><i class="icon-signout"></i> Salir</a></li>
					</ul>
				</div>
			</li>
		<?php else : ?>
		<li>
			<div class="btn-group">
				<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-signin"></i> Entrar</a>
				<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-caret-down"></i></a>
				<ul class="dropdown-menu" style="padding: 10px">
					<form action="<?= View::makeUri('/auth/login') ?>" method="post">
					<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span> <input id="input-username" type="text" name="username" placeholder="Usuario" /></div> <br />
					<div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span> <input type="password" name="password" placeholder="*****************" /></div> <br />
					<button type="submit" class="btn">("\(^o^)/")</button>
					</form>
					<li class="divider"></>
					<li><a href="<?= View::makeUri('/u/new') ?>"><i class="icon-plus-sign"></i> Registrate</a></li>
				</ul>
			</div>
		</li>
		<?php endif ?>
		</ul>
		</div>
    </div>
  </div>
</div>
</header>


	<div class="container">
		<content>
			<?php foreach ( Flight::flash('message') as $message ) : ?>
				<div class="alert alert-<?= View::e($message['type']) ?>">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<i class="<?= isset($message['icon']) ? View::e('icon-'.$message['icon']) : 'icon-exclamation-sign' ?>"></i> <?= View::e($message['text']) ?>
				</div>
			<?php endforeach ?>
			<?php Flight::clearFlash('message') ?>
			<?= $content ?>
		</content>
		<span class="clear"></span>
	</div>


	<div class="container">
	<footer>
		<a href="https://creativecommons.org/licenses/by-sa/3.0/" target="_blank" rel="nofollow"><img src="<?= View::makeUri('/assets/img/cc-by-sa.png') ?>" alt="Creative Commons Attribution-ShareAlike 3.0" title="Creative Commons Attribution-ShareAlike 3.0"/></a>
		<a href="https://github.com/rata0071/Flight-to-Paris" target="_blank" title="Flight to Paris - github" ><img src="<?= View::makeUri('/assets/img/github.png') ?>" alt="Github" /></a>
	</footer>
	</div>

	<script src="<?= View::makeUri('/assets/js/jquery.js') ?>"></script>
	<script>$(document).ready(function(){$('.dropdown-menu').find('form').click(function(e){e.stopPropagation();});});</script>
	<script src="<?= View::makeUri('/assets/js/bootstrap.min.js') ?>"></script>
	<script>var logged = <?= auth::isLoggedIn() ? 'true' : 'false' ?>, skip=<?= (int)$skip ?>, pagesize=<?= PAGESIZE ?>, query='<?= View::e($query) ?>', before=<?= (int)$before ?>, after=<?= (int)$after ?>, domain='<?= View::e(DOMAIN) ?>';</script>
	<script src="<?= View::makeUri('/assets/js/main.js') ?>"></script>
</body>
</html>
