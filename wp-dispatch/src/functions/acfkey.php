<?php

namespace Dispatch\Functions;

use Dispatch\Plugins\ACF as ACF;

class ACFKey {

    public static $key;

    public function __construct( $time = false, $date = false, $prefix = false ) {
      if ( !$time && !$date ) return;
      $key = "${date}${time}" . ($prefix ? "${prefix}" : '');
      ACF::register_key($key);
      self::$key = $key;
    }

    public static function get_key($arg_1 = false, $arg_2 = false, $arg_3 = false, $arg_4 = false) {
      $args = [];
      if ( $arg_1 ) $args[] = $arg_1;
      if ( $arg_2 ) $args[] = $arg_2;
      if ( $arg_3 ) $args[] = $arg_3;
      if ( $arg_4 ) $args[] = $arg_4;
      $key = self::$key . join('', $args);
      ACF::register_key($key);
      return $key;
    }

}
