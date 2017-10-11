<?php

namespace Dispatch\Functions;

class FilterFunction {

    public $args;
    public $method;

    public function __construct($args) {
      $this->args = $args;
    }

    public function printer( $message ) {
      die($message);
    }

    public function __call( $method, $args ) {
        if (isset($this->$method) && is_callable($this->$method) ) {
            $func = $this->$method;
            array_unshift($args, $this->args);
            return call_user_func_array($func, $args);
        }
    }

}
