<form action="<?= View::makeUri('/auth/changepassword') ?>" method="POST">
<input type="password" name="password" placeholder="password" class="block" />
<input type="password" name="newpassword" placeholder="new password" class="block" />
<input type="password" name="repeatpassword" placeholder="repeat" class="block" />
<input type="submit" value="Change password" />
</form>
