<?php

namespace Dispatch\Functions;
use Dispatch\Plugins\ACF as ACF;

class Assets {

    protected $styles;
    protected $scripts;

    public function __construct() {

        $this->styles = array([
            'src' => 'assets/dist/css/vendor.css',
        ], [
            'src' => 'assets/dist/css/app.css',
        ]);

        $this->scripts = array([
            'src' => 'assets/dist/js/vendor.js',
            'in_footer' => true,
        ], [
            'src' => 'assets/dist/js/app.js',
            'in_footer' => true,
        ]);

        add_filter( 'wp_enqueue_scripts', [$this, 'init'] );

    }

    public function init() {

        wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Raleway:100,200,300,400,500,600,700,800,900', array(), '', 'all' );
        wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?key=AIzaSyBPoBNzetDPKH-o39MFOIr7b0AWDQpszOE', array(), '', false );

        foreach( $this->styles as $style ) {

            $style = $this->format_asset( $style, 'style' );

            if ( isset( $style['exists'] ) && $style['exists'] ) {
                wp_enqueue_style( $style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
            }

        }

        foreach( $this->scripts as $script ) {

            $script = $this->format_asset( $script, 'script' );

            if ( isset( $script['exists'] ) && $script['exists'] ) {
                wp_enqueue_script( $script['handle'], $script['src'], $script['deps'], $script['ver'], $script['media'] );
            }

        }

        wp_localize_script( sanitize_key('assets/dist/js/app.min.js'), 'wp_dispatch', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'site_url' => site_url(),
            'theme_url' => get_template_directory_uri()
        ] );

    }

    private function format_asset( $asset, $asset_type = 'style' ) {

        $asset['deps'] = isset( $asset['deps'] ) ? $asset['deps'] : array();
        $asset['media'] = isset( $asset['media'] ) ? $asset['media'] : 'all';
        $asset['in_footer'] = isset( $asset['in_footer'] ) ? $asset['in_footer'] : ( $asset_type == 'style' ? false : true );
        $asset['handle'] = isset( $asset['handle'] ) ? $asset['handle'] : sanitize_key( $asset['src'] );

        if(!preg_match("@\/\/@", $asset['src'])) {
            if(file_exists(get_stylesheet_directory().'/'.$asset['src'])){
                $asset['ver'] = filemtime(get_stylesheet_directory().'/'.$asset['src']);
                $asset['exists'] = true;
            }
            $asset['src'] = get_stylesheet_directory_uri() . '/' . $asset['src'];
        }

        return $asset;

    }

}
