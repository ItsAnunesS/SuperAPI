<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://anuness.dev/
 * @since      1.0.0
 *
 * @package    Api_Anuness_Dev
 * @subpackage Api_Anuness_Dev/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Api_Anuness_Dev
 * @subpackage Api_Anuness_Dev/includes
 * @author     André Nunes <hello@anuness.dev>
 */
class Api_Anuness_Dev_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'api-anuness-dev',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
