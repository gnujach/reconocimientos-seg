<?php

/**
 * Provides the markup for any text field
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Noticias
 * @subpackage Noticias/admin/partials
 */
//  wp_die(print_r($params));
// wp_die( var_dump($this->meta));
wp_nonce_field( $this->plugin_name, 'reconocimiento_usuario_nonce' );
$atts 					= array();
$atts['id'] 			= 'reconocimiento_usuario';
$atts['class'] 			= 'widefat';
$atts['description'] 	= $params['args']['description'];
$atts['label'] 			= 'Nombre de usuario';
$atts['name'] 			= $params['args']['name'];
// $atts['placeholder'] 	= 'Nombre de empresa';
$atts['type'] 			= $params['args']['type'];
$atts['size'] 			= $params['args']['size'] ;
if ( ! empty( $this->meta[$atts['id']][0] ) ) {
	$atts['value'] = $this->meta[$atts['id']][0];
} else {
	$atts['value'] = $params['args']['value'];
}
if ( ! empty( $params['label'] ) ) {

	?><label for="<?php echo esc_attr( $params['id'] ); ?>"><?php esc_html_e( $params['label'], 'now-hiring' ); ?>: </label><?php

}
?>
<div class="my_ajax">
<?php
if ( ! empty( $atts['label'] ) ) {

	?><!--<label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'now-hiring' ); ?>: </label>--><?php

}

?><input	
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	size="<?php echo esc_attr( $atts['size'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>"
	/><?php

if ( ! empty( $atts['description'] ) ) {

	?><!--<span class="description"><?php esc_html_e( $atts['description'], 'now-hiring' ); ?></span>--><?php

}?>
<button id="btn1">ClickMe</button>

<label for="autocomplete">autocomplete</label><input type="text" id="autocomplete" size="32">
<button id="btn2">ClickMe</button>
</div>