<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the archive loop.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Now_Hiring
 * @subpackage Now_Hiring/public/partials
 */

/**
 * now-hiring-before-loop hook
 *
 * @hooked 		list_wrap_start 		10
 */
 
do_action( 'reconocimientos-before-loop' );
// wp_die( print_r($items) );
foreach ( $items as $item ) {
	// $item->pos = $opcount++;
	$meta = get_post_custom( $item->ID );
	// print_r($item);
	// exit();
	echo "<div class=\"row\">";
		echo "<div class=\"col-md-1\">";
		echo "</div>";
		echo "<div class=\"col-md-10 post\">";
			echo "<div class=\"row\">";
				echo "<div class=\"col-md-1\">";
					echo "<img src=\"".get_avatar_url( $meta['reconocimiento_usuario'][0] )."\" class=\"img-responsive img-circle\">";
				echo "</div>";
				echo "<div class=\"col-md-10 \">";
					echo "<div class=\"post-contents\">";
						echo $item->post_excerpt;
						// get_the_excerpt( $item->ID );
					echo "</div>";					
				echo "</div>";
				echo "<div class=\"col-md-1\">";
					echo "<img src=\"".get_avatar_url( $item->post_author )."\" class=\"img-responsive img-circle\">";
				echo "</div>";
			echo "</div>";	
			echo "<div class=\"row\">";
				echo "<div class=\"col-md-6\">";					 
				echo "</div>";
				echo "<div class=\"col-md-6\">";
					echo "<div class=\"post-footer text-right\">";
						// $date = new DateTime($item->post_date);
						if (false === get_post_type_archive_link( 'reconocimiento' ) )
								echo "Mi link: ";
						echo the_permalink( $item->ID );
						echo '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><a href=' . esc_url( get_permalink( $item->ID ) ) . ' rel=\"bookmark\">' . esc_attr( get_the_date( 'F j, Y, g:i a', $item->ID )) . '</a>';
						// echo "<p>".$date->format('j F, Y, g:i a')."</p>";
					echo "</div>";
				echo  "</div>";
			echo "</div>";
		echo "</div>";		
		echo "<div class=\"col-md-1\">";
		echo "</div>";
	echo "</div>";
} // foreach
?>