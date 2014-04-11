<form action="<?= View::makeUri( '/score/send' ) ?>" method="post" class="form-inline" >

<div class="col-sm-8">

	<div class="form-group">
		<label class="col-sm-2"><i class="icon-user pull-right"></i></label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="user_uri" placeholder="URI del destinatario" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2"><i class="icon-star pull-right"></i></label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="amount" placeholder="Cantidad" />
		</div> 
	</div>

	<div class="form-group">
		<button class="btn submit pull-right"><i class="icon-share-alt"></i> Enviar</button>
	</div>
</div>

</form>
