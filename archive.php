<?php

$context = Timber::get_context();
$context['posts'] = new Timber\PostQuery;

Timber::render('templates/archive.twig', $context);
