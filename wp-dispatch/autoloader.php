<?php

/**
 * @class Autoloader
 */

class Autoloader {

    // project namespace
    protected $namespace = 'Dispatch\\';
    protected $namespace_length;

    // base directory to autoload classes
    protected $base_dir = __DIR__ . '/src/';

    public function __construct() {
        $this->housekeeping();
        spl_autoload_register( array( $this, 'load' ) );
    }

    /**
     * keep our construct clean
     * @return void
     */
    private function housekeeping() {
        $this->namespace_length = strlen( $this->namespace );
    }

    /**
     * @param string $class The class name to autoload
     * @return void
     */
    private function load( $class ) {

        // check if valid namespace
        if ( !$this->is_namespace( $class ) ) {
            return;
        }

        $class_short = substr( $class, $this->namespace_length );

        $file_path = $this->base_dir . strtolower( str_replace( '\\', '/', $class_short ) ) . '.php';

        if ( file_exists( $file_path ) ) {
            require( $file_path );
        } else {
            die( __( "$class could not be loaded from $file_path" ) );
        }

    }

    /**
     * check if the class name uses the correct namespace
     *
     * @param string $class The class name to autoload
     * @return boolean true/false
     */
    private function is_namespace($class) {
        $namespace_length = strlen( $class );
        return strncmp( $this->namespace, $class, $this->namespace_length ) === 0;
    }

}

$autoloader = new Autoloader();

?>
