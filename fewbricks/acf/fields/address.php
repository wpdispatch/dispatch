<?php

namespace fewbricks\acf\fields;

/**
 * Class address
 * @package fewbricks\acf\fields
 */
class address extends field {

    public function __construct($label, $name, $key, $custom_settings = []) {

        $base_settings = [
            'type' => 'address',
        ];

        // This call must be present
        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}