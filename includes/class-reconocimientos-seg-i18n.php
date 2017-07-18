<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.open-link.net
 * @since      1.0.0
 *
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/includes
 * @author     José Julián Abarca Chávez <julian.abarca@gmail.com>
 */
class Reconocimientos_Seg_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'reconocimientos-seg',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
