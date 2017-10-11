<?php

namespace Dispatch\Config;

use Timber\Timber as Timber;
use Timber\Site as TimberSite;

class General {

    public function __construct() {

        if( function_exists('acf_add_options_page') ) {

            $options = acf_add_options_page([
                'page_title'    => 'General settings',
                'menu_title'    => 'General settings',
                'redirect'      => false
            ]);

                acf_add_options_sub_page([
                    'page_title'    => 'Contact settings',
                    'menu_title'    => 'Contact settings',
                    'parent_slug'   => $options['menu_slug'],
                ]);

        }

        add_shortcode('year', [$this, 'year']);

        // add_filter( 'embed_oembed_html', [$this, 'alx_embed_html'], 10, 3 );
        // add_filter( 'video_embed_html', [$this, 'alx_embed_html'] ); // Jetpack

    }

    public function alx_embed_html( $html ) {
        return '<div class="video-container">' . $html . '</div>';
    }

    public function year() {
        $year = date('Y');
        return $year;
    }

}
