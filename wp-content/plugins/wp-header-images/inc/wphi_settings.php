<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	if ( !current_user_can( 'update_core' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'wp-hi' ) );
	}
// Save the field values
	if ( isset( $_POST['hi_fields_submitted'] ) && $_POST['hi_fields_submitted'] == 'submitted' ) {
		/*foreach ( $_POST as $key => $value ) {		
			if ( get_option( $key ) != $value ) {
				update_option( $key, $value );
			} else {
				add_option( $key, $value, '', 'no' );
			}}*/
			update_option( 'wp_header_images', $_POST['header_images']);
			
		
		
		
	}
	$wp_header_images = get_option( 'wp_header_images');
	
	
	
?>	
<div class="wrap wphi">
	
  <div class="head_area">
	<h2><?php _e( '<span class="dashicons dashicons-welcome-widgets-menus"></span>WP Header Images '.'('.$hi_data['Version'].($hi_pro?') Pro':')'), 'wp-hi' ); ?></h2>
    
    <code class="hide">
    <span class="yellow">&lt;?php do_action('apply_header_images'); ?&gt;</span>
    OR
	<span class="light_blue">&lt;?php do_shortcode('[WP_HEADER_IMAGES]'); ?&gt;</span>
	</code>
	<a>How it works?</a>
    
    </div>
<form method="post" action="">  
<input type="hidden" name="hi_fields_submitted" value="submitted" />
<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'wp-hi' ); ?>" /></p> 
<div class="wphi_settings">



<?php

	$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
	$m = 0;
	$str = 'Click here to set header image';
	foreach ( $menus as $menu ):
	$menu_items = wp_get_nav_menu_items($menu->name);
	
?>
   <h3 data-id="<?php echo $menu->term_id; ?>"><span class="dashicons dashicons-format-aside"></span>Menu - <?php echo $menu->name; ?> (<?php echo count($menu_items); ?>)</h3>
<ul class="menu-class pages_<?php echo $menu->term_id; ?> <?php echo ($m==0?'':'hide'); $m++; ?>"> 
<?php 
	
	if(!empty($menu_items)){
		
		foreach($menu_items as $items){	
		
		$img_id = $wp_header_images[$items->ID];
		$img_url = wp_get_attachment_url( $img_id );	
		
			
?>
	<li>
		<h4><?php echo $items->title; ?></h4>
        <div title="<?php echo $str; ?>" class="banner_wrapper" style="background:url('<?php echo $img_url; ?>'); background-repeat:no-repeat;"><input type="number" value="<?php echo ($img_id>0?$img_id:0); ?>" class="hide hi_vals" name="header_images[<?php echo $items->ID; ?>]" /><?php if($img_id==0): ?><span class="dashicons dashicons-yes hide"></span><label><?php echo $str; ?></label><?php endif; ?></div>
    </li>
<?php			
		}
	}
?>
</ul>
<?php endforeach; ?>
<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'wp-hi' ); ?>" /></p>
</div>
</form>
</div>