
<form action="<?= View::makeUri( '/score/send' ) ?>" method="post" >

	<div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span> <input type="text" name="user_uri" placeholder="URI del destinatario" /></div> <br />
	<div class="input-prepend"><span class="add-on"><i class="icon-star"></i></span> <input type="text" name="amount" placeholder="Cantidad" /></div> <br />

	<button class="btn submit"><i class="icon-share-alt"></i> Enviar</button>

</form>
