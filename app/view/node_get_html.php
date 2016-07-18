<?php 
$n = $node; 
$open = 1;

// If the node is a reply show the original
if ( $node->isReply() ) {
	$node = $n->getReplyTo();
	include('singlenode.php');
	$node = $n;
	?><hr /><?php
}

include('nodewithreplies.php');

// Show the comment form
$inReplyTo = $n->uri;
include('postform.php');

?>
