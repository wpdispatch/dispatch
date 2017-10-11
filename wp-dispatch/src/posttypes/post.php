<?php

namespace Dispatch\PostTypes;

use Timber\Timber;
use Timber\Post as TimberPost;

class Post extends TimberPost {

    protected static $this_post_type = 'post';

    public static function get($posts_per_page = -1) {

        $args = ['posts_per_page' => $posts_per_page];

        return static::query($args);
    }

    public static function query($args = []) {

        $args = is_array($args) ? $args : [];

        $args = array_merge($args, [
            'post_type' => static::$this_post_type
        ]);

        if (!isset($args['post_status'])) {
            $args['post_status'] = 'publish';
        }

        return static::posts($args);
    }

    public static function posts( $args = null ) {
        return Timber::get_posts($args);
    }

    public static function this_post_type() {
        return static::$this_post_type;
    }
}
