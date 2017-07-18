<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		http://http://www.open-link.net
 * @since 		1.0.0
 *
 * @package 	Reconocimientos
 * @subpackage 	Reconocimientos/admin
 */

/**
 * The metabox-specific functionality of the plugin.
 *
 * @package 	Reconocimientos
 * @subpackage 	Reconocimientos/admin
 * @author 		José Julián Abarca Chávez <julian.abarca@gmail.com>
 */
class Reconocimientos_Seg_Admin_Metaboxes {
	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;
	private $errors;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$Now_Hiring 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->set_meta();
	}

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_metaboxes() {

		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
		add_meta_box(
			'reconocimiento_additional_info',
			apply_filters( $this->plugin_name . '-metabox-title-additional-info', esc_html__( 'Compañero a reconocer', 'reconocimientos-seg' ) ),
			array( $this, 'metabox' ),
			'reconocimiento',
			'normal',
			'high',
			array(
				'name'			=>	'reconocimiento_usuario',
				'file' 			=> 	'field-text',
				'class'			=> 	'form-control',
				'type'			=>	'hidden',
				//'value' 		=>	get_home_url(),
				'size'			=>	40,
				'label'			=>	'Nombre',
				'description'	=>	'(Escribe el nombre del servidor público)'
			));
		// 	add_meta_box(
		// 	'destacado_expiration',
		// 	apply_filters( $this->plugin_name . '-metabox-expiration', esc_html__( 'Información Expiración', 'destacado' ) ),
		// 	array( $this, 'metabox' ),
		// 	'destacado',
		// 	'normal',
		// 	'high',
		// 	array(
		// 		'name'			=>	'destacado_expiration',
		// 		'file' 			=> 	'field-date',
		// 		'class'			=> 	'form-control',
		// 		'type'			=>	'date',
		// 		'value' 		=>	'',				
		// 		'description'	=>	'Escribe la fecha de caducidad de la noticia en formato dd/mm/aaaa',
		// 		'placeholder'	=>	'dd-mm-aaaa'
		// 	)
		// );
		
		

	} // add_metaboxes()

	/**
	 * Check each nonce. If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0.
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		int 		The value of $nonce_check
	 */
	private function check_nonces( $posted ) {

		$nonces 		= array();
		$nonce_check 	= 0;
		// wp_die(print_r($posted));		
		$nonces[] 		= 'reconocimiento_usuario_nonce';
		// $nonces[] 		= 'destacado_expiration_nonce';		
		foreach ( $nonces as $nonce ) {

			if ( ! isset( $posted[$nonce] ) ) { $nonce_check++; }
			if ( isset( $posted[$nonce] ) && ! wp_verify_nonce( $posted[$nonce], $this->plugin_name ) ) { $nonce_check++; }

		}
		// wp_die($nonce_check);
		return $nonce_check;

	} // check_nonces()

	/**
	 * Returns an array of the all the metabox fields and their respective types
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		array 		Metabox fields and types
	 */
	private function get_metabox_fields() {
		$fields = array();	
		$fields[] = array( 'reconocimiento_usuario', 'text' );		
		return $fields;
	} // get_metabox_fields()

	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function metabox( $post, $params ) {	
		
		if ( ! is_admin() ) { return; }
		if ( 'reconocimiento' !== $post->post_type ) { return; }
		// wp_die(print_r($params));
		// wp_die('partials/reconocimientos-seg-admin-' . $params['args']['file'] . '.php');
		include( plugin_dir_path( __FILE__ ) . 'partials/reconocimientos-seg-admin-' . $params['args']['file'] . '.php' );

	} // metabox()

	private function validate_data ( $data ) {			
		if  ( empty ( $data ) ) {			
			return new WP_Error ('Error', __("Encontramos un error"));
		}			
		return true;
	}

	private function sanitizer( $type, $data ) {

		if ( empty( $type ) ) { return; }
		if ( empty( $data ) ) { return; }
		// 
		$return 	= '';
		$sanitizer 	= new Reconocimiento_Seg_Sanitize();

		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );		
		$return = $sanitizer->clean();
		// var_dump($return);
		// die();
		unset( $sanitizer );

		return $return;

	} // sanitizer()

	/**
	 * Saves button order when buttons are sorted.
	 */
	public function save_files_order() {

		check_ajax_referer( 'now-hiring-file-order-nonce', 'fileordernonce' );

		$order 						= $this->meta['file-order'];
		$new_order 					= implode( ',', $_POST['file-order'] );
		$this->meta['file-order'] 	= $new_order;
		$update 					= update_post_meta( 'file-order', $new_order );

		esc_html_e( 'Entrada guardada.', 'now-hiring' );

		die();

	} // save_files_order()



	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'reconocimiento' != $post->post_type ) { return; }

		// wp_die( '<pre>' . print_r ( get_post_custom( $post->ID )) . '</pre>' );
		
		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Saves metabox data
	 *
	 * Repeater section works like this:
	 *  	Loops through meta fields
	 *  		Loops through submitted data
	 *  		Sanitizes each field into $clean array
	 *   	Gets max of $clean to use in FOR loop
	 *   	FOR loops through $clean, adding each value to $new_value as an array
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @param 	int 		$post_id 		The post ID
	 * @param 	object 		$object 		The post object
	 * @return 	void
	 */
	public function validate_meta( $post_id, $object ) {
		// wp_die(print_r($_POST));
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return $post_id; }
		if ( 'reconocimiento' !== $object->post_type ) { return $post_id; }		
		$nonce_check = $this->check_nonces( $_POST );		
		if ( 0 < $nonce_check ) { 
			// status_header( '403' );
			// wp_die(  "Campo no puede ser vacío: ". $name, "Error" );
			// return;	
			return $post_id; 
		}
		$metas = $this->get_metabox_fields();
		// wp_die( '<pre>' . var_dump( $metas ) . '</pre>' );
		foreach ( $metas as $meta ) {
			$name = $meta[0];
			$type = $meta[1];			
			// $validate = false;
			// $validate = $this->validate_data( $_POST[$name] );
			
			$new_value = $this->sanitizer( $type, $_POST[$name] );
			//wp_die( '<pre>' . print_r( $new_value."--" .$_POST[$name] ) . '</pre>' );
				
			
			
			// wp_die( '<pre>' . print_r( $new_value."--" .$_POST[$name] ) . '</pre>' );
			update_post_meta( $post_id, $name, $new_value );
			// wp_die( '<pre>' . print_r( $post_id."--" .$name."--".$new_value ) . '</pre>' );			

		} // foreach

	} // validate_meta()
	private function validar_post_title ($title) {
		if  ( empty ( $title ) ) {			
			return "Error: el campo titulo no puede ser vacío";
		}
	}
	// private function validar_img_destacado ($img) {
	// 	if  ( empty ( $img ) ) {
	// 		return new WP_Error ('Error', __("Debes agregar una imagen destacada"));
	// 	}			
	// 	return true;
	// }
	// public function printMsgAdmin () {
	// 	global $post;
		
	// 	if ( 'destacado' != $post->post_type ) { return; }
	// 	// $validate = $this->validate_data( $_POST[$name] );
	// 	// if ( is_wp_error( $validate )) {
	// 	// 	$output = '<div class="error">';				
	// 	// 	$output.= '<p>'.$validate->get_error_message().'</p>';
	// 	// 	$output.= '</div>';
	// 	// 	echo $output;
	// 	// }
	// 	$output = '<div class="error">';
	// 	$output.= '<p>Error</p>';		
	// 	echo $output;
	// }
	// public function validate_datas($id, $data) {		
	// 	$this->errors = $this->validar_post_title($data['post_title']);
	// }

    public function change_metabox_label($translated_text, $untranslated_text){
        global $post;
        if ( 'reconocimiento' != $post->post_type )		
            return $translated_text;
		$to_replace = 'Excerpts are optional hand-crafted summaries of your content that can be used in your theme. <a href="http://codex.wordpress.org/Excerpt" target="_blank">Learn more about manual excerpts.</a>';
		switch ( $untranslated_text ) {
			case $to_replace :
				$translated_text = __("Ver","wordpress");
				break;
			case "Excerpt":
				$translated_text = __("Motivo del reconocimiento",'wordpress');
				break;			
		}
        // if ( $untranslated_text == 'Excerpt' ){
        //     $translated_text = "Motivo";
        // 	return $translated_text;
		// }
		// $to_replace = 'Excerpts are optional hand-crafted summaries of your content that can be used in your theme. <a href="http://codex.wordpress.org/Excerpt" target="_blank">Learn more about manual excerpts.</a>';
		// if ( $untranslated_text == $to_replace ){
		// 	$translated_text = "Motivo";
		// 	return $translated_text;
		// }
		return $translated_text;
    }
    public function change_meta_box_titles(){
        global $wp_meta_boxes;
        $wp_meta_boxes['reconocimiento']['normal']['core']['postexcerpt']['title']= 'Motivo';
        // echo '<pre>';
        // print_r($wp_meta_boxes);
        // echo '</pre>';
        // wp_die('');
    }
    public function remove_publish_box (){
         remove_meta_box( 'submitdiv', 'reconocimiento', 'side' );
        //  remove_meta_box( 'postexcerpt', 'reconocimiento', 'normal' );
    }
    public function change_admin_cpt_text_filter( $translated_text, $untranslated_text, $domain ) {
        global $post;       
        if ( 'reconocimiento' != $post->post_type )  
            return $translated_text; 
        $to_replace = 'Excerpts are optional hand-crafted summaries of your content that can be used in your theme. <a href="http://codex.wordpress.org/Excerpt" target="_blank">Learn more about manual excerpts.</a>';
        if ($to_replace == $untranslated_text)
                return 'your_textdomain';        
        return $untranslated_text;
    }
} // class