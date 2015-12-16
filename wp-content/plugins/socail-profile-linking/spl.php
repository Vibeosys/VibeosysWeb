<?php
/*
Plugin Name: Social Profile Linking 
Plugin URI: https://wordpress.org/plugins/socail-profile-linking/
Description: Simple & awesome social profile icons and links.
Author: SKS DEV
Author URI: http://sksdev.com
Version: 1.0
License: GNU GPL v2
*/

/**** CONSTANTS ****/

// Plugin Folder Path
if ( !defined( 'SPL_PLUGIN_DIR' ) ) {
	define( 'SPL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL
if ( !defined( 'SPL_PLUGIN_URL' ) ) {
	define( 'SPL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Plugin Version
if ( !defined( 'SPL_VERSION' ) ) {
	define( 'SPL_VERSION', '1.0' );
}


/**** REGISTER & ENQUEUE SCRIPTS/STYLES *****/

function spl_load_scripts() {
	wp_register_style( 'spl-styles',  SPL_PLUGIN_URL . 'includes/css/spl-styles.css', array(  ),SPL_VERSION );

	wp_enqueue_style( 'spl-styles' );	
}
add_action( 'wp_enqueue_scripts', 'spl_load_scripts' );


/*********** Settings Link *******/

function spl_settings_link( $link, $file ) {
	static $this_plugin;
	
	if ( !$this_plugin )
		$this_plugin = plugin_basename( __FILE__ );

	if ( $file == $this_plugin ) {
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=spl_all_options' ) . '">' . __( 'Settings', 'spl' ) . '</a>';
		array_unshift( $link, $settings_link );
	}
	
	return $link;
}
add_filter( 'plugin_action_links', 'spl_settings_link', 10, 2 );


/* Admin Scripts */
include_once( SPL_PLUGIN_DIR . 'includes/admin/settings.php' );

/******* Widget **************/
include_once(SPL_PLUGIN_DIR . 'includes/widget/widget.php' );

/* Front End Scripts */
include_once( SPL_PLUGIN_DIR . 'includes/front-end/template.php' );
include_once( SPL_PLUGIN_DIR . 'includes/front-end/shortcode.php' );