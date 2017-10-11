<?php

namespace fewbricks\acf\fields;

/**
 * Class smart_button
 * @package fewbricks\acf\fields
 */
class smart_button extends field {

    public function __construct($label, $name, $key, $custom_settings = []) {

        $base_settings = [
            'type' => 'smart_button',
        ];

        // This call must be present
        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}
