<?php

namespace fewbricks\acf\fields;

/**
 * Class gravity_form
 * @package fewbricks\acf\fields
 */
class gravity_form extends field {

    public function __construct($label, $name, $key, $custom_settings = []) {

        $base_settings = [
            'type' => 'gravity_forms_field',
        ];

        // This call must be present
        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}
