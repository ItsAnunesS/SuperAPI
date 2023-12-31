<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://anuness.dev/
 * @since      1.0.0
 *
 * @package    Api_Anuness_Dev
 * @subpackage Api_Anuness_Dev/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Api_Anuness_Dev
 * @subpackage Api_Anuness_Dev/public
 * @author     André Nunes <hello@anuness.dev>
 */
class Api_Anuness_Dev_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Api_Anuness_Dev_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Api_Anuness_Dev_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/api-anuness-dev-public.css', array(), $this->version, 'all');

        wp_enqueue_style('TailwindCSS', API_ANUNESS_DEV_PLUGIN_URL . 'assets/css/tailwind.css', array(), current_time('timestamp'), 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Api_Anuness_Dev_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Api_Anuness_Dev_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/api-anuness-dev-public.js', array('jquery'), $this->version, false);
    }

    /**
     * Change the rest url prefix
     *
     * @since    1.0.0
     */
    public function change_rest_url_prefix()
    {
        return 'rest';
    }

    /**
     * Modify the REST API URL prefix for the 'ringles' function
     *
     * @since    1.0.0
     */
    public function redirect_to_login_when_not_logged_in()
    {
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url());
            exit;
        }
    }
}
