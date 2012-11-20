<form action="<?= View::makeUri('/auth/changepassword') ?>" method="POST">
<input type="password" name="password" placeholder="contraseña" class="block" />
<input type="password" name="newpassword" placeholder="nueva contraseña" class="block" />
<input type="password" name="repeatpassword" placeholder="repetir" class="block" />
<input type="submit" value="Cambiar contraseña" />
</form>
