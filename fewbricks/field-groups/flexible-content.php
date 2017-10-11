<?php

use fewbricks\bricks AS bricks;
use fewbricks\acf AS fewacf;
use fewbricks\acf\fields AS acf_fields;

use Dispatch\Plugins\ACF as ACF;

$fewbricks_fg_location = [
    [
        [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
        ],
    ]
];

ACF::hide_on_screen( $fewbricks_fg_location );

$fewbricks_fg = (new fewacf\field_group('Flexible Content', '201708301301a', $fewbricks_fg_location, 0, [
        'position' => 'acf_after_title'
    ]));
$fewbricks_fg->add_brick((new bricks\flexible_content('flexible_content', '201708301301aa')));
$fewbricks_fg->register();
