<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://anuness.dev/
 * @since             1.0.0
 * @package           Api_Anuness_Dev
 *
 * @wordpress-plugin
 * Plugin Name:       SuperAPI
 * Plugin URI:        https://anuness.dev/
 * Description:       🦉 My super-duper API
 * Version:           1.0.0
 * Author:            André Nunes
 * Author URI:        https://anuness.dev//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       api-anuness-dev
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('API_ANUNESS_DEV_VERSION', '1.0.0');
define('API_ANUNESS_DEV_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('API_ANUNESS_DEV_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-api-anuness-dev-activator.php
 */
function activate_api_anuness_dev()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-api-anuness-dev-activator.php';
    Api_Anuness_Dev_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-api-anuness-dev-deactivator.php
 */
function deactivate_api_anuness_dev()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-api-anuness-dev-deactivator.php';
    Api_Anuness_Dev_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_api_anuness_dev');
register_deactivation_hook(__FILE__, 'deactivate_api_anuness_dev');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-api-anuness-dev.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_api_anuness_dev()
{

    $plugin = new Api_Anuness_Dev();
    $plugin->run();
}


$composer_autoload = API_ANUNESS_DEV_PLUGIN_DIR . 'vendor/autoload.php';
if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
    if (class_exists('\Carbon_Fields\Carbon_Fields')) {
        add_action('after_setup_theme', function () {
            \Carbon_Fields\Carbon_Fields::boot();
        });
        run_api_anuness_dev();
    }
} else {
    add_action(
        'admin_enqueue_scripts',
        function () {
            wp_enqueue_style('TailwindCSS', API_ANUNESS_DEV_PLUGIN_URL . 'assets/css/tailwind.css', array(), current_time('timestamp'), 'all');
        }
    );
    add_action('admin_notices', function () {
        printf(
            '<div class="spapi-container spapi-alert spapi-alert-error spapi-max-w-2xl spapi-my-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="spapi-stroke-current spapi-shrink-0 spapi-h-6 spapi-w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p>%s</p>
            </div>',
            __('SuperAPI: Please run composer install to install the dependencies', 'api-anuness-dev')
        );
    });
}
