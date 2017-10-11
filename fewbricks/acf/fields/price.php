<?php

namespace fewbricks\acf\fields;

/**
 * Class price
 * @package fewbricks\acf\fields
 */
class price extends field {

    public function __construct($label, $name, $key, $custom_settings = []) {

        $base_settings = [
            'type' => 'price',
        ];

        // This call must be present
        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}
