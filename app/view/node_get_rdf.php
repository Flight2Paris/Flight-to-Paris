<?xml version="1.0"?>

<rdf:RDF
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:dc= "http://purl.org/dc/elements/1.1/">

<rdf:Description rdf:about="<?= View::e($node->uri) ?>">
  <dc:description><?= View::e( $node->getTitle() ) ?></dc:description>
  <dc:date><?= date('Y m d', strtotime($node->created)) ?></dc:date>
<?php if ( $author = $node->getAuthor() ) : ?>
  <<?= AUTHOR_URI ?>><?= $author->uri ?></<?= AUTHOR_URI ?>>
</rdf:Description>

</rdf:RDF>
