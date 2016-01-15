<?php 
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*



Plugin Name: WP Header Images



Plugin URI: http://www.websitedesignwebsitedevelopment.com/wordpress/plugins/wp-header-images



Description: WP Header Images is a great plugin to implement custom header images for each page. You can set images easily and later can manage CSS from your theme.



Version: 1.0.1



Author: Fahad Mahmood 



Author URI: http://www.androidbubbles.com



License: GPL3



*/ 


        
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        

	global $hi_premium_link, $wphi_dir, $hi_pro, $hi_data;
	$wphi_dir = plugin_dir_path( __FILE__ );
	$rendered = FALSE;
	$hi_pro = file_exists($wphi_dir.'inc/functions_extended.php');
	$hi_data = get_plugin_data(__FILE__);
	$hi_premium_link = 'http://shop.androidbubbles.com/product/wp-header-images-pro';
	

	
	$hi_data = get_plugin_data(__FILE__);
	
	
	
	include('inc/functions.php');
        
	

	add_action( 'admin_enqueue_scripts', 'register_hi_scripts' );
	add_action( 'wp_enqueue_scripts', 'register_hi_scripts' );
	

	
	if(is_admin()){
		add_action( 'admin_menu', 'wphi_menu' );		
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'wphi_plugin_links' );	
		
	}else{
		
	
		add_action( 'wp_footer', 'wp_header_images' );
		add_action('apply_header_images', 'get_header_images');		
		add_shortcode('WP_HEADER_IMAGES', 'get_header_images');		
		
	}


	