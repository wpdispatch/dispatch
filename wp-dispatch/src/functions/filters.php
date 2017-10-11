<?php

namespace Dispatch\Functions;

class Filters {

    public function __construct() {

    }

    public static function get_filter($action_key = null, $action_priority = null, $filter_key = null) {
        global $wp_filter;
        $filters = $wp_filter[$action_key];

        if ( !isset( $filters ) ) return false;
        if ( !isset( $filters[$action_priority] ) ) return false;

        foreach ( $filters[$action_priority] as $key => $value ) {
            if ( strpos($key, $filter_key) !== false ) {
                return $key;
            }
        }

        return null;
    }

}
