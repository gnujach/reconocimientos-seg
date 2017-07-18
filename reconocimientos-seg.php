<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.open-link.net
 * @since             1.0.0
 * @package           Reconocimientos_Seg
 *
 * @wordpress-plugin
 * Plugin Name:       Reconocimientos Seg
 * Plugin URI:        www.open-link.net
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            José Julián Abarca Chávez
 * Author URI:        http://www.open-link.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       reconocimientos-seg
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-reconocimientos-seg-activator.php
 */
function activate_reconocimientos_seg() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-reconocimientos-seg-activator.php';
	Reconocimientos_Seg_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-reconocimientos-seg-deactivator.php
 */
function desactivate_reconocimientos_seg() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-reconocimientos-seg-deactivator.php';
	Reconocimientos_Seg_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_reconocimientos_seg' );
register_deactivation_hook( __FILE__, 'deactivate_reconocimientos_seg' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-reconocimientos-seg.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_reconocimientos_seg() {

	$plugin = new Reconocimientos_Seg();
	$plugin->run();

}
run_reconocimientos_seg();
