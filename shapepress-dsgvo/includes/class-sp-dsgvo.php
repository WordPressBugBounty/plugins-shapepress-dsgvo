<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
class SPDSGVO
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      sp_dsgvo_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Singleton
     *
     * @since    1.0.0
     * @access   protected
     * @var      object $instance The singleton instance
     */
    protected static $instance = null;

    protected function __construct()
    {
        $this->version = sp_dsgvo_VERSION;
        $this->loadDependencies();

        if (is_admin()) {
            $this->defineAdminHooks();
        } else {
            $this->definePublicHooks();
        }
    }

    protected function __clone()
    {
    }

    public static function instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    private function loadDependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sp-dsgvo-loader.php';
        $this->loader = new SPDSGVOLoader();

        if (file_exists(dirname(dirname(__FILE__)) . '/vendor/autoload.php')) {
            require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';
        }

        /*
         * moved to subject-access-request.php -> just load it only if required
         *
        if(!class_exists('TCPDF')){
            require_once SPDSGVO::pluginDir('includes/lib/tcpdf/dsgdf.php');
            require_once SPDSGVO::pluginDir('includes/class-sp-dsgvo-pdf.php');
        }
        */

        $load = array(
            //======================================================================
            // Libraries
            //======================================================================
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-constants.php'),
            SPDSGVO::pluginDir('includes/helpers.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-cache-manager.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-migrator.php'),
            SPDSGVO::pluginDir('admin/class-sp-dsgvo-admin.php'),
            SPDSGVO::pluginDir('admin/class-sp-dsgvo-admin-tab.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-ajax-action.php'),
            SPDSGVO::pluginDir('admin/class-sp-dsgvo-admin-action.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-settings.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-settings-polylang.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-mail.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-data-collecter.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-log.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-embedding-api-base.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-embeddings-manager.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-integration-api-base.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-integration.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-javascript.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-slim-model.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-cron.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-language-tools.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-cookie-category-api.php'),
            SPDSGVO::pluginDir('includes/class-sp-dsgvo-upgrade-notice-tools.php'),
            SPDSGVO::pluginDir('public/class-sp-dsgvo-public.php'),


            //======================================================================
            // Models
            //======================================================================
            SPDSGVO::pluginDir('includes/models/unsubscriber.php'),
            SPDSGVO::pluginDir('includes/models/subject-access-request.php'),


            //======================================================================
            // Cron
            //======================================================================
            SPDSGVO::pluginDir('includes/cron/do-subject-access-request.php'),
            SPDSGVO::pluginDir('includes/cron/do-delete-data-request.php'),
            SPDSGVO::pluginDir('includes/cron/do-validate-license.php'),
            SPDSGVO::pluginDir('includes/cron/do-check-privacy-policy-texts.php'),

            //======================================================================
            // Actions
            //======================================================================
            SPDSGVO::pluginDir('public/actions/unsubscribe.php'),
            SPDSGVO::pluginDir('public/actions/popup-accept.php'),
            SPDSGVO::pluginDir('public/actions/notice-action.php'),
            SPDSGVO::pluginDir('public/actions/legal-web-text-action.php'),
            SPDSGVO::pluginDir('public/actions/update-privacy-policy-texts-action.php'),


            //======================================================================
            // Shortcodes
            //======================================================================
            // SAR
            SPDSGVO::pluginDir('public/shortcodes/subject-access-request/download-subject-access-request.php'),
            SPDSGVO::pluginDir('public/shortcodes/subject-access-request/subject-access-request-action.php'),
            SPDSGVO::pluginDir('public/shortcodes/subject-access-request/subject-access-request.php'),

            // Super Unsubscribe
            SPDSGVO::pluginDir('public/shortcodes/super-unsubscribe/unsubscribe-form.php'),
            SPDSGVO::pluginDir('public/shortcodes/super-unsubscribe/unsubscribe-form-action.php'),
            SPDSGVO::pluginDir('public/shortcodes/super-unsubscribe/unsubscribe-confirm-action.php'),


            SPDSGVO::pluginDir('public/shortcodes/privacy-policy.php'),
            SPDSGVO::pluginDir('public/shortcodes/imprint.php'),
            SPDSGVO::pluginDir('public/shortcodes/privacy-policy-link-shortcode.php'),
            SPDSGVO::pluginDir('public/shortcodes/cookie-popup-shortcode.php'),
            SPDSGVO::pluginDir('public/shortcodes/content-block-shortcode.php'),

            //======================================================================
            // Default Integrations
            //======================================================================
            SPDSGVO::pluginDir('includes/integrations/mailchimp/MailchimpIntegration.php'),
            SPDSGVO::pluginDir('includes/integrations/woocommerce/WoocommerceIntegration.php'),
            SPDSGVO::pluginDir('includes/integrations/cf7/Cf7Integration.php'),
            SPDSGVO::pluginDir('includes/integrations/bbpress/BbpressIntegration.php'),
            SPDSGVO::pluginDir('includes/integrations/buddypress/BuddyPressIntegration.php'),

            // tag manager
            SPDSGVO::pluginDir('includes/integrations/tagmanager/googletagmanager/class-sp-dsgvo-google-tagmanager-api.php'),
            SPDSGVO::pluginDir('includes/integrations/tagmanager/googletagmanager/class-sp-dsgvo-google-tagmanager-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/tagmanager/matomotagmanager/class-sp-dsgvo-matomo-tagmanager-api.php'),
            SPDSGVO::pluginDir('includes/integrations/tagmanager/matomotagmanager/class-sp-dsgvo-matomo-tagmanager-integration.php'),

            // statistics
            SPDSGVO::pluginDir('includes/integrations/statistics/googleanalytics/class-sp-dsgvo-google-analytics-api.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/googleanalytics/class-sp-dsgvo-google-analytics-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/matomo/class-sp-dsgvo-matomo-api.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/matomo/class-sp-dsgvo-matomo-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/wpstatistics/class-sp-dsgvo-wpstatistics-api.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/wpstatistics/class-sp-dsgvo-wpstatistics-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/clicky/class-sp-dsgvo-clicky-api.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/clicky/class-sp-dsgvo-clicky-integration.php'),

            SPDSGVO::pluginDir('includes/integrations/statistics/piwik/class-sp-dsgvo-piwik-api.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/piwik/class-sp-dsgvo-piwik-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/etracker/class-sp-dsgvo-etracker-api.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/etracker/class-sp-dsgvo-etracker-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/hotjar/class-sp-dsgvo-hotjar-api.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/hotjar/class-sp-dsgvo-hotjar-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/mautic/class-sp-dsgvo-mautic-api.php'),
            SPDSGVO::pluginDir('includes/integrations/statistics/mautic/class-sp-dsgvo-mautic-integration.php'),

            // targeting
            SPDSGVO::pluginDir('includes/integrations/targeting/fbpixel/class-sp-dsgvo-fb-pixel-api.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/fbpixel/class-sp-dsgvo-fb-pixel-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/criteo/class-sp-dsgvo-criteo-api.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/criteo/class-sp-dsgvo-criteo-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/linkedinpixel/class-sp-dsgvo-linkedin-pixel-api.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/linkedinpixel/class-sp-dsgvo-linkedin-pixel-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/bingadsuet/class-sp-dsgvo-bing-ads-uet-api.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/bingadsuet/class-sp-dsgvo-bing-ads-uet-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/gadsense/class-sp-dsgvo-gadsense-api.php'),
            SPDSGVO::pluginDir('includes/integrations/targeting/gadsense/class-sp-dsgvo-gadsense-integration.php'),

            // embeddings
            SPDSGVO::pluginDir('includes/integrations/embeddings/youtube/class-sp-dsgvo-youtube-api.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/youtube/class-sp-dsgvo-youtube-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/gmaps/class-sp-dsgvo-gmaps-api.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/gmaps/class-sp-dsgvo-gmaps-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/twitter/class-sp-dsgvo-twitter-api.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/twitter/class-sp-dsgvo-twitter-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/vimeo/class-sp-dsgvo-vimeo-api.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/vimeo/class-sp-dsgvo-vimeo-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/openstreetmap/class-sp-dsgvo-openstreetmap-api.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/openstreetmap/class-sp-dsgvo-openstreetmap-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/instagram/class-sp-dsgvo-instagram-api.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/instagram/class-sp-dsgvo-instagram-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/facebook-feed/class-sp-dsgvo-facebook-feed-api.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/facebook-feed/class-sp-dsgvo-facebook-feed-integration.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/soundcloud/class-sp-dsgvo-soundcloud-api.php'),
            SPDSGVO::pluginDir('includes/integrations/embeddings/soundcloud/class-sp-dsgvo-soundcloud-integration.php'),


        );
        //======================================================================
        // Admin Pages
        //======================================================================

        if (is_admin()) {

            array_push($load,
                SPDSGVO::pluginDir('admin/tabs/v3/info/class-sp-dsgvo-info-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/webinars/class-sp-dsgvo-webinars-tab.php'),

                SPDSGVO::pluginDir('admin/tabs/setup/class-sp-dsgvo-create-page-action.php'),

                // Subject Access Request
                SPDSGVO::pluginDir('admin/tabs/v3/subject-access-request/class-sp-dsgvo-subject-access-request-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/subject-access-request/class-sp-dsgvo-subject-access-request-action.php'),

                // Super Unsubscribe
                SPDSGVO::pluginDir('admin/tabs/v3/super-unsubscribe/class-sp-dsgvo-super-unsubscribe-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/super-unsubscribe/class-sp-dsgvo-super-unsubscribe-action.php'),
                /* i592995 */
                SPDSGVO::pluginDir('admin/tabs/v3/super-unsubscribe/class-sp-dsgvo-dismiss-unsubscribe-action.php'),
                /* i592995 */

                // Common Settings
                SPDSGVO::pluginDir('admin/tabs/v3/common-settings/class-sp-dsgvo-common-settings-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/common-settings/class-sp-dsgvo-common-settings-action.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/common-settings/class-sp-dsgvo-common-settings-activate-action.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/common-settings/class-sp-dsgvo-common-settings-validate-license-action.php'),

                SPDSGVO::pluginDir('admin/tabs/v3/common-settings/class-sp-dsgvo-privacy-policy-action.php'),

                // Cookie Notice
                SPDSGVO::pluginDir('admin/tabs/v3/popup-notice/class-sp-dsgvo-cookie-notice-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/popup-notice/class-sp-dsgvo-cookie-notice-action.php'),

                // Operator
                SPDSGVO::pluginDir('admin/tabs/v3/operator/class-sp-dsgvo-operator-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/operator/class-sp-dsgvo-operator-action.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/operator/class-sp-dsgvo-imprint-action.php'),

                // Page Basics
                SPDSGVO::pluginDir('admin/tabs/v3/page-basics/class-sp-dsgvo-page-basics-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/page-basics/class-sp-dsgvo-page-basics-action.php'),

                // Tagmanager Integrations
                SPDSGVO::pluginDir('admin/tabs/v3/tagmanager/class-sp-dsgvo-tagmanager-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/tagmanager/class-sp-dsgvo-tagmanager-action.php'),

                // Statistic Integrations
                SPDSGVO::pluginDir('admin/tabs/v3/stats/class-sp-dsgvo-stats-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/stats/class-sp-dsgvo-stats-action.php'),

                // Targeting Integrations
                SPDSGVO::pluginDir('admin/tabs/v3/targeting/class-sp-dsgvo-targeting-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/targeting/class-sp-dsgvo-targeting-action.php'),

                // Embedding Integrations
                SPDSGVO::pluginDir('admin/tabs/v3/embeddings/class-sp-dsgvo-embeddings-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/v3/embeddings/class-sp-dsgvo-embeddings-action.php'),

                // Integrations
                SPDSGVO::pluginDir('admin/tabs/integrations/class-sp-dsgvo-integrations-tab.php'),
                SPDSGVO::pluginDir('admin/tabs/integrations/class-sp-dsgvo-integrations-action.php')
            );
            //array_push($load, $loadAdmin);
        }


        // Gravity Forms
        if (class_exists('GFAPI')) {
            $load[] = SPDSGVO::pluginDir('admin/tabs/gravity-forms/class-sp-dsgvo-gravity-forms-tab.php');
            $load[] = SPDSGVO::pluginDir('admin/tabs/gravity-forms/class-sp-dsgvo-gravity-forms-action.php');
        }

        foreach ($load as $path) {
            require_once $path;
        }

        do_action('sp_dsgvo_booted');
    }

    public static function version()
    {
        return (new self)->version;
    }

    public static function isTesting()
    {
        return (defined('sp_dsgvo_TESTING') && sp_dsgvo_TESTING === '1');
    }


    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function defineAdminHooks()
    {
        $admin = new SPDSGVOAdmin();
        $this->loader->add_action('init', $admin, 'adminInit');
        $this->loader->add_action('admin_enqueue_scripts', $admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $admin, 'enqueue_scripts');

        $this->loader->add_action('admin_menu', $admin, 'menuItem');

        // $this->loader->add_filter('manage_users_columns', 		$admin, 'addExplicitPermissionColumn');
        // $this->loader->add_filter('manage_users_custom_column', $admin, 'explicitPermissionColumnCallback', 1, 3);

        //$this->loader->add_action('show_user_profile', 			$admin, 'showCustomProfileFields');
        //$this->loader->add_action('edit_user_profile', 			$admin, 'showCustomProfileFields');

        $this->loader->add_action('admin_enqueue_scripts', $admin, 'enqueueColorPicker');
        $this->loader->add_action('display_post_states', $admin, 'addCustomPostStates', 1, 3);

        // gravity forms action
        $this->loader->add_action('gform_after_submission', $admin, 'gf_after_submisison_cleanse', 10, 2);
        $this->loader->add_action('admin_notices', $admin, 'dsvgvo_admin_notices');

        // upgrade notice
        //$this->loader->add_action('in_plugin_update_message-shapepress-dsgvo/sp-dsgvo.php', $admin, 'showUpgradeMessage', 10, 2);
        // do migration logic
        //$this->loader->add_action('upgrader_process_complete', SPDSGVOMigrator::getInstance(), 'checkForMigrations', 10, 2);
        $this->loader->add_action('plugins_loaded', SPDSGVOMigrator::getInstance(), 'checkForMigrations');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function definePublicHooks()
    {
        $public = new SPDSGVOPublic();
        $this->loader->add_action('wp_enqueue_scripts', $public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $public, 'enqueue_scripts');
        $this->loader->add_action('wp_enqueue_scripts', SPDSGVOJavascript::getInstance(), 'register');
        $this->loader->add_action('upload_mimes', $public, 'allowJSON');
        //$this->loader->add_action('user_register', 				$public, 'newUserRegistered', 10, 1);
        //$this->loader->add_action('wp', 						$public, 'forcePermisson');
        $this->loader->add_action('init', $public, 'publicInit');
        $this->loader->add_action('sp_dsgvo_collect_user_data', $public, 'collectUserData');
        $this->loader->add_action('wp_print_footer_scripts', $public, 'wp_print_footer_scripts');
        $this->loader->add_action('wp_footer', $public, 'writeFooterScripts', 1000);
        $this->loader->add_action('wp_head', $public, 'writeHeaderScripts');
        $this->loader->add_action('wp_body_open', $public, 'writeBodyStartScripts');

        $this->loader->add_filter('the_content', SPDSGVOEmbeddingsManager::getInstance(), 'findAndProcessIframes', 50, 1);
        $this->loader->add_filter('widget_text_content', SPDSGVOEmbeddingsManager::getInstance(), 'findAndProcessIframes', 50, 1);
        $this->loader->add_filter('widget_custom_html_content', SPDSGVOEmbeddingsManager::getInstance(), 'findAndProcessIframes', 50, 1);
        $this->loader->add_filter('embed_oembed_html', SPDSGVOEmbeddingsManager::getInstance(), 'findAndProcessOembeds', 50, 2);

        $this->loader->add_action('rest_api_init', $public, 'registerTextActionEndpoint', 1);
        //$this->loader->add_action('rest_api_init', new SPDSGVOLegalWebTextAction(), 'run', 10);


        /**
         * If activated by user, block google-fonts if cookies are not accepted
         */
        /*
        if(hasUserGivenPermissionFor('google-fonts')) {
            SPDSGVOPublic::blockGoogleFonts();
        }
        */

        $this->loader->add_action('woocommerce_review_order_before_submit', $public, 'wooAddCustomFields', 20);

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_sp_dsgvo()
    {
        return sp_dsgvo_NAME;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    sp_dsgvo_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }

    public function testPermissions()
    {
        return wp_upload_bits('sp-dsgvo-test-file.txt', NULL, time())['error'] === FALSE;
    }


    //======================================================================
    // Helpers
    //======================================================================
    public static function adminURL($params = NULL)
    {
        if (is_null($params)) {
            $params = array();
        }

        $params = http_build_query(array_merge(array(
            'page' => 'sp-dsgvo',
        ), $params));

        return admin_url() . '?' . $params;
    }

    public static function pluginDir($append = '')
    {
        return plugin_dir_path(dirname(__FILE__)) . $append;
    }

    public static function pluginURI($append = '')
    {
        return plugin_dir_url(dirname(__FILE__)) . $append;
    }

    public static function isAjax()
    {
        return (strpos($_SERVER['REQUEST_URI'], 'admin-ajax.php') !== FALSE);
    }

    public function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
