<?php
/**
  Create Shortcode to Display Social Links
  Shortcode is "spl"
*/


// Shortcode
function spl_icons_shortcode( $atts, $content = null ) {
	
	ob_start();
	spl_show_template();
	$output = ob_get_clean();

	return $output;

}
add_shortcode( 'spl', 'spl_icons_shortcode' );