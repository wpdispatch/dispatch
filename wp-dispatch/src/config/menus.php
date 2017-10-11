<?php

namespace Dispatch\Config;

use Timber\Menu as TimberMenu;

class Menus {

    protected $menus;

    public function __construct() {

        $this->menus = array(
            'main_menu' => __('Main Menu'),
            'mobile_menu' => __('Mobile Menu'),
            'footer_menu' => __('Footer Menu')
        );

        add_filter( 'init', [$this, 'register'] );
        add_filter( 'dispatch_add_to_context', [$this, 'add_to_context'] );

    }

    /**
     * register menus with wordpress
     */
    public function register() {

        register_nav_menus( $this->menus );

    }

    /**
     * add menus to timber context
     * consider the required scope before adding menus to the global context
     */
    public function add_to_context( $context ) {

        foreach( $this->menus as $key => $name ) {
            $context[$key] = new TimberMenu( $key );
        }

        return $context;

    }

}
