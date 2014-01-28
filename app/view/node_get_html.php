<?php 
$n = $node; 
$open = 1;

// If the node is a reply show the original
if ( $node->isReply() ) {
	$node = $n->getReplyTo();
	include('singlenode.php');
	$node = $n ;
}

// Show the visited node
include('singlenode.php');

// Show the replies to the node
foreach ( $n->getReplies() as $node ) {
	include('singlenode.php');
}

// Show the comment form
$inReplyTo = $node->uri;
include('postform.php');

?>
