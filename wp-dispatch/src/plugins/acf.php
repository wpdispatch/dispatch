<?php

namespace Dispatch\Plugins;

use fewbricks\acf AS fewacf;
use fewbricks\acf\fields AS acf_fields;
use Timber as Timber;
use Timber\Post as TimberPost;
use Dispatch\Functions\FilterFunction as FilterFunction;

class ACF {

    protected $google_api_key = 'AIzaSyBkVdd50_oTDJj42gVrWe7Mn_E40XotCQk';
    protected static $keys = [];

    public function __construct() {

        add_filter('acf/settings/google_api_key', function () {
            return $this->google_api_key;
        });

        add_filter('admin_footer', function(){
          echo '<script type="text/javascript">jQuery("#screen-options-wrap .metabox-prefs").prepend(\'<input type="checkbox" style=”display: none;">\');</script>';
        });

    }

    public static function get_post_id() {
      $post_id = false;

      if ( is_post_type_archive() ) {
        $post_id = 'options';
      } elseif ( is_tax() ) {
        $term = get_queried_object();
        $post_id = "{$term->taxonomy}_{$term->term_id}";
      }

      return $post_id;
    }

    public static function get_term_id( $term ) {
        if ( !$term ) return;

      return "{$term->taxonomy}_{$term->term_id}";
    }

    public static function hide_on_screen( $fg_location = false, $names_of_items_to_hide_on_screen = [] ) {

        if ( !$fg_location ) return;

        $names_of_items_to_hide_on_screen = is_array($names_of_items_to_hide_on_screen) ? $names_of_items_to_hide_on_screen : [];

        ACF::on_screen( $fg_location, [
                'names_of_items_to_hide_on_screen' => $names_of_items_to_hide_on_screen
            ] );

    }

    public static function show_on_screen( $fg_location = false, $names_of_items_to_show_on_screen = [] ) {

        if ( !$fg_location ) return;

        $names_of_items_to_show_on_screen = is_array($names_of_items_to_show_on_screen) ? $names_of_items_to_show_on_screen : [];

        ACF::on_screen( $fg_location, [
                'names_of_items_to_show_on_screen' => $names_of_items_to_show_on_screen
            ] );

    }

    public static function on_screen( $fg_location = false, $args = [] ) {

        if ( !$fg_location ) return;

        $args = is_array($args) ? $args : [];

        $args = array_merge($args, [
            'position' => 'acf_after_title',
            'style' => 'seamless'
        ]);

        $fewbricks_fg = (new fewacf\field_group( '', wp_generate_password(), $fg_location, -1, $args ) );

        $fewbricks_fg->register();

    }

    public static function page( $name, $id, $key ) {

        $field_page = new acf_fields\post_object( $name, "{$id}_id", $key );

        $field_page->set_settings([
            'post_type' => 'page',
            'return_format' => 'id',
            'wrapper' => ['width' => 33]
        ]);

        $filter = new FilterFunction([
            'id' => $id
          ]);

        $filter->method = function( $args, $context ) {
          $id = $args['id'];
          $page_id = get_field("{$id}_id", 'options', false );
          $context[$id] = $page_id ? new TimberPost( $page_id ) : null;
          return $context;
        };

        add_filter( 'dispatch_add_to_context', [$filter, 'method']);

        return $field_page;

    }

    public static function form( $name, $id, $key ) {

        $field_form = new acf_fields\gravity_form( $name, "{$id}", $key );

        $field_form->set_settings([
            'wrapper' => ['width' => 33]
        ]);

        $filter = new FilterFunction([
            'id' => $id
          ]);

        $filter->method = function( $args, $context ) {

          $id = $args['id'];

          $form = get_field("{$id}", 'options' );
          $context[$id] = $form;
          return $context;
        };

        add_filter( 'dispatch_add_to_context', [$filter, 'method']);

        return $field_form;

    }

    public static function file( $name, $id, $key ) {

        $field_form = new acf_fields\file( $name, "{$id}", $key );

        $field_form->set_settings([
            'wrapper' => ['width' => 33],
            'mime_types' => 'pdf'
        ]);

        $filter = new FilterFunction([
            'id' => $id
          ]);

        $filter->method = function( $args, $context ) {

          $id = $args['id'];

          $form = get_field("{$id}", 'options' );
          $context[$id] = $form;
          return $context;
        };

        add_filter( 'dispatch_add_to_context', [$filter, 'method']);

        return $field_form;

    }

    public static function register_key( $key ) {
      $keys = self::$keys;
      if ( in_array( $key, $keys ) ) {
        die("<b>ERROR</b>: trying to register duplicate ACFKey::${key}");
      }
      self::$keys[] = $key;
    }

}
