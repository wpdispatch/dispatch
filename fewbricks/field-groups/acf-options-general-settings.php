<?php

use fewbricks\bricks AS bricks;
use fewbricks\acf AS fewacf;
use fewbricks\acf\fields AS acf_fields;

use Dispatch\Plugins\ACF as ACF;

$fewbricks_fg_location = [
    [
        [
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'acf-options-general-settings',
        ],
    ]
];

/**
 * Pages
 */
$fewbricks_fg = (new fewacf\field_group('Pages', '201705080927a', $fewbricks_fg_location, 10, [
        // 'style' => 'seamless'
    ]));
$fewbricks_fg->add_field( ACF::page( 'Contact Page', 'contact_page', '201705080927aa' ) );
$fewbricks_fg->register();

/**
 * Forms
 */
$fewbricks_fg = (new fewacf\field_group('Forms', '201705111700a', $fewbricks_fg_location, 20, [
        // 'style' => 'seamless'
    ]));
$fewbricks_fg->add_field( ACF::form( 'Contact Form', 'contact_form', '201705111700b' ) );
$fewbricks_fg->register();

/**
 * Footer
 */
$fewbricks_fg = (new fewacf\field_group('Footer', '134211052017a', $fewbricks_fg_location, 40));
$fewbricks_fg->add_field((new acf_fields\text('Copyright', 'footer_copyright', '134211052017aa'))->set_settings(array(
        'wrapper' => ['width' => 50]
    )));
$fewbricks_fg->register();
