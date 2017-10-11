<?php

namespace Dispatch\Taxonomies;

use Dispatch\PostTypes\Blog as Blog;

class BlogCategories extends Term {

  protected static $this_taxonomy = 'blog-categories';

  public function __construct() {

    add_action( 'init', [$this, 'register']);

  }

  public function register() {

    $post_type = Blog::this_post_type();
    $taxonomy = static::$this_taxonomy;

    $labels = array(
      'name' => _x( 'Categories', 'taxonomy general name', DISPATCH_DOMAIN ),
      'singular_name' => _x( 'Category', 'taxonomy singular name', DISPATCH_DOMAIN ),
      'search_items' => __( 'Search Categories', DISPATCH_DOMAIN ),
      'all_items' => __( 'All Categories', DISPATCH_DOMAIN ),
      'parent_item' => __( 'Parent Category', DISPATCH_DOMAIN ),
      'parent_item_colon' => __( 'Parent Category:', DISPATCH_DOMAIN ),
      'edit_item' => __( 'Edit Category', DISPATCH_DOMAIN ),
      'update_item' => __( 'Update Category', DISPATCH_DOMAIN ),
      'add_new_item' => __( 'Add New Category', DISPATCH_DOMAIN ),
      'new_item_name' => __( 'New Category Name', DISPATCH_DOMAIN ),
      'menu_name' => __( 'Categories', DISPATCH_DOMAIN ),
    );

    $args = array(
      'hierarchical' => true,
      'public' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => false,
      'query_var' => true,
      'show_in_nav_menus' => true,
      // 'rewrite' => array(
      //     'slug' => "{$post_type}/$taxonomy"
      //   )
    );

    register_taxonomy( $taxonomy, array( $post_type ), $args );

  }

}
