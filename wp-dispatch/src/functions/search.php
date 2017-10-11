<?php

namespace Dispatch\Functions;

use WP_Query;
use Timber;
use Dispatch\PostTypes\Blog as Blog;

class Search {

    public function __construct() {

        add_action('wp_ajax_search', [$this, 'search']);
        add_action('wp_ajax_nopriv_search', [$this, 'search']);

    }

    public function search() {

        if (!isset($_POST['s'])) {
            throw new Exception("Query parameter 's' is required for searching");
        }

        $query_search = new WP_Query();
        $query_search->query_vars['s'] = $_POST['s'];
        $query_search->query_vars['post_type'] = Blog::this_post_type();
        $query_search->query_vars['posts_per_page'] = -1;
        relevanssi_do_query($query_search);

        $data = array(
            'total' => count($query_website->posts) + count($query_search->posts),
            'results' => $query_search->posts
        );

        ob_start();
            echo \Timber::compile('components/common/search-results.twig', $data);
        $html = ob_get_clean();

        wp_send_json([
            'html' => $html
        ]);

    }

}
