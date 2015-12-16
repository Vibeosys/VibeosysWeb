<?php
/**
 * Register Settings
*/


function spl_options_each( $key ) {

	$social_options = get_option( 'spl_all_options' );

	 /* Define the array of defaults */ 
	$defaults = array(
		'facebook'     	=> 0,
		'twitter'     	=> 0,
		'tumblr'		=> 0,
		'linkedin'		=> 0,
		'pinterest'    	=> 0,
		'youtube'		=> 0,
		'vimeo'			=> 0,
		'instagram'		=> 0,
		'flickr'		=> 0,
		'github'		=> 0,
		'gplus'			=> 0,
		'dribbble'		=> 0,
		'behance'		=> 0,
		'soundcloud'	=> 0,
		'spotify'		=> 0,
		'rdio'			=> 0,
		'type'			=> 0
	);

	$social_options = wp_parse_args( $social_options, $defaults );

	if( isset( $social_options[$key] ) )
		 return $social_options[$key];

	return false;
}


function spl_admin_menu() {

    add_menu_page( 'Social Profile Settings', 'Social Profiles', 'manage_options', 'spl_all_options', 'spl_render_settings_page',
                 SPL_PLUGIN_URL.'/assets/images/social.png' ); 
                 
                 
}
add_action( 'admin_menu', 'spl_admin_menu' );



