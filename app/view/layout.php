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

    <link rel="alternate" type="application/rss+xml"  href="<?= View::makeUri('/all.rss') ?>" title="Nodes Feed (RSS)">
    <link rel="alternate" type="application/atom+xml"  href="<?= View::makeUri('/all.atom') ?>" title="Nodes Feed (ATOM)">
<?php if (isset($feeds)) foreach ($feeds as $feed) : ?>
    <link rel="alternate" type="application/rss+xml"  href="<?=$feed->uri?>"  title="<?=htmlspecialchars($feed->title)?>">
<?php endforeach; ?>
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/font-awesome.css') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/assets/css/main.css') ?>" />
</head>
<body>

<header>
<div class="navbar navbar-inverse navbar-fixed-top">

		<div class="navbar-header">
        <a class="navbar-brand" href="<?= View::makeUri('/') ?>"><?= htmlentities(SITE_TITLE) ?></a>
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
		<span class="sr-only">Mostrar menú</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		</div>

		<form action="<?= View::makeUri('/') ?>" action="post" id="search" class="form-search navbar-form navbar-left hidden-xs" role="search">
			<div class="form-group">
			<input type="search" name="q" class="form-control" placeholder="Que estas buscando?" />
			</div>
			<button type="submit" class="btn"><i class="icon-search"></i> Buscar</button>
		</form>

		<ul class="nav navbar-nav navbar-right hidden-xs">
		<?php if ( auth::isLoggedIn() ) : ?>
			<li><a href="#" data-toggle="collapse" data-target="#exchange-menu"><i class="icon-exchange"></i> exchange</a></li>
			<li><a href="#" data-toggle="collapse" data-target="#follow-menu"><i class="icon-plus-sign"></i> follow</a></li>
			<li><a href="#" data-toggle="collapse" data-target="#upload-menu"><i class="icon-upload-alt"></i> upload</a></li>
			<li><a href="<?= View::makeUri('/score') ?>"><i class="icon-star"></i> <?= score::format(auth::getUser()->score) ?></a></li>
		<?php endif ?>
		</ul>

</div>

<div class="collapse submenu" id="menu">
	<div class="container">
		<div class="row-fluid visible-xs">
		<form action="<?= View::makeUri('/') ?>" action="post" id="search" class="form-search form-inline" role="search">
			<div class="form-group">
			<input type="search" name="q" class="form-control" placeholder="Que estas buscando?" />
			</div>
			<button type="submit" class="btn btn-default"><i class="icon-search"></i> Buscar</button>
		</form>
		</div>
    </div>
</div>

<div class="collapse submenu" id="follow-menu">
	<div class="container">
		<div class="row-fluid">
		<?php include 'user_follow.php' ?>
		</div>
	</div>
</div>

<div class="collapse submenu" id="exchange-menu">
	<div class="container">
		<div class="row-fluid">
		<?php include 'score_exchange.php' ?>
		</div>
	</div>
</div>

<div class="collapse submenu" id="upload-menu">
	<div class="container">
		<div class="row-fluid">
		<?php include 'fileform.php' ?>
		</div>
	</div>
</div>

</header>

	<div class="container-fluid">
		
		<content>
			<?php foreach ( Flight::flash('message') as $message ) : ?>
				<div class="alert alert-<?= View::e($message['type']) ?>">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<i class="<?= isset($message['icon']) ? View::e('icon-'.$message['icon']) : 'icon-exclamation-sign' ?>"></i> <?= View::e($message['text']) ?>
				</div>
			<?php endforeach ?>
			<?php Flight::clearFlash('message') ?>

			<div class="col-md-3" id="sidebar">

			<?php if (auth::isLoggedIn()) : 
				require('user_sidebar.php');
			else : 
				require('public_sidebar.php'); 
			endif ?>
			</div>
			<div class="col-md-9">

			<?= $content ?>

			</div>
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
