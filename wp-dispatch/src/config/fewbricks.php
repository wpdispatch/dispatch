<?php

namespace Dispatch\Config;

use Timber\Helper as TimberHelper;

class FewBricks {

    public function __construct() {

        add_filter( 'dispatch_add_to_context', [$this, 'add_to_context'] );

    }

    public function add_to_context( $context ) {

        TimberHelper::function_wrapper( array( $this, 'fewbricks_brick' ), array( false, false, false ) );
        TimberHelper::function_wrapper( array( $this, 'fewbricks_brick_options' ), array( false, false, false ) );

        return $context;

    }

    public function fewbricks_brick( $brick_type, $brick_key, $layout = null, $post_id = null ) {
      global $post;
      if ( !$brick_type || !$brick_key ) return false;
      if ( $post_id ) {
        $post = get_post( $post_id, OBJECT );
        if ( is_wp_error( $post ) ) return;
        setup_postdata( $post );
      }
      if ( !$layout ) {
          eval('echo (new \fewbricks\bricks\\' . $brick_type . '("' . $brick_key . '"))->get_html();');
      } else {
          eval('echo (new \fewbricks\bricks\\' . $brick_type . '("' . $brick_key . '"))->get_html(["layout"=>"' . $layout . '"],null);');
      }
      wp_reset_postdata();
    }

    public function fewbricks_brick_options( $brick_type, $brick_key ) {
      eval('echo (new \fewbricks\bricks\\' . $brick_type . '("' . $brick_key . '"))->get_brick_html("options");');
    }

}
