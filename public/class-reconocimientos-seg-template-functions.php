<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Destacados
 * @subpackage Destacados/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package    Destacados
 * @subpackage Destacados/public
 *
 */
class Reconocimientos_Seg_Template_Functions {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
 	 */
	private static $_this;

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
	 * @param      string    $version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		self::$_this = $this;

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	} // __construct()

	/**
	 * Includes the now-hiring-job-title template
	 *
	 * @hooked 		now-hiring-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_opinion_title( $item, $meta ) {		
		include destacados_get_template( 'noticias-job-title' );

	} // content_job_title()

	public function featured_image_get( $item, $meta) {
		
		include destacados_get_template( 'noticias-content_featured_image' );
	 } //close featured_image()

	public  function content_opinion_municipio( $item, $meta){
		include destacados_get_template( 'noticias-content_opinion_municipio');
		
	 } //content_opinion_municipio

	 public function open_column () {
		 include destacados_get_template( 'noticias-content_open_column' );
	 } //open_column()

	 public function close_column () {
		 include destacados_get_template( 'noticias-content_close_column' );
	 } //close_column()

	 

	/**
	 * Includes the employee name template file
	 *
	 * @hooked 		now-hiring-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_opinion_location( $item, $meta ) {

		include destacados_get_template( 'noticias-job-location' );

	} // content_job_location()

	/**
	 * Includes the link end template file
	 *
	 * @hooked 		now-hiring-after-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_link_end( $item, $meta ) {

		include destacados_get_template( 'noticias-content-link-end' );

	} // content_link_end()

	/**
	 * Includes the link start template file
	 *
	 * @hooked 		now-hiring-before-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_link_start( $item, $meta ) {

		include destacados_get_template( 'noticias-content-link-start' );

	} // content_link_start()

	/**
	 * Includes the content wrap end template file
	 *
	 * @hooked 		now-hiring-after-loop-content 		90
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_wrap_end( $item, $meta ) {

		include destacados_get_template( 'noticias-content-wrap-end' );

	} // content_wrap_end()
	public function item_list ( $item, $meta ) {
		include destacados_get_template( 'noticias-content-item-list' );
	}

	/**
	 * Includes the content wrap start template file
	 *
	 * @hooked 		now-hiring-before-loop-content 		10
	 */
	public function content_wrap_start() {

		include destacados_get_template( 'noticias-content-wrap-start' );

	} // content_wrap_start()

	/**
	 * Returns an array of the featured image details
	 *
	 * @param 	int 	$postID 		The post ID
	 * @return 	array 					Array of info about the featured image
	 */
	public function get_featured_images( $postID ) {

		if ( empty( $postID ) ) { return FALSE; }

		$imageID = get_post_thumbnail_id( $postID );

		if ( empty( $imageID ) ) { return FALSE; }

		return wp_prepare_attachment_for_js( $imageID );

	} // get_featured_images()

	/**
	 * Includes the list wrap end template file
	 *
	 * @hooked 		now-hiring-after-loop 		10
	 */
	public function list_wrap_end() {

		include destacados_get_template( 'noticias-list-wrap-end' );

	} // list_wrap_end()

	/**
	 * Includes the list wrap start template file
	 *
	 * @hooked 		now-hiring-before-loop 		10
	 */
	public function list_wrap_start() {

		include destacados_get_template( 'noticias-list-wrap-start' );

	} // list_wrap_start()

	/**
	 * Includes the single job post content
	 *
	 * @hooked 		now-hiring-single-content 	15
	 */
	public function single_post_content() {

		include destacados_get_template( 'single-job-post-content' );

	} // single_post_content()

	/**
	 * Includes the single job post metadata for education
	 *
	 * @hooked 		now-hiring-single-content 	30
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_post_education( $meta ) {

		include destacados_get_template( 'single-job-meta-education' );

	} // single_post_education()

	/**
	 * Includes the single job post metadata for experience
	 *
	 * @hooked 		now-hiring-single-content 	40
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_post_experience( $meta ) {

		include destacados_get_template( 'single-job-meta-experience' );

	} // single_post_experience()

	/**
	 * Includes the single job post metadata for the file
	 *
	 * @hooked 		now-hiring-single-content 	50
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_post_file( $meta ) {

		include destacados_get_template( 'single-job-meta-file' );

	} // single_post_file()

	/**
	 * Includes the single job post metadata for info
	 *
	 * @hooked 		now-hiring-single-content 	45
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_post_info( $meta ) {

		include destacados_get_template( 'single-job-meta-info' );

	} // single_post_info()

	/**
	 * Includes the single job post metadata for location
	 *
	 * @hooked 		now-hiring-single-content 	25
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_post_location( $meta ) {

		include destacados_get_template( 'single-job-meta-location' );

	} // single_post_location()

	/**
	 * Includes the single job post metadata for responsibilities
	 *
	 * @hooked 		now-hiring-single-content 	20
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_post_responsibilities( $meta ) {

		include destacados_get_template( 'single-job-meta-responsibilities' );

	} // single_post_responsibilities()

	/**
	 * Includes the single job post metadata for skills
	 *
	 * @hooked 		now-hiring-single-content 	35
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_post_skills( $meta ) {

		include destacados_get_template( 'single-job-meta-skills' );

	} // single_post_skills()

	/**
	 * Includes the single job post title
	 *
	 * @hooked 		now-hiring-single-content 		10
	 */
	public function single_post_title() {

		include destacados_get_template( 'single-job-post-title' );

	} // single_post_title()

	public function single_post_how_to_apply() {

		echo apply_filters( 'noticias_howtoapply', '' );

	} // single_post_how_to_apply()

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared using an object of this class.
	 *
	 * @see  	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return 	object 		This class
	 */
	static function this() {

		return self::$_this;

	} // this()
	/**
	 * Cambiar el title del post
	 *	
	 * @since 	1.0.0
	 * @access 	public
	 * @param 	string 		$title 		The post title
	 * @param 	object 		$object 		The post object
	 * @return 	void
	 */
	 public function opl_change_title_post( $title ) {
		 $screen = get_current_screen();		 
		 if ( 'destacado' == $screen->post_type ) {
			 $title = "Escribe aqui el título por favor";
			//  wp_die( "Estamos tratando de cambiar el titulo del post", "title", $title );
		 }		 
		 return $title;
	 }

} // class