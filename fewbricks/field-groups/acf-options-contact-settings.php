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
            'value' => 'acf-options-contact-settings',
        ],
    ]
];

/**
 * Contact Details
 */
$fewbricks_fg = (new fewacf\field_group('Contact Details', '103105062017a', $fewbricks_fg_location, 40));
$fewbricks_fg->add_field((new acf_fields\text('Phone Number', 'contact_phone', '103105062017aa'))->set_settings(array(
        'wrapper' => ['width' => 33]
    )));
$fewbricks_fg->add_field((new acf_fields\address('Sales Address', 'contact_address', '103105062017ab'))->set_settings(array(
        'wrapper' => ['width' => 100]
    )));
$contact_hours = new acf_fields\repeater('Hours', 'contact_hours', '103105062017ac', [
  'button_label' => 'Add Hours'
]);
  $contact_hours->add_sub_field(new acf_fields\text('Label', 'label', '103105062017aca'));
  $contact_hours->add_sub_field(new acf_fields\text('Time', 'time', '103105062017acb'));
$fewbricks_fg->add_field($contact_hours);
$fewbricks_fg->register();
