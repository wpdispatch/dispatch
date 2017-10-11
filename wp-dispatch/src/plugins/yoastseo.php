<?php

namespace Dispatch\Plugins;

use WPSEO_Primary_Term;
use Timber\Helper as TimberHelper;

class YoastSEO {

    public function __construct() {
        add_filter( 'dispatch_add_to_context', [$this, 'add_to_context'] );
    }

    public function add_to_context( $context ) {

        $context['get_primary_term'] = TimberHelper::function_wrapper( [$this, 'timber_get_primary_term'], array( null, false) );

        return $context;
    }

    public static function get_primary_term( $taxonomy, $post_id = false ) {
        $post_id = $post_id ?: get_the_ID();
        $taxonomy_terms = wp_get_post_terms($post_id, $taxonomy );
        if ( count( $taxonomy_terms ) > 0 ) {
            if ( class_exists('WPSEO_Primary_Term') ) {
                $wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
                $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
                $term = get_term( $wpseo_primary_term );
                if (is_wp_error($term)) {
                    return $taxonomy_terms[0];
                } else {
                    return $term;
                }
            } else {
                return $taxonomy_terms[0];
            }
        }
        return false;
    }

    public function timber_get_primary_term($term, $post) {
        if ( empty( $term ) ) return array();
        return $this->get_primary_term( $term, $post ? $post->ID : false );
    }

}
