<?php

namespace Dispatch\Config;

class Dashboard {

    /**
     * plate support
     * @link https://github.com/wordplate/plate
     */
    public function __construct() {

        add_theme_support('plate-login', sprintf('%s/%s', get_template_directory_uri(), '/login.png'));

        add_theme_support('plate-menu', [
            'comments',
            'posts',
            // 'dashboard',
            'links',
            // 'media',
        ]);

        add_theme_support('plate-editor', [
            'commentsdiv',
            'commentstatusdiv',
            'linkadvanceddiv',
            'linktargetdiv',
            'linkxfndiv',
            'postcustom',
            'postexcerpt',
            'revisionsdiv',
            'slugdiv',
            'sqpt-meta-tags',
            'trackbacksdiv',
            //'categorydiv',
            //'tagsdiv-post_tag',
        ]);

        add_theme_support('plate-dashboard', [
            'dashboard_activity',
            'dashboard_incoming_links',
            'dashboard_plugins',
            'dashboard_recent_comments',
            'dashboard_primary',
            'dashboard_quick_press',
            'dashboard_recent_drafts',
            'dashboard_secondary',
            'dashboard_right_now',
        ]);

        add_theme_support('plate-toolbar', [
            'comments',
            'wp-logo',
            // 'edit',
            'appearance',
            // 'view',
            // 'new-content',
            'updates',
            'search',
        ]);

        add_theme_support('plate-tabs', [
            'help',
            // 'screen-options',
        ]);

        add_theme_support('plate-permalink', '/%postname%/');
        add_theme_support('plate-footer', '<b>WP Dispatch</b> by <a href="http://www.ioniklabs.com" target="_blank">www.ioniklabs.com</a>.');

    }

}
