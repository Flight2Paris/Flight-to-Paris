<h1>Score</h1>
<p><strong>Every point has a corresponding blackhole somewhere in the universe.</strong> By games, earning badges and random fluctuations some of this blackholes are assigned to you, and you can use them for giving mass to a node or reassigning them to other users.</p>
<?php if ( auth::isLoggedIn() ) : ?>
	<?php if ( Flight::get('user')->fibo > 7 ) : ?>
		<p><strong>Get back later</strong></p>
	<?php else : ?>
		<form action="<?= View::makeUri('/score/') ?>" method="post" >
		<p>Where is the meme? <input name="reload-captcha" alt="reload captcha" src="http://esfriki.com/images/reload.png" id="reload-captcha" class="inline-button" type="image"></p>
		<input name="captcha" src="http://esfriki.com/captcha/" alt="captcha" type="image">
		</form>
	<?php endif ?>
<?php endif ?>

<h1>Leaders</h1>
<?php $i = 0 ?>
<table>
<?php foreach ( model_user::getLeaders(20) as $leader ) : ?>
<?php $i ++ ?>
<tr><td>#<?= $i ?></td><td><a href="<?= $leader->uri ?>"><?= htmlentities($leader->username) ?></a></td><td><?= $leader->score ?></td></tr>
<?php endforeach ?>
</table>
