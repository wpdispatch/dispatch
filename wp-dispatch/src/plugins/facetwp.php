<?php

namespace Dispatch\Plugins;

class FacetWP {

    public function __construct() {

        // add_action( 'facetwp_template_html', [$this, 'facetwp_template_html'], 10, 2 );
        add_filter( 'facetwp_facets', [$this, 'facetwp_facets'] );
        add_filter( 'facetwp_facet_dropdown_show_counts', '__return_false' );

    }

    public function facetwp_template_html( $output, $class ) {
        $GLOBALS['wp_query'] = $class->query;
        ob_start();
        ?>
        <?php while ( have_posts() ): the_post(); ?>
            <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> dynamic</p>
        <?php endwhile; ?>
        <?php
        return ob_get_clean();
    }

    public function facetwp_facets( $facets ) {


        $facets = [];

        /**
         * Categories
         */
        $facets[] = array(
          'label' => 'Categories',
          'name' => 'categories-blog',
          'type' => 'checkboxes',
          'source' => 'tax/blog-categories',
          'label_any' => 'Any',
          'hierarchical' => 'no',
          'ghosts' => 'no',
          'orderby' => 'raw_value',
          'count' => 3,
          'operator' => 'or'
        );

        /**
         * Infinite Scroll
         */
        $facets[] = array(
          'label' => 'Infinite Scroll',
          'name' => 'infinite-scroll',
          'type' => 'checkboxes',
          'source' => 'infinite-scroll',
          'label_any' => 'Any',
          'hierarchical' => 'no',
          'ghosts' => 'no',
          'orderby' => 'raw_value',
          'count' => 3,
          'operator' => 'or'
        );

        return $facets;
    }

}
