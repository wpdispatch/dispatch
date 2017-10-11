<?php

namespace Dispatch\Functions;

class Distance {

    protected $styles;
    protected $scripts;

    public function __construct() {

    }

    public static function between($lat1, $lon1, $lat2, $lon2) {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $km = ( $dist * 60 * 1.1515 ) * 1.609344;

      return $km >= 1 ? round($km, 1) . 'km' : round($km * 1000) . 'm';
    }

}
