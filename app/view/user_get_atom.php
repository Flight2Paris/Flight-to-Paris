<?php 

require (FEED_WRITER_PATH."/Item.php");
require (FEED_WRITER_PATH."/Feed.php");
require (FEED_WRITER_PATH."/ATOM.php");

use \FeedWriter\ATOM;

$feed = new ATOM;

$feed->setTitle("Nodes of " . $user->username . " | " . SITE_TITLE);
$feed->setLink($user->uri);

$feed->addNamespace('creativeCommons', 'http://backend.userland.com/creativeCommonsRssModule');
$feed->setChannelElement('creativeCommons:license', 'https://creativecommons.org/licenses/by-sa/3.0/');

$feed->addGenerator();

foreach ( $nodes as $node ) {

    $item = $feed->createNewItem();
    $author = $node->getAuthor();

    $item->setId($node->uri);
    $item->setTitle($node->getTitle());
    $item->setLink($node->uri);
    $item->setDescription(View::markdown($node->content));
    $item->setContent(View::markdown($node->content));
    $item->setAuthor($author->username, $author->uri);
    $item->setDate($node->created);
    $feed->addItem($item);

}

$feed = $feed->generateFeed();

header('Content-type: text/xml');

echo $feed;
