<?php

namespace Dispatch\Config;

use Timber\Timber as Timber;
use Timber\Site as TimberSite;
use Twig_Filter_Function;
use Twig_SimpleFunction;

class Site extends TimberSite {

    public function __construct() {

        // Timber::$cache = true;

        Timber::$dirname = [
            'views',
            'fewbricks/brick-layouts',
            'fewbricks/bricks',
        ];

        add_filter( 'get_twig', [$this, 'add_to_twig'] );
        add_filter( 'timber_context', [$this, 'add_to_context'] );

        parent::__construct();

    }

    /**
     * add functions to twig
     *
     * functions added here will be loaded globally
     * consider using the 'dispatch_add_to_twig' filter
     * to conditionally add methods when needed
     */
    public function add_to_twig( $twig ) {

        $twig->addFilter('gallery', new Twig_Filter_Function([$this, 'gallery']));
        $twig->addFilter('background_image', new Twig_Filter_Function([$this, 'css_background_image']));
        $twig->addFilter('google_directions_url', new Twig_Filter_Function([$this, 'google_directions_url']));

        $render_icon = new Twig_SimpleFunction('icon', [$this, 'render_icon']);
        $twig->addFunction($render_icon);

        return apply_filters( 'dispatch_add_to_twig', $twig );

    }

    public function gallery($gallery = []) {
        if (!$gallery || empty($gallery) ) return null;
        $return = array();
        foreach ($gallery as $value) {
            $return[] = $value['ID'];
        }
        ob_start();
        echo do_shortcode('[gallery link="file" size="gallery" ids="' . join($return, ',') . '"]');
        return ob_get_clean();
    }

    public function css_background_image($text) {
        if ( empty( $text ) ) return '';
        return "background-image: url('$text');";
    }

    public function google_directions_url($address) {
      $address_encoded = urlencode( $address );
      return "https://www.google.com/maps/dir/Current+Location/{$address_encoded}";
    }

    public function render_icon($icon, $custom_classes = array()) {
        $custom_classes = is_array( $custom_classes ) ? $custom_classes : array( $custom_classes );
        $template_directory = get_template_directory();
        $icon_path = "{$template_directory}/assets/dist/icons/{$icon}.svg";
        if ( !file_exists($icon_path) ) return;
        $default_classes = array(
          'icon', "icon-{$icon}"
        );
        $classes = array_merge($default_classes, $custom_classes);
        $html = file_get_contents( $icon_path );
        $html_minus_class = preg_replace( '/(<svg[^>]*?)(class\s*\=\s*\"[^\"]*?\")([^>]*?>)/', '$1$3', $html);
        $svg = str_replace('<svg ','<svg class="' . join( $classes, ' ' ) . '" ', $html_minus_class );
        return $svg;
    }

    /**
     * add functions to timber context
     *
     * variables and methods added here will be loaded globally
     * consider using the 'dispatch_add_to_context' filter
     * to conditionally add methods when needed
     */
    public function add_to_context( $context ) {

        return apply_filters( 'dispatch_add_to_context', $context );

    }

}
