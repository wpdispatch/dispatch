<?php

$context = Timber::get_context();
$context['post'] = new TimberPost();

Timber::render('templates/404.twig', $context);

?>
