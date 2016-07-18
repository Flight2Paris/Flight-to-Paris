<?php

// Show the visited node
include('singlenode.php');
$orig = $node;
?>
<div class="replies">
<?php
// Show the replies to the node
foreach ( $orig->getReplies() as $node ) {
	include('nodewithreplies.php');
}
?></div>
