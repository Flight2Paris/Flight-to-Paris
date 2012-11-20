<?php if ( auth::isLoggedIn() ) : ?>
<form id="post" action="/" method="POST">
	<div id="wmd-button-bar"></div>
	<textarea name="content" id="post-content" placeholder="Compartí algo"></textarea>

	<span class="clear right block">
		<input type="submit" value="Publicar" />
	</span>
	<span class="block clear"></span>
</form>
<?php endif ?>
<?php foreach ( $nodes as $node ) : ?>
	<div class="node">
		<div class="node-author left">
		<?php $author = $node->getAuthor() ?>
		<?php if ( $author ) : ?><a href="<?= View::e($author->uri) ?>" class="author"><?= View::e($author->username) ?></a><?php endif ?>
		</div>

		<div class="right node-short">
		<?php if ( mb_strlen($node->content) > 140 ) : ?>
		<?= View::markdown(trim(mb_substr($node->content,0,140)).'...',false) ?>
		<?php else : ?>
		<?= View::markdown($node->content,false) ?>
		<?php endif ?>
		</div>

<?php include('actions.php') ?> 

		<div class="clear"></div>
	</div>
<?php endforeach ?>

<script>
$(document).ready(function(){
	var logged = <?= auth::isLoggedIn() ? 'true' : 'false' ?>;

	$('.node').click(function(e){
		if ( ['A','SUBMIT','INPUT','IMG'].indexOf(e.target.nodeName) != '-1' ) {
		} else {
			e.preventDefault();
			if ( $(this).children('.node-full').length > 0 ) { 
				$(this).children('.node-short').toggle(200);
				$(this).children('.node-full').toggle(200);
			} else {
				uri = $(this).children('.node-actions').children('a.uri').attr('href');
				$(this).children('.node-short').after('<div class="node-full right"><img src="/images/loading.gif" alt="cargando" title="Cargando..." /></div>');
				$(this).children('.node-short').hide();
				$(this).children('.node-full').load(uri);
			}
		}
	});

	$('.score-form').fadeTo(100,0.1);

	$('.node').hover(
		function () { $(this).addClass("node-hover").children('.node-actions').children('.score-form').fadeTo(10,1); },
		function () { $(this).removeClass("node-hover").children('.node-actions').children('.score-form').fadeTo(50,0.1); }
	);

	$('.promote').click(function(e){
		if ( logged ) {
			e.preventDefault();
			form = $(this).closest('form');
			val = $(this).val();
			uri = form.children('input[name="uri"]').val();
			score = form.closest('.node').children('.node-actions').children('.node-score');
			score.text(parseInt(score.text()) + parseInt(val));
			$('#score').text(parseFloat($('#score').text()) - parseFloat(val));
			$.post(form.attr('action'),{"uri": uri, "promote": val},function(data){

			});

		}
	});


	var postanimate = function(target) {
		l = target.val().length;
		if ( l > 60 && l <= 240 ) {
			if ( parseInt(target.css('height')) != 200 ) {
				target.animate( {'height':'200px'},300 ); 
			}
		} else if ( l > 240 ) {
			if ( parseInt(target.css('height')) != 560 ) {
				target.animate( {'height':'560px'},300 ); 
			}
		} else {
			if ( parseInt(target.css('height')) != 84 ) {
				target.animate( {'height':'84px'},300 ); 
			}
		}
	}

	$('#post-content').focus(function(event){ 
		postanimate($(event.target));
	});
	$('#post-content').blur(function(event){ 
		$(event.target).animate( {'height':'28px'},300 ); 
	});
	$('#post-content').keyup(function(event){ 
		postanimate($(event.target));
	});
});
</script>
