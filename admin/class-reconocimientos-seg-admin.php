<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.open-link.net
 * @since      1.0.0
 *
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/admin
 * @author     José Julián Abarca Chávez <julian.abarca@gmail.com>
 */
class Reconocimientos_Seg_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/Administration_Menus
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu() {

		add_submenu_page(
			'edit.php?post_type=reconocimiento',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Configuraciones', 'now-hiring' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Configuraciones', 'now-hiring' ) ),
			'manage_options',
			$this->plugin_name . '-settings',
			array( $this, 'page_options' )
		);

		add_submenu_page(
			'edit.php?post_type=reconocimiento',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Noticias Help', 'now-hiring' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Ayuda', 'now-hiring' ) ),
			'manage_options',
			$this->plugin_name . '-help',
			array( $this, 'page_help')
		 );
	}

	/**
	* Crea una nuevo custom post type
	* @since 1.0.0
	* @access public
	* @uses register_post_type()
	*/
	public static function reconocimientos_cpt () {
		$cap_type 	= 'reconocimiento';
		$plural 	= 'Reconocimientos';
		$single 	= 'Reconocimiento';
		$cpt_name 	= 'reconocimiento';

		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= 'Plugin para capturar reconocimientos';
		$opts['exclude_from_search']					= FALSE;
		$opts['has_archive']							= TRUE;
		$opts['hierarchical']							= TRUE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 'dashicons-format-aside';
		$opts['menu_position']							= 25;
		$opts['public']									= TRUE;
		$opts['publicly_querable']						= TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'excerpt' );
		$opts['taxonomies']								= array();

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";

		$opts['labels']['name']							= esc_html__( "Reconocimientos", 'now-hiring' );
		$opts['labels']['singular_name']				= esc_html__( "Reconocimiento", 'now-hiring' );
		$opts['labels']['add_new']						= esc_html__( "Agregar reconocimiento ({$single})", 'destacados' );
		$opts['labels']['add_new_item']					= esc_html__( "Agregar nuevo {$single}", 'now-hiring' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'now-hiring' );
		$opts['labels']['edit_item']					= esc_html__( "Editar {$single}" , 'now-hiring' );
		$opts['labels']['menu_name']					= esc_html__( $plural, 'now-hiring' );
		$opts['labels']['name']							= esc_html__( $plural, 'now-hiring' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'now-hiring' );
		$opts['labels']['new_item']						= esc_html__( "Nuevo {$single}", 'now-hiring' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'now-hiring' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'now-hiring' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'now-hiring' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'now-hiring' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'now-hiring' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'now-hiring' );

		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $plural ), 'now-hiring' );
		$opts['rewrite']['with_front']					= TRUE;
		$opts['descripcion']							= esc_html( "Formulario para generar reconocimientos" );

		$opts = apply_filters( 'reconocimiento-cpt-options', $opts );

		register_post_type( strtolower( $cpt_name ), $opts );		
	}
	// /**
	// * Crea una nuevo custom post type
	// * @since 1.0.0
	// * @access public
	// * @uses register_post_type()
	// */
	// public static function reconocimientos_cpt () {
	// 	$cap_type 	= 'post';
	// 	$plural 	= 'Reconocimientos';
	// 	$single 	= 'Reconocimiento';
	// 	$cpt_name 	= 'reconocimiento';

	// 	$opts['can_export']								= TRUE;
	// 	$opts['capability_type']						= $cap_type;
	// 	$opts['description']							= 'Plugin para capturar reconocimientos';
	// 	$opts['exclude_from_search']					= FALSE;
	// 	$opts['has_archive']							= TRUE;
	// 	$opts['hierarchical']							= TRUE;
	// 	$opts['map_meta_cap']							= TRUE;
	// 	$opts['menu_icon']								= 'dashicons-format-aside';
	// 	$opts['menu_position']							= 25;
	// 	$opts['public']									= TRUE;
	// 	$opts['publicly_querable']						= TRUE;
	// 	$opts['query_var']								= TRUE;
	// 	$opts['register_meta_box_cb']					= '';
	// 	$opts['rewrite']								= FALSE;
	// 	$opts['show_in_admin_bar']						= TRUE;
	// 	$opts['show_in_menu']							= TRUE;
	// 	$opts['show_in_nav_menu']						= TRUE;
	// 	$opts['show_ui']								= TRUE;
	// 	$opts['supports']								= array( 'title', 'excerpt' );
	// 	$opts['taxonomies']								= array();

	// 	$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
	// 	$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
	// 	$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
	// 	$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
	// 	$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
	// 	$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
	// 	$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
	// 	$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
	// 	$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
	// 	$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
	// 	$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
	// 	$opts['capabilities']['read_post']				= "read_{$cap_type}";
	// 	$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";

	// 	$opts['labels']['name']							= esc_html__( "Reconocimientos", 'now-hiring' );
	// 	$opts['labels']['singular_name']				= esc_html__( "Reconocimiento", 'now-hiring' );
	// 	$opts['labels']['add_new']						= esc_html__( "Agregar reconocimiento ({$single})", 'destacados' );
	// 	$opts['labels']['add_new_item']					= esc_html__( "Agregar nuevo {$single}", 'now-hiring' );
	// 	$opts['labels']['all_items']					= esc_html__( $plural, 'now-hiring' );
	// 	$opts['labels']['edit_item']					= esc_html__( "Editar {$single}" , 'now-hiring' );
	// 	$opts['labels']['menu_name']					= esc_html__( $plural, 'now-hiring' );
	// 	$opts['labels']['name']							= esc_html__( $plural, 'now-hiring' );
	// 	$opts['labels']['name_admin_bar']				= esc_html__( $single, 'now-hiring' );
	// 	$opts['labels']['new_item']						= esc_html__( "Nuevo {$single}", 'now-hiring' );
	// 	$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'now-hiring' );
	// 	$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'now-hiring' );
	// 	$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'now-hiring' );
	// 	$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'now-hiring' );
	// 	$opts['labels']['singular_name']				= esc_html__( $single, 'now-hiring' );
	// 	$opts['labels']['view_item']					= esc_html__( "View {$single}", 'now-hiring' );

	// 	$opts['rewrite']['ep_mask']						= EP_PERMALINK;
	// 	$opts['rewrite']['feeds']						= FALSE;
	// 	$opts['rewrite']['pages']						= TRUE;
	// 	$opts['rewrite']['slug']						= esc_html__( strtolower( $plural ), 'now-hiring' );
	// 	$opts['rewrite']['with_front']					= TRUE;
	// 	$opts['descripcion']							= esc_html( "Formulario para generar reconocimientos" );

	// 	$opts = apply_filters( 'reconocimiento-cpt-options', $opts );

	// 	register_post_type( strtolower( $cpt_name ), $opts );
		
	// }

	/**
	 * Creates a new taxonomy for a custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function reconocimientos_taxonomy_type() {

		$plural 	= 'Valores';
		$single 	= 'Valor';
		$tax_name 	= 'valores';

		$opts['hierarchical']							= FALSE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= TRUE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'now-hiring' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'now-hiring' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'now-hiring' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'now-hiring' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'now-hiring');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'now-hiring' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'now-hiring' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'now-hiring' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'now-hiring' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'now-hiring' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'now-hiring' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'now-hiring' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'now-hiring' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'now-hiring' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'now-hiring' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'now-hiring' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'now-hiring' );

		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'now-hiring' );
		$opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'reconocimiento-taxonomy-options', $opts );

		register_taxonomy( $tax_name, 'reconocimiento', $opts );

	} // reconocimientos_taxonomy_type

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Reconocimientos_Seg_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Reconocimientos_Seg_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/reconocimientos-seg-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'easy-autocomplete.min', plugin_dir_url( __FILE__ ) . 'css/easy-autocomplete.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'easy-autocomplete.themes.min', plugin_dir_url( __FILE__ ) . 'css/easy-autocomplete.themes.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Reconocimientos_Seg_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Reconocimientos_Seg_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		 global $post_type;
		 $screen = get_current_screen();
		 if ( 'reconocimiento' === $post_type || $screen->id === $hook_suffix )  {

			//  wp_deregister_script('jquery'); 
            //  wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', false, '3.2.1'); 
            //  wp_enqueue_script('jquery');
		 	 wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/reconocimientos-seg-admin.js', array( 'jquery' ), $this->version, false );
			 wp_enqueue_script( 'easy-autocomplete', plugin_dir_url( __FILE__ ) . 'js/jquery.easy-autocomplete.js', array( 'jquery' ), $this->version, false );
			 wp_localize_script( $this->plugin_name, 'ajax_object',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'security'=> wp_create_nonce( 'security-nonce') ) );
		 }
	}
	public function custom_field_form( $user ) {
		include( plugin_dir_path( __FILE__ ) . 'partials/reconocimientos-seg-admin-display-user.php' );
	}
	public function save_custom_field_profile( $userId ) {
		if ( !current_user_can('edit_user', $userId )) {
			return;
		}
		update_user_meta($userId, 'puesto', $_REQUEST['puesto']);
		update_user_meta($userId, 'c_adscripcion', $_REQUEST['c_adscripcion']);
		update_user_meta($userId, 'f_nacimiento', $_REQUEST['f_nacimiento']);
	}
	
	public function my_action(){
		//Verificar nonce
		if ( ! check_ajax_referer( 'security-nonce', 'security' ) ) {
			wp_send_json_error( 'Invalid security token sent.' );
    		wp_die();
		}					
		global $wpdb;
		// $search_term = esc_attr( $_POST['search_term'] );
		$search_term =  esc_attr( trim( $_POST['search_term'] ));
		// $search_term = array ("josé");
		// echo json_encode( $search_term );
		// wp_die();
		// $search_term = '';
		$args = array(			
			'orderby' => 'display_name',
			'order' => 'ASC',			
			'search' => '*'.$search_term.'*',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key'     => 'first_name',
					'value'   => $search_term,
					'compare' => 'LIKE'
				),
				array(
					'key'     => 'last_name',
					'value'   => $search_term,
					'compare' => 'LIKE'
				),				
    		),			
		);
		$i = 0;
		$user_query = new WP_User_Query( $args );		
		if ( ! empty( $user_query->results ) ) {
			$usuarios = array();			
    		foreach ( $user_query->results as $author ) {
				$author_info = get_userdata( $author->ID );
				// $usuarios[$i] = $author_info->first_name ." ". $author_info->last_name;
				$usuarios[$i]['id'] = $author_info->ID;
				$usuarios[$i]['name'] = $author_info->first_name ." ". $author_info->last_name;
				$usuarios[$i]['icon'] = get_avatar_url( $author->ID );
				$i++;
			}
			// $usuarios = $user_query->get_total();			
			echo json_encode( $usuarios );
			// echo json_encode( $user_query->get_total);
			wp_die();
		} else {
			echo json_encode( "No se encontraron registros");
			exit();
		}
		// echo $whatever + $_POST['whatever'] + $_POST['user_id'];
		// echo $i;
		
		

		// $user_query = new WP_User_Query( $args );
		// if ( ! empty( $user_query->results ) ) {
		// 	$usuarios = array();
		// 	$i = 0;
    	// 	foreach ( $user_query->results as $author ) {
		// 		$usuarios[$i] = $author;
		// 	}
		// 	echo $usuarios;
		// } else 
		// 	echo "Not value";
		// wp_die();
	}
}
