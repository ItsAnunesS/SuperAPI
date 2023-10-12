<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://anuness.dev/
 * @since      1.0.0
 *
 * @package    Api_Anuness_Dev
 * @subpackage Api_Anuness_Dev/includes
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
 * @package    Api_Anuness_Dev
 * @subpackage Api_Anuness_Dev/includes
 * @author     André Nunes <hello@anuness.dev>
 */
class Api_Anuness_Dev
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Api_Anuness_Dev_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('API_ANUNESS_DEV_VERSION')) {
            $this->version = API_ANUNESS_DEV_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'api-anuness-dev';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_settings_hooks();
        $this->define_cpt_hooks();
        $this->define_api_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Api_Anuness_Dev_Loader. Orchestrates the hooks of the plugin.
     * - Api_Anuness_Dev_i18n. Defines internationalization functionality.
     * - Api_Anuness_Dev_Admin. Defines all hooks for the admin area.
     * - Api_Anuness_Dev_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once API_ANUNESS_DEV_PLUGIN_DIR . 'includes/class-api-anuness-dev-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once API_ANUNESS_DEV_PLUGIN_DIR . 'includes/class-api-anuness-dev-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once API_ANUNESS_DEV_PLUGIN_DIR . 'admin/class-api-anuness-dev-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once API_ANUNESS_DEV_PLUGIN_DIR . 'public/class-api-anuness-dev-public.php';

        /**
         * The class responsible for defining all settings that occur in the admin area.
         */
        require_once API_ANUNESS_DEV_PLUGIN_DIR . 'admin/class-api-anuness-dev-settings.php';

        /**
         * The class responsible for the CPT's.
         */
        require_once API_ANUNESS_DEV_PLUGIN_DIR . 'includes/class-api-anuness-dev-cpt.php';

        /**
         * The class responsible for the OpenAI Integration
         */
        require_once API_ANUNESS_DEV_PLUGIN_DIR . 'includes/class-api-anuness-dev-openai.php';

        /**
         *  The class responsible for the API endpoints.
         */
        require_once API_ANUNESS_DEV_PLUGIN_DIR . 'includes/class-api-anuness-dev-api.php';

        $this->loader = new Api_Anuness_Dev_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Api_Anuness_Dev_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Api_Anuness_Dev_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Api_Anuness_Dev_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    /**
     *
     */
    private function define_settings_hooks()
    {
        $plugin_settings = new Api_Anuness_Dev_Settings();

        $this->loader->add_action('carbon_fields_register_fields', $plugin_settings, 'init');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Api_Anuness_Dev_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('template_redirect', $plugin_public, 'redirect_to_login_when_not_logged_in');
        $this->loader->add_filter('rest_url_prefix', $plugin_public, 'change_rest_url_prefix');
    }

    /**
     * Register all of the hooks related to the API functionality
     *
     * @since    1.0.0
     */
    private function define_api_hooks()
    {
        $api_dir = API_ANUNESS_DEV_PLUGIN_DIR . 'api/';
        if (!is_dir($api_dir)) new WP_Error('api_anuness_dev_api_dir_not_found', 'API directory not found');
        $plugin_api = new Api_Anuness_Dev_Api($api_dir);

        $this->loader->add_action('rest_api_init', $plugin_api, 'init');
    }

    /**
     * Register all the hooks related to the CPT's
     *
     * @since    1.0.0
     */
    private function define_cpt_hooks()
    {
        $cpt_dir = API_ANUNESS_DEV_PLUGIN_DIR . 'cpt/';
        if (!is_dir($cpt_dir)) new WP_Error('api_anuness_dev_cpt_dir_not_found', 'CPT directory not found');
        $plugin_cpt = new Api_Anuness_Dev_CPT($cpt_dir);

        $this->loader->add_action('carbon_fields_register_fields', $plugin_cpt, 'init');
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
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Api_Anuness_Dev_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
