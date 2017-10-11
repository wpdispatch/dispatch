<?php

namespace Dispatch\PostTypes;

class Blog extends Post {

  protected static $this_post_type = 'blog';

  public function __construct() {

    add_action( 'init', [$this, 'register']);

  }

  public function register() {

    $post_type = static::$this_post_type;

    /**
     * CPT
     */
    $labels = array(
        'name' => _x('Blog', DISPATCH_DOMAIN),
        'singular_name' => _x('Post', DISPATCH_DOMAIN),
        'add_new' => _x('Add New', DISPATCH_DOMAIN),
        'add_new_item' => _x('Add New Post', DISPATCH_DOMAIN),
        'edit_item' => _x('Edit Post', DISPATCH_DOMAIN),
        'new_item' => _x('New Post', DISPATCH_DOMAIN),
        'view_item' => _x('View Post', DISPATCH_DOMAIN),
        'search_items' => _x('Search Blog', DISPATCH_DOMAIN),
        'not_found' => _x('No posts found', DISPATCH_DOMAIN),
        'not_found_in_trash' => _x('No posts found in Trash', DISPATCH_DOMAIN),
        'parent_item_colon' => _x('Parent Post:', DISPATCH_DOMAIN),
        'menu_name' => _x('Blog', DISPATCH_DOMAIN),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Create, edit or remove Blog Posts',
        'supports' => array('title', 'author', 'editor', 'excerpt', 'thumbnail', 'revisions'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-welcome-write-blog'
    );
    register_post_type( $post_type, $args );

  }

}
