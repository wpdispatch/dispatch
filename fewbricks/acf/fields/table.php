<?php

namespace fewbricks\acf\fields;

/**
 * Class table
 * @package fewbricks\acf\fields
 */
class table extends field {

    public function __construct($label, $name, $key, $custom_settings = []) {

        $base_settings = [
            'type' => 'table',
        ];

        // This call must be present
        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}