function spl_render_settings_page( $active_tab = '' ) {
	ob_start(); ?>

	<div class="wrap">
	
		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e( 'Social Profile Linking Settings', 'spl' ); ?>(V.1.0) <p>Developed By: <a href="http://www.sksphpdev.com">SKSPHPDEV</a></p></h2> 


		<?php settings_errors(); ?>
		
		<?php if ( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else {
			$active_tab = 'display_options';
		}

		?>
		
		
		<form method="post" action="options.php">
			<?php
			if ( $active_tab == 'display_options' ) {
				settings_fields( 'spl_all_options' );
				do_settings_sections( 'spl_all_options' );
			}

			submit_button();
	
	echo ob_get_clean();	
}


function spl_initialize_theme_options() {

	// If the theme options don't exist, create them.
	if ( false == get_option( 'spl_all_options' ) )
		add_option( 'spl_all_options' );

	// First, we register a section.
	add_settings_section(
		'general_settings_section',
		__( 'Settings', 'spl' ),
		'spl_general_options_callback',
		'spl_all_options'
	);

	
    add_settings_field(	
		'type',						
		__( 'Type',	'spl' ),						
		'spl_type_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);
    
    
    
    add_settings_field(	
		'facebook',						
		__( 'Facebook',	'spl' ),						
		'spl_facebook_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'twitter',						
		__( 'Twitter', 'spl' ),
		'spl_twitter_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'tumblr',						
		__( 'Tumblr', 'spl' ),
		'spl_tumblr_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'linkedin',						
		__( 'LinkedIn', 'spl' ),
		'spl_linkedin_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);
	
	add_settings_field(	
		'pinterest',						
		__( 'Pinterest', 'spl' ),					
		'spl_pinterest_callback',
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'youtube',						
		__( 'Youtube', 'spl' ),
		'spl_youtube_callback',
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'vimeo',						
		__( 'Vimeo', 'spl' ),
		'spl_vimeo_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'instagram',						
		__( 'Instagram', 'spl' ),
		'spl_instagram_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'flickr',						
		__( 'Flickr', 'spl' ),
		'spl_flickr_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'github',						
		__( 'Github','spl' ),
		'spl_github_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'gplus',						
		__( 'Google+', 'spl' ),
		'spl_gplus_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'dribbble',						
		__( 'Dribbble',	'spl' ),
		'spl_dribbble_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'behance',						
		__( 'Behance', 'spl' ),
		'spl_behance_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'soundcloud',						
		__( 'SoundCloud', 'spl' ),
		'spl_soundcloud_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'spotify',						
		__( 'Spotify', 'spl' ),
		'spl_spotify_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);

	add_settings_field(	
		'rdio',						
		__( 'Rdio', 'spl' ),
		'spl_rdio_callback',	
		'spl_all_options',	
		'general_settings_section'			
	);


	// Finally, we register the fields with WordPress
	register_setting(
		'spl_all_options',
		'spl_all_options',
		'spl_sanitize_social_options'
	);


} // end spl_initialize_theme_options
add_action( 'admin_init', 'spl_initialize_theme_options' );


function spl_general_options_callback() {
	echo '<p>';
	_e( 'Add the links to your social profiles below. Only those that have been filled in will displayed when the social icons are inserted.', 'spl' );
	echo '</p>';
} // end spl_general_options_callback



// Type Callback
function spl_type_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['type'] ) ) {
		$url = $options['type'];
	} // end if
	
	// Render the output
	echo '<input type="radio" id="type" name="spl_all_options[type]" value="circle"'; if($url == 'http://circle'){ echo 'checked';} echo ' /> Circle &nbsp;';
    // Render the output
	echo ' <input type="radio" id="type" name="spl_all_options[type]" value="square"';if($url == 'http://square'){ echo 'checked';} echo ' /> Square';
	
} // end spl_type_callback



// Facebook Callback
function spl_facebook_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['facebook'] ) ) {
		$url = esc_url( $options['facebook'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="facebook" name="spl_all_options[facebook]" value="' . $url . '" />';
	
} // end spl_facebook_callback


// Twitter Callback
function spl_twitter_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['twitter'] ) ) {
		$url = esc_url( $options['twitter'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="twitter" name="spl_all_options[twitter]" value="' . $url . '" />';
	
} // end spl_twitter_callback


// Tumblr Callback
function spl_tumblr_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['tumblr'] ) ) {
		$url = esc_url( $options['tumblr'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="tumblr" name="spl_all_options[tumblr]" value="' . $url . '" />';
	
} // end spl_tumblr_callback


// LinkedIn Callback
function spl_linkedin_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['linkedin'] ) ) {
		$url = esc_url( $options['linkedin'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="linkedin" name="spl_all_options[linkedin]" value="' . $url . '" />';
	
} // end spl_linkedin_callback


// Pinterest Callback
function spl_pinterest_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['pinterest'] ) ) {
		$url = esc_url( $options['pinterest'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="pinterest" name="spl_all_options[pinterest]" value="' . $url . '" />';
	
} // end spl_pinterest_callback


// Youtube Callback
function spl_youtube_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['youtube'] ) ) {
		$url = esc_url( $options['youtube'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="youtube" name="spl_all_options[youtube]" value="' . $url . '" />';
	
} // end spl_youtube_callback


// Vimeo Callback
function spl_vimeo_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['vimeo'] ) ) {
		$url = esc_url( $options['vimeo'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="vimeo" name="spl_all_options[vimeo]" value="' . $url . '" />';
	
} // end spl_vimeo_callback


// Instagram Callback
function spl_instagram_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['instagram'] ) ) {
		$url = esc_url( $options['instagram'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="instagram" name="spl_all_options[instagram]" value="' . $url . '" />';
	
} // end spl_instagram_callback


// Flickr Callback
function spl_flickr_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['flickr'] ) ) {
		$url = esc_url( $options['flickr'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="flickr" name="spl_all_options[flickr]" value="' . $url . '" />';
	
} // end spl_flickr_callback


// Github Callback
function spl_github_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['github'] ) ) {
		$url = esc_url( $options['github'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="github" name="spl_all_options[github]" value="' . $url . '" />';
	
} // end spl_github_callback


// Google+ Callback
function spl_gplus_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['gplus'] ) ) {
		$url = esc_url( $options['gplus'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="gplus" name="spl_all_options[gplus]" value="' . $url . '" />';
	
} // end spl_gplus_callback


// Dribbble Callback
function spl_dribbble_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['dribbble'] ) ) {
		$url = esc_url( $options['dribbble'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="dribbble" name="spl_all_options[dribbble]" value="' . $url . '" />';
	
} // end spl_dribbble_callback


// Behance Callback
function spl_behance_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['behance'] ) ) {
		$url = esc_url( $options['behance'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="behance" name="spl_all_options[behance]" value="' . $url . '" />';
	
} // end spl_behance_callback


// SoundCloud Callback
function spl_soundcloud_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['soundcloud'] ) ) {
		$url = esc_url( $options['soundcloud'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="soundcloud" name="spl_all_options[soundcloud]" value="' . $url . '" />';
	
} // end spl_soundcloud_callback


// Spotify Callback
function spl_spotify_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['spotify'] ) ) {
		$url = esc_url( $options['spotify'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="spotify" name="spl_all_options[spotify]" value="' . $url . '" />';
	
} // end spl_spotify_callback


// Rdio Callback
function spl_rdio_callback() {
	
	$options = get_option( 'spl_all_options' );
	$url = '';

	if( isset( $options['rdio'] ) ) {
		$url = esc_url( $options['rdio'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="rdio" name="spl_all_options[rdio]" value="' . $url . '" />';
	
} // end spl_rdio_callback



/**** Setting Options ***/ 

function spl_sanitize_social_options( $input ) {
	
	// Define the array for the updated options
	$output = array();

	// Loop through each of the options sanitizing the data
	foreach( $input as $key => $val ) {
	
		if( isset ( $input[$key] ) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		} // end if	
	
	} // end foreach
	
	// Return the new collection
	return apply_filters( 'spl_sanitize_social_options', $output, $input );

} // end sandbox_theme_sanitize_social_options