<?php

namespace Dispatch\Config;
use Dispatch\Functions\Filters as Filters;

class Theme {

    public function __construct() {

        add_filter( 'init', [$this, 'support'] );
        add_filter( 'init', [$this, 'housekeeping'] );

        add_filter( 'mce_buttons_2', [$this, 'mce_buttons_2'] );
        add_filter( 'tiny_mce_before_init', [$this, 'mce_before_init_insert_formats'] );

    }

    public function support() {

        add_theme_support( 'post-formats' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array('gallery', 'caption') );
        add_theme_support( 'menus' );
        add_theme_support( 'title-tag' );

    }

    public function housekeeping() {

        remove_action('wp_head', 'rsd_link'); // Removes the Really Simple Discovery link
        remove_action('wp_head', 'feed_links', 2); // Removes the RSS feeds remember to add post feed maunally (if required) to header.php
        remove_action('wp_head', 'wp_generator'); // Removes the WordPress version
        remove_action('wp_head', 'index_rel_link'); // Removes the index page link
        remove_action('wp_head', 'feed_links_extra', 3); // Removes all other RSS links
        remove_action('wp_head', 'wlwmanifest_link'); // Removes the Windows Live Writer link
        remove_action('wp_head', 'start_post_rel_link', 10, 0); // Removes the random post link
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); // Removes the shortlink
        remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Removes the parent post link
        remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Removes the next and previous post links
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); // Post relational links

        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

        // add_filter('show_admin_bar', '__return_false');

        remove_action('set_comment_cookies', 'wp_set_comment_cookies');

        add_action( 'wp_enqueue_scripts', function(){
            if (is_admin()) return;
            // wp_deregister_script( 'jquery' );
            wp_enqueue_script('jquery');
        });

    }

    // Callback function to insert 'styleselect' into the $buttons array
    public function mce_buttons_2( $buttons ) {
      array_unshift( $buttons, 'styleselect' );
      return $buttons;
    }

    // Callback function to filter the MCE settings
    public function mce_before_init_insert_formats( $init_array ) {
      // Define the style_formats array
      $style_formats = array(
          // Each array child is a format with it's own settings
          array(
              'title' => 'Lead',
              'selector' => 'p',
              'classes' => 'lead'
          )
      );
      // Insert the array, JSON ENCODED, into 'style_formats'
      $init_array['style_formats'] = json_encode( $style_formats );
      return $init_array;
    }

}
