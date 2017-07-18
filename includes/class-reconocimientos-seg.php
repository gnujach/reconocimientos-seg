<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.open-link.net
 * @since      1.0.0
 *
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/includes
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
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/includes
 * @author     José Julián Abarca Chávez <julian.abarca@gmail.com>
 */
class Reconocimientos_Seg {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Reconocimientos_Seg_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	public function __construct() {

		$this->plugin_name = 'reconocimientos-seg';
		$this->version = '1.0.0';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_metabox_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Reconocimientos_Seg_Loader. Orchestrates the hooks of the plugin.
	 * - Reconocimientos_Seg_i18n. Defines internationalization functionality.
	 * - Reconocimientos_Seg_Admin. Defines all hooks for the admin area.
	 * - Reconocimientos_Seg_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-reconocimientos-seg-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-reconocimientos-seg-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-reconocimientos-seg-admin.php';
		/**
		* The class responsible for load all metaboxes
		*
		*/
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-reconocimientos-seg-admin-metaboxes.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-reconocimientos-seg-public.php';
		/**
		 * The class responsible for defining all actions creating the templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-reconocimientos-seg-template-functions.php';
		/**
		 * The class responsible for all global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/reconocimientos-seg-global-functions.php';
		/** The class responsible for defining all actions shared by the Dashboard and public-facing sides.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-reconocimientos-seg-shared.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-reconocimiento-seg-sanitize.php';
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-reconocimientos-seg-global.php';


		$this->loader = new Reconocimientos_Seg_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Reconocimientos_Seg_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Reconocimientos_Seg_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Reconocimientos_Seg_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $plugin_admin, 'reconocimientos_cpt' );
		$this->loader->add_action( 'init', $plugin_admin, 'reconocimientos_taxonomy_type' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );		
		$this->loader->add_action( 'wp_ajax_my_action', $plugin_admin, 'my_action' );
		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'custom_field_form' );
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'custom_field_form' );
		$this->loader->add_action( 'user_new_form', $plugin_admin, 'custom_field_form' );
		$this->loader->add_action( 'personal_options_update', $plugin_admin,'save_custom_field_profile');
		$this->loader->add_action( 'edit_user_profile_update',$plugin_admin, 'save_custom_field_profile');
		$this->loader->add_action( 'user_register', $plugin_admin, 'save_custom_field_profile');
		

	}

	 /**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_hooks() {

		$plugin_metaboxes = new Reconocimientos_Seg_Admin_Metaboxes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'add_meta_boxes', $plugin_metaboxes, 'add_metaboxes' );
		$this->loader->add_action( 'add_meta_boxes_reconocimiento', $plugin_metaboxes, 'set_meta' );
		// $this->loader->add_filter( 'wp_insert_post_data', $plugin_metaboxes, 'verificar_thumbnails',99,2 );
		// $this->loader->add_action( 'pre_post_update', $plugin_metaboxes, 'validate_datas', 10, 2 );		
		$this->loader->add_action( 'save_post_reconocimiento', $plugin_metaboxes, 'validate_meta', 10, 2 );
		// $this->loader->add_action( 'admin_notices', $plugin_metaboxes, 'printMsgAdmin', 10, 2 );
		// $this->loader->add_filter( '', $plugin_metaboxes, 'verificar_thumbnails',99,2 );
		$this->loader->add_filter( 'gettext', $plugin_metaboxes, 'change_metabox_label', 10, 2 );
		// $this->loader->add_action( 'save_post_destacado', $plugin_metaboxes, 'validate_metas', 10, 2 );
		// $this->loader->add_action( 'admin_menu', $plugin_metaboxes, 'remove_publish_box', 90, 2 );
		// $this->loader->add_filter( 'gettext', $plugin_metaboxes, 'change_admin_cpt_text_filter', 20, 2 );
		

	} // define_metabox_hooks()

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Reconocimientos_Seg_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Reconocimientos_Seg_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
