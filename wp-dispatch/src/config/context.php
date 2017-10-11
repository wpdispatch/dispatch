<?php

namespace Dispatch\Config;

use Dispatch\Config\CustomTaxonomies as CustomTaxonomies;

use Timber as Timber;
use Timber\Helper as TimberHelper;
use Timber\Term as TimberTerm;
use Timber\Post as TimberPost;
use Dispatch\PostTypes\Blog as Blog;

class Context {

    public function __construct() {

        add_filter( 'dispatch_add_to_context', [$this, 'add_to_context'] );

    }

    public function add_to_context( $context ) {

        /**
         * blog
         */
        if ( is_single() ) {
          $context['archive_link'] = get_post_type_archive_link(get_post_type());
        }

        /**
         * contact
         */
        $context['contact_phone'] = get_field('contact_phone', 'options');
        $context['contact_address'] = get_field('contact_address', 'options', false);
        $context['contact_hours'] = get_field('contact_hours', 'options');

        /**
         * footer
         */
        $context['footer_copyright'] = get_field('footer_copyright', 'options');

        TimberHelper::function_wrapper( array( $this, 'assets' ), array( false, false, false ) );
        TimberHelper::function_wrapper( array( $this, 'assets_path' ), array( false, false, false ) );

        return $context;
    }

    public function get_blog_category_by_topic_id($post_id, $topic_id) {
        $blog_category = CustomTaxonomies::get_blog_category_by_topic_id( $post_id, $topic_id );
        if ( $blog_category ) {
            return new TimberTerm( $blog_category );
        } else {
            return null;
        }
    }

    /**
     * Pass in a taxonomy value that is supported by WP's `get_taxonomy`
     * and you will get back the url to the archive view.
     * @param $taxonomy string|int
     * @return string
     */
    public function get_taxonomy_archive_link( $taxonomy ) {
        $tax = get_taxonomy( $taxonomy ) ;
        return get_bloginfo( 'url' ) . '/' . $tax->rewrite['slug'];
    }

    public function assets( $path = false ) {
      $stylesheet_directory_uri = get_stylesheet_directory_uri();
      if ( !$path ) return null;
      return "${stylesheet_directory_uri}/assets/${path}";
    }

    public function assets_path( $path = false ) {
      $get_stylesheet_directory = get_stylesheet_directory();
      if ( !$path ) return null;
      return "${get_stylesheet_directory}/assets/${path}";
    }

}
