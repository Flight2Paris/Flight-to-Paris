<?php include('pubkey.php') ?>
<form action="<?= View::makeUri('/auth/addkey') ?>" method="POST">
<input type="password" name="password" placeholder="contraseña" class="block" />
<textarea name="public_key" placeholder="========================================================     TU-LLAVE-PUBLICA-ACA      ========= ============================================" class="clear block bigmarkdown" ></textarea>
<input type="submit" value="Publicar llave" />
</form>
