<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>esfriki</title>
	<meta name="description" content="Let Users Be" />
	<meta name="keywords" content="All, Your, Base, Are, Belong, To, Us" />
	<link rel="shortcut icon" type="image/x-icon" href="<?= View::makeUri('/favicon.ico') ?>" />
	<link rel="stylesheet" href="<?= View::makeUri('/css/normalize.css') ?>" charset="utf-8" />
	<link rel="stylesheet" href="<?= View::makeUri('/css/main.css') ?>" charset="utf-8" />
	<script src="<?= View::makeUri('/js/jquery.js') ?>"></script>
</head>
<body>
	<header class="clear">
		<div class="pageWidth center clear">
			<a id="logo" href="<?= View::makeUri('/') ?>">esfriki</a>
			<a href="<?= View::makeUri('/u/new') ?>">register</a>
			<form action="/search/" action="post" id="search" >
				<input type="search" name="q" id="searchField" placeholder="All your base..." />
				<input type="image" id="searchButton" src="<?= View::makeUri('/images/search.png') ?>" alt="search" />
			</form>
		</div>
	</header>

	<div id="wrapper" class="center pageWidth clear">
		<content>
			<?= $content ?>
		</content>
		<div class="right" id="menu">
			<form action="<?= View::makeUri('/auth/login') ?>" method="post">
				<input type="text" name="username" placeholder="Username" />
				<input type="password" name="password" placeholder="*****************" />
				<input type="submit" value='("\(^o^)/")' />
			</form>
			<?php if ( Flight::get('login-error') ) : ?> <span class="red"><?= Flight::get('login-error') ?></span><?php endif ?>
			<hr />
			<h4>Markdown</h4>
			<strong>**strong**</strong>
			<em>_emphasis_</em>
			<h1>#header 1</h1>
			<h2>##header 2</h2>
			<h1><a href="/markdown" title="markdown">...</a></h1>
		</div>
		<span class="clear"></span>
	</div>
	<footer class="center pageWidth clear">
		<a href="https://creativecommons.org/licenses/by-sa/3.0/" target="_blank" rel="nofollow"><img src="<?= View::makeUri('/images/cc-by-sa.png') ?>" alt="Creative Commons Attribution-ShareAlike 3.0" title="Creative Commons Attribution-ShareAlike 3.0"/></a>
		<img src="<?= View::makeUri('/images/github.png') ?>" alt="Github" />
	</footer>
</body>
</html>
