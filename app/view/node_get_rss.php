<?php

require (FEED_WRITER_PATH."/Item.php");
require (FEED_WRITER_PATH."/Feed.php");
require (FEED_WRITER_PATH."/RSS2.php");

use \FeedWriter\RSS2;

$feed = new RSS2;

$feed->setTitle($node->getTitle() . SITE_TITLE);
$feed->setLink($node->uri);
$feed->setDescription(SITE_DESCRIPTION);

$feed->addNamespace('creativeCommons', 'http://backend.userland.com/creativeCommonsRssModule');
$feed->setChannelElement('creativeCommons:license', 'https://creativecommons.org/licenses/by-sa/3.0/');

$feed->addGenerator();

$nodes = Array();

if ($node->isReply()) {
    $nodes[] = $node->getReplyTo();
}

$nodes[] = $node;

$nodes = array_merge($nodes, $node->getReplies());

foreach ( $nodes as $node ) {

    $item = $feed->createNewItem();
    $author = $node->getAuthor();

    $item->setId($node->uri);
    $item->setTitle($node->getTitle());
    $item->setLink($node->uri);
    $item->setDescription(View::markdown($node->content));
    $item->setAuthor($author->username, $author->uri);
    $item->setDate($node->created);

    $feed->addItem($item);

}

$feed = $feed->generateFeed();

header('Content-type: text/xml');

echo $feed;
