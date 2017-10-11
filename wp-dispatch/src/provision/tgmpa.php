<?php

namespace Dispatch\Provision;

class TGMpa {

    protected $plugins = array();
    protected $config;

    public function __construct() {

        /**
         * require tgm plugin activation class
         */
        require_once get_template_directory() . '/wp-dispatch/includes/tgm-plugin-activation/class-tgm-plugin-activation.php';
        add_action( 'tgmpa_register', array( $this, 'tgmpa' ) );

    }

    public function tgmpa() {
        $this->set_required_plugins();
        $this->set_recommended_plugins();
        $this->set_config();
        $this->register();
    }

    private function set_required_plugins() {

        /**
         * [Timber](https://wordpress.org/plugins/timber-library/)
         */
        $this->plugins[] = array(
            'name' => 'Timber',
            'slug' => 'timber-library',
            'external_url' => 'https://upstatement.com/timber/',
            'required' => true,
            'force_activation' => true,
            'force_deactivation' => false,
        );

        /**
         * [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/)
         */
        $this->plugins[] = array(
            'name' => 'Advanced Custom Fields Pro',
            'slug' => 'advanced-custom-fields-pro',
            'source' => 'https://github.com/locomotivemtl/advanced-custom-fields-pro/archive/master.zip',
            'external_url' => 'https://www.advancedcustomfields.com/',
            'required' => true,
            'force_activation' => true,
            'force_deactivation' => false,
        );

        /**
         * [Few Bricks](https://github.com/folbert/fewbricks)
         */
        $this->plugins[] = array(
            'name' => 'Few Bricks',
            'slug' => 'fewbricks',
            'source' => 'https://github.com/folbert/fewbricks/archive/master.zip',
            'external_url' => 'https://github.com/folbert/fewbricks',
            'required' => true,
            'force_activation' => true,
            'force_deactivation' => false,
        );

        /**
         * [ACF Hidden Field](https://github.com/folbert/acf-hidden)
         */
        $this->plugins[] = array(
            'name' => 'ACF Hidden Field',
            'slug' => 'acf-fewbricks-hidden',
            'source' => 'https://github.com/folbert/acf-hidden/archive/master.zip',
            'external_url' => 'https://github.com/folbert/acf-hidden',
            'required' => true,
            'force_activation' => true,
            'force_deactivation' => false,
        );

        /**
         * [Plate](https://github.com/wordplate/plate)
         */
        $this->plugins[] = array(
            'name' => 'Plate',
            'slug' => 'plate',
            'source' => 'https://github.com/wordplate/plate/archive/master.zip',
            'external_url' => 'https://github.com/wordplate/plate',
            'required' => true,
            'force_activation' => true,
            'force_deactivation' => false,
        );

    }

    private function set_recommended_plugins() {

        /**
         * [Jetpack](https://jetpack.com/)
         */
        $this->plugins[] = array(
            'name' => 'Jetpack',
            'slug' => 'jetpack',
            'external_url' => 'https://jetpack.com/',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
        );

        /**
         * [Gravity Forms](http://www.gravityforms.com/)
         */
        $this->plugins[] = array(
            'name' => 'Gravity Forms',
            'slug' => 'gravityforms',
            'source' => 'https://github.com/locomotivemtl/gravityforms/archive/master.zip',
            'external_url' => 'http://www.gravityforms.com/',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
        );

        /**
         * [WordPress SEO by Yoast](https://yoast.com/wordpress/plugins/seo/)
         */
        $this->plugins[] = array(
            'name' => 'WordPress SEO by Yoast',
            'slug' => 'wordpress-seo',
            'external_url' => 'https://yoast.com/wordpress/plugins/seo/',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
            'is_callable' => 'wpseo_init',
        );

        /**
         * [Bugherd](https://wordpress.org/plugins/bugherd/)
         */
        $this->plugins[] = array(
            'name' => 'Bugherd',
            'slug' => 'bugherd',
            'external_url' => 'https://wordpress.org/plugins/bugherd/',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
        );

    }

    private function set_config() {

        /**
         * see [documentation](http://tgmpluginactivation.com/configuration/) for additional config parameters
         */
        $this->config = array(
            'id' => 'wp-dispatch',
            'default_path' => '',
            'menu' => 'tgmpa-install-plugins',
            'parent_slug' => 'themes.php',
            'capability' => 'edit_theme_options',
            'has_notices' => true,
            'dismissable' => true,
            'dismiss_msg' => '',
            'is_automatic' => true,
            'message' => $this->install_prompt(),
        );

    }
    private function install_prompt() {
        ob_start();
        /**
         * todo a dashboard message about composer package management here
         */
        ?>
        <?php
        return ob_get_clean();
    }

    /**
     * Register the required plugins for this theme.
     *
     * The variables passed to the `tgmpa()` function should be:
     * - an array of plugin arrays;
     * - optionally a configuration array.
     *
     * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
     */
    private function register() {

        /**
         * make it happen
         */
        tgmpa( $this->plugins, $this->config );

    }

}
