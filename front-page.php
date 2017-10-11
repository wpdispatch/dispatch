<?php

$context = Timber::get_context();
$context['post'] = new TimberPost();

Timber::render('templates/front-page.twig', $context);

?>
