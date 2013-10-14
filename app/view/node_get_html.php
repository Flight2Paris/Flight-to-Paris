<?php 

$n = $node; 
$open = 1;

if ( $node->isReply() ) : 
	$node = $n->getReplyTo();
	include('singlenode.php');
endif 

?>

<?php $node = $n ?>
<?php 
include('singlenode.php');
foreach ( $n->getReplies() as $node ) :
	$class = 'comment';
	include('singlenode.php');
endforeach 
?>

<?php if ( auth::isLoggedIn() ) : ?>
<span class="red">Comentar:</span>
<form id="reply" action="/" method="POST" >
	<input type="hidden" name="type" value="<?= REPLY_URI ?>" />
	<input type="hidden" name="to" value="<?= View::e($node->uri) ?>" />
	<div class="row-fluid">
	<div class="span10"><textarea name="content" class="input-block-level" id="post-content" placeholder="Comenta o agrega información." ></textarea></div>
	<div class="span2"><button class="btn submit pull-right">
		<i class="icon-save"></i> Guardar
	</button></div>
</form>
<?php endif ?>
