<?php

namespace Dispatch\Config;
use Dispatch\Functions\Filters as Filters;

class Media {

    protected $image_sizes;

    public function __construct() {

        $this->image_sizes = array();

        add_filter( 'init', [$this, 'register'] );

        add_filter( 'the_content', [$this, 'image_embed_html_markup'], 99);
        add_filter( 'the_content', [$this, 'blockquote_embed_html_markup'], 100);
        add_filter( 'img_caption_shortcode', [$this, 'figure_embed_html_markup'], 10, 3 );
        add_filter( 'post_gallery', [$this, 'gallery_embed_html_markup'], 10, 3 );
        add_filter( 'wp_video_shortcode_override', [$this, 'video_embed_html_markup'], 10, 3 );

        add_filter( 'use_default_gallery_style', '__return_false' );

        add_filter('image_resize_dimensions', [$this, 'image_resize_dimensions'], 10, 6);
        add_filter('intermediate_image_sizes_advanced', [$this, 'intermediate_image_sizes_advanced']);
    }

    public function register() {

        foreach( $this->image_sizes as $image_size ) {
            $this->register_image_size( $image_size );

            // $image_size_x2 = $this->generate_image_size_variation( $image_size, '@2x', 2 );
            // $this->register_image_size( $image_size_x2 );
        }
    }

    public function generate_image_size_variation( $image_size = false, $suffix = false, $multiplier = false ) {
        if ( !$image_size || !$suffix || !$multiplier ) return $image_size;

        $image_size[0] = "{$image_size[0]}{$suffix}";
        $image_size[1] = $image_size[1] * $multiplier;
        $image_size[2] = $image_size[2] * $multiplier;

        return $image_size;
    }

    function intermediate_image_sizes_advanced( $sizes = array() ) {
        unset( $sizes['thumbnail']);
        unset( $sizes['medium']);
        unset( $sizes['medium_large']);
        unset( $sizes['large']);

        return $sizes;
    }

    public function register_image_size( $image_size ) {
        add_image_size( $image_size[0], $image_size[1], $image_size[2], $image_size[3] );
        // if ( function_exists('fly_add_image_size') ) {
        //     fly_add_image_size( $image_size[0], $image_size[1], $image_size[2], $image_size[3] );
        // } else {
        //     add_image_size( $image_size[0], $image_size[1], $image_size[2], $image_size[3] );
        // }
    }

    public function image_embed_html_markup($content) {
       $content = preg_replace_callback(
           "/<(div|p)([^>]+)?>(<img[^>]+>)(<div[^>]*>.*?<\/div>)?<\/(div|p)>/",
           function ($match) {
               return '<div class="content-block-inline entry-media"><div class="entry-media-item"><div class="entry-image">' . $match[3] . $match[4] . '</div></div></div>';
           },
           $content
       );
       return $content;
    }

    public function blockquote_embed_html_markup($content) {
       $content = preg_replace_callback(
           "~<blockquote>([\s\S]+?)</blockquote>~",
           function ($match) {
               return '<div class="entry-media"><div class="entry-media-item"><div class="entry-blockquote"><blockquote>' . $match[1] . '</blockquote></div></div></div>';
              // $data = array(
              //   'text' => $match[1]
              // );
              // return \Timber::compile('blog/blockquote.twig', $data);
           },
           $content
       );
       return $content;
    }

    public function figure_embed_html_markup( $width, $atts, $content ) {
        $key = Filters::get_filter('img_caption_shortcode', 10, 'figure_embed_html_markup');

        remove_filter( 'img_caption_shortcode', $key, 10 );

        $output = img_caption_shortcode($atts, $content);

        add_filter( 'img_caption_shortcode', [$this, 'figure_embed_html_markup'], 10, 3 );

        // Change the output
        $output = '<div class="entry-media"><div class="entry-media-item"><div class="entry-figure">' . $output . '</div></div></div>';

        return $output;
    }

    public function gallery_embed_html_markup( $output = '', $attr, $instance ) {
        $key = Filters::get_filter('post_gallery', 10, 'gallery_embed_html_markup');

        remove_filter( 'post_gallery', $key, 10 );

        $output = gallery_shortcode($attr);

        add_filter( 'post_gallery', [$this, 'gallery_embed_html_markup'], 10, 3 );

        // Change the output
        $output = '<div class="entry-media"><div class="entry-media-item"><div class="entry-gallery">' . $output . '</div></div></div>';

        return $output;
    }

    public function video_embed_html_markup( $output = '', $attr, $instance ) {
        $key = Filters::get_filter('wp_video_shortcode_override', 10, 'video_embed_html_markup');

        remove_filter( 'wp_video_shortcode_override', $key, 10 );

        $output = wp_video_shortcode($attr);

        add_filter( 'wp_video_shortcode_override', [$this, 'video_embed_html_markup'], 10, 3 );

        // Change the output
        $output = '<div class="entry-media"><div class="entry-media-item"><div class="entry-video">' . $output . '</div></div></div>';

        return $output;
    }

    // Enables upscaling of thumbnails for small media attachments
    // @link https://wordpress.org/plugins/thumbnail-upscale/
    public function image_resize_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop) {
      if(!$crop)
        return null; // let the wordpress default function handle this

      $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

      $crop_w = round($new_w / $size_ratio);
      $crop_h = round($new_h / $size_ratio);

      $s_x = floor( ($orig_w - $crop_w) / 2 );
      $s_y = floor( ($orig_h - $crop_h) / 2 );

      if(is_array($crop)) {

        //Handles left, right and center (no change)
        if($crop[ 0 ] === 'left') {
          $s_x = 0;
        } else if($crop[ 0 ] === 'right') {
          $s_x = $orig_w - $crop_w;
        }

        //Handles top, bottom and center (no change)
        if($crop[ 1 ] === 'top') {
          $s_y = 0;
        } else if($crop[ 1 ] === 'bottom') {
          $s_y = $orig_h - $crop_h;
        }
      }

      return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
    }

}
