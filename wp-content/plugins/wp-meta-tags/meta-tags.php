<?php
/*
Plugin Name: WP Meta Tags
Plugin URI: http://seo.uk.net/wp-meta-tags/
Description: WP Meta Tags is an advanced plugin for wordpress.
Author: Seo UK Team
Version: 2.0
Author URI: http://seo.uk.net
*/


register_activation_hook( __FILE__,'mtinst_activate');
add_action('admin_init', 'mtredirect_redirect');

function mtinst_activate() { 
add_option('mtredirect_do_activation_redirect', true); wp_redirect('../wp-admin/options-general.php?page=wp-meta-tags/tax-meta.php');
 };
 
function mtredirect_redirect() {
if (get_option('mtredirect_do_activation_redirect', false)) { delete_option('mtredirect_do_activation_redirect'); wp_redirect('../wp-admin/options-general.php?page=wp-meta-tags/tax-meta.php');
}
}

require_once("tax-meta.php");
$TaxonomyMT = new TaxonomyMT();
$TaxonomyMT->wp_taxonomy_meta_tags_hooks();

require_once("wp-meta-tags.php");
$WPPostMetaTags = new WPPostMetaTags();
$WPPostMetaTags->wp_post_meta_tags_hooks();