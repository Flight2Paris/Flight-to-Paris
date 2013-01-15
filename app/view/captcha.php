<h2 class="inline">¿Donde esta la meme?</h2>
<button id="refresh-captcha"><i class="icon-refresh"></i> Otra</button>
<input name="captcha" src="<?= View::makeUri('/lib/captcha/').'?'.time() ?>" alt="El captcha no cargo..." type="image" id="captcha">
<script>
$(document).ready(function() {

	var captcha = $('#captcha');

	$('#refresh-captcha').click(function(e){
		if ( ! captcha.hasClass('loading') ) {
			e.preventDefault();
			captcha.addClass('loading');
			captcha.attr('src','<?= View::makeUri('/assets/img/loading.gif') ?>');
		}
	});

	captcha.load(function(){
		if ( captcha.hasClass('loading') ) {
			d = new Date();
			captcha.removeClass('loading');
			captcha.attr('src','<?= View::makeUri('/lib/captcha/?') ?>'+d.getTime());
		}
	});
});
</script>
