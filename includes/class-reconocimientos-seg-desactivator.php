<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.open-link.net
 * @since      1.0.0
 *
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Reconocimientos_Seg
 * @subpackage Reconocimientos_Seg/includes
 * @author     José Julián Abarca Chávez <julian.abarca@gmail.com>
 */
class Reconocimientos_Seg_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$subscriptor = get_role( 'contributor' );
    $subscriptor_caps = [
        'delete_reconocimientos',
        'edit_reconocimientos',
    ];
	
    foreach( $subscriptor_caps as $cap ) {
        $subscriptor->remove_cap( $cap );
    }
	
    $author = get_role( 'author' );
	
    $author_caps = [
        'delete_reconocimientos',
        'delete_published_reconocimientos',
        'edit_reconocimientos',
        'edit_published_reconocimientos',
        'publish_reconocimientos',
    ];
	
    foreach( $author_caps as $cap ) {
       $author->remove_cap( $cap );
    }

    $editor = get_role( 'editor' );
    $administrator = get_role( 'administrator' );
	
    $editor_and_admin_caps = [
        'delete_reconocimientos',
        'delete_others_reconocimientos',
        'delete_private_reconocimientos',
        'delete_published_reconocimientos',
        'edit_reconocimientos',
        'edit_others_reconocimientos',
        'edit_private_reconocimientos',
        'edit_published_reconocimientos',
        'publish_reconocimientos',
        'read_private_reconocimientos'
    ];
	
    foreach( $editor_and_admin_caps as $cap ) {
        $editor->remove_cap( $cap );
        $administrator->remove_cap( $cap );
    }

	}

}
