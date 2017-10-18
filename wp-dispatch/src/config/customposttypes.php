<?php

namespace Dispatch\Config;

use Dispatch\PostTypes\Blog as Blog;

class CustomPostTypes {

  protected $disable_single;

  public function __construct() {

    new Blog;

    $this->disable_single = array(
      // Blog::this_post_type(),
    );

    add_action( 'init', [$this, 'ctpacf_options_pages'], 99 );
    add_action( 'template_redirect', [$this, 'template_redirect'] );

  }

  public function ctpacf_options_pages() {

    if( function_exists('acf_add_options_page') ) {

      $ctpacf_post_types = get_post_types( array(
          '_builtin' => false,
          'has_archive' => true
      ) );

      foreach ( $ctpacf_post_types as $cpt ) {

        if( post_type_exists( $cpt ) ) {

          $cptname = get_post_type_object( $cpt )->labels->name;
          $cpt_post_id = 'cpt_' . $cpt;

          if( defined('ICL_LANGUAGE_CODE') ) {
            $cpt_post_id = $cpt_post_id . '_' . ICL_LANGUAGE_CODE;
          }

          $cpt_acf_page = array(
            'page_title' => ucfirst( $cptname ) . ' Archive',
            'menu_title' => ucfirst( $cptname ) . ' Archive',
            'parent_slug' => 'edit.php?post_type=' . $cpt,
            // 'menu_slug' => $cpt . '-archive',
            'capability' => 'edit_posts',
            // 'post_id' => $cpt_post_id,
            'position' => false,
            'icon_url' => false,
            'redirect' => false
          );

          acf_add_options_page( $cpt_acf_page );

        }

      }

    }

  }

  public function template_redirect() {
    if ( !isset($this->disable_single) || empty($this->disable_single) ) return;
    if ( is_singular($this->disable_single) ) {
      wp_redirect( home_url(), 302 );
      exit;
    }
  }

}
