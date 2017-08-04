<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.open-link.net
 * @since      1.0.0
 *
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/public
 * @author     José Julián Abarca Chávez <julian.abarca@gmail.com>
 */
class Reconocimientos_Seg_Public {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function register_shortcodes() {

		add_shortcode( 'dnii_reconocimientos', array( $this, 'mostrar_reconocimientos' ) );
		add_shortcode( 'dnii_reconocimientos_post', array( $this, 'post_reconocimientos' ) );

	} // register_shortcodes()

	public function mostrar_reconocimientos ( $atts = array () ){		
		ob_start();
		$defaults['loop-template'] 	=	$this->plugin_name . '-loop';
		$defaults['order'] 			=	'date';
		// $defaults['order'] 			=	'order';
		$defaults['quantity'] 		=	10;
		$args 						=	shortcode_atts( $defaults, $atts, 'dnii_reconocimientos');
		$shared 					=	new Reconocimientos_Seg_Shared( $this->plugin_name, $this->version );
		$items 						=	$shared->get_reconocimientos( $args );
		// var_dump($args['loop-template']);
		if (is_array( $items ) || is_object( $items ) ) {
			include reconocimientos_get_template( $args['loop-template'] );
		} else {
			$items;
		}
		$output = ob_get_contents();
		ob_end_clean();		
		return $output;
	}

	public function post_reconocimientos(){
		ob_start();
		$defaults['save-template'] 	=	$this->plugin_name . '-save';
		// print_r( $defaults );
		// $defaults['loop-template'] 	=	$this->plugin_name . '-loop';
		include reconocimientos_get_template( $defaults['save-template'] );
		// include reconocimientos_get_template( $args['loop-template'] );
		$output = ob_get_contents();
		ob_end_clean();		
		return $output;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( 'easy-autocomplete.min', plugin_dir_url( __FILE__ ) . 'css/easy-autocomplete.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'easy-autocomplete.themes.min', plugin_dir_url( __FILE__ ) . 'css/easy-autocomplete.themes.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/reconocimientos-seg-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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
		// global $post_type;
		// $screen = get_current_screen();
		if ( is_page( 'crear-reconocimiento' ) )
		{
			wp_deregister_script('jquery'); 
			wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', false, '3.2.1'); 
			wp_enqueue_script('jquery');
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/reconocimientos-seg-public.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'easy-autocomplete', plugin_dir_url( __FILE__ ) . 'js/jquery.easy-autocomplete.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'security'=> wp_create_nonce( 'security-nonce') ) );
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/reconocimientos-seg-public.js', array( 'jquery' ), $this->version, false );
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
