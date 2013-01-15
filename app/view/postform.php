<?php if ( auth::isLoggedIn() ) : ?>
<form id="post" action="/" method="POST">
	<div id="wmd-button-bar"></div>
	<textarea name="content" id="post-content" placeholder="Compartí algo"></textarea>

	<span class="clear right block">
		<button type="submit" class="btn"><i class="icon-save"></i> Publicar</button>
	</span>
	<span class="block clear"></span>
</form>
<?php endif ?>
