<?php 

/**
 * Widget for the Display Social Links
*/


class spl_widget extends WP_Widget {

// constructor
function spl_widget() {
// Give widget name here
parent::WP_Widget(false, $name = __('Social Profile Linking Widget', 'spl_widget_plugin') );

}


// widget form creation

function form($instance) {

// Check values
if( $instance) {
$title = esc_attr($instance['title']);

      $type = $instance['type'];
    $tumblr = $instance['tumblr'];
     $vimeo = $instance['vimeo'];
  $facebook = $instance['facebook'];
    $flickr = $instance['flickr'];
 $pinterest = $instance['pinterest'];
   $youtube = $instance['youtube'];
   $twitter = $instance['twitter'];
    $github = $instance['github'];
  $dribbble = $instance['dribbble'];
     $gplus = $instance['gplus'];
  $linkedin = $instance['linkedin'];
   $spotify = $instance['spotify'];
 $instagram = $instance['instagram'];
   $behance = $instance['behance'];
      $rdio = $instance['rdio'];
$soundcloud = $instance['soundcloud'];
     $pbchk = $instance['pbchk'];

} else {
     $title = '';
      $type = '';
    $tumblr = '';
     $vimeo = '';
  $facebook = '';
    $flickr = '';
 $pinterest = '';
   $youtube = '';
   $twitter = '';
    $github = '';
  $dribbble = '';
     $gplus = '';
  $linkedin = '';
   $spotify = '';
 $instagram = '';
   $behance = '';
      $rdio = '';
$soundcloud = '';
     $pbchk = '';
}
?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('circle'); ?>"><?php _e('Circle', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('circle'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="circle" <?php if($type == 'circle'){ ?> checked <?php }?> />
<label for="<?php echo $this->get_field_id('square'); ?>"><?php _e('Square', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('square'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="square" <?php if($type == 'square'){ ?> checked <?php }?> />
</p>

<p>
<label for="<?php echo $this->get_field_id('pbchk'); ?>"><?php _e('Developed by Hide Front End', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('pbchk'); ?>" name="<?php echo $this->get_field_name('pbchk'); ?>" 
type="checkbox" <?php if($pbchk){ ?> checked <?php }?> />
</p>


<p>
<label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('Tumblr', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" name="<?php echo $this->get_field_name('tumblr'); ?>" type="text" value="<?php echo $tumblr; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" name="<?php echo $this->get_field_name('vimeo'); ?>" type="text" value="<?php echo $vimeo; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $facebook; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" type="text" value="<?php echo $flickr; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" value="<?php echo $pinterest; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo $youtube; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo $twitter; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('github'); ?>"><?php _e('Github', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('github'); ?>" name="<?php echo $this->get_field_name('github'); ?>" type="text" value="<?php echo $github; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribbble', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" type="text" value="<?php echo $dribbble; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('gplus'); ?>"><?php _e('Google Plus', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('gplus'); ?>" name="<?php echo $this->get_field_name('gplus'); ?>" type="text" value="<?php echo $gplus; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo $linkedin; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('spotify'); ?>"><?php _e('Spotify', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('spotify'); ?>" name="<?php echo $this->get_field_name('spotify'); ?>" type="text" value="<?php echo $spotify; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo $instagram; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" type="text" value="<?php echo $behance; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('rdio'); ?>"><?php _e('Radio', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('rdio'); ?>" name="<?php echo $this->get_field_name('rdio'); ?>" type="text" value="<?php echo $rdio; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('Sound Cloud', 'spl_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" name="<?php echo $this->get_field_name('soundcloud'); ?>" type="text" value="<?php echo $soundcloud; ?>" />
</p>

<p>Developed By: <a href="http://www.sksdev.com">SKSDEV</a></p>

<?php
}


function update($new_instance, $old_instance) {
$instance = $old_instance;

    // Fields
         $instance['title'] = strip_tags($new_instance['title']);
          $instance['type'] = strip_tags($new_instance['type']);
        $instance['tumblr'] = strip_tags($new_instance['tumblr']);
         $instance['vimeo'] = strip_tags($new_instance['vimeo']);
      $instance['facebook'] = strip_tags($new_instance['facebook']);
        $instance['flickr'] = strip_tags($new_instance['flickr']);
     $instance['pinterest'] = strip_tags($new_instance['pinterest']);
       $instance['youtube'] = strip_tags($new_instance['youtube']);
       $instance['twitter'] = strip_tags($new_instance['twitter']);
        $instance['github'] = strip_tags($new_instance['github']);
      $instance['dribbble'] = strip_tags($new_instance['dribbble']);
         $instance['gplus'] = strip_tags($new_instance['gplus']);
      $instance['linkedin'] = strip_tags($new_instance['linkedin']);
       $instance['spotify'] = strip_tags($new_instance['spotify']);
     $instance['instagram'] = strip_tags($new_instance['instagram']);
       $instance['behance'] = strip_tags($new_instance['behance']);
          $instance['rdio'] = strip_tags($new_instance['rdio']);
    $instance['soundcloud'] = strip_tags($new_instance['soundcloud']);
         $instance['pbchk'] = strip_tags($new_instance['pbchk']);;

return $instance;
}


// display widget
function widget($args, $instance) {
extract( $args );

// these are the widget options
$title = apply_filters('widget_title', $instance['title']);

      $type = $instance['type'];
    $tumblr = $instance['tumblr'];
     $vimeo = $instance['vimeo'];
  $facebook = $instance['facebook'];
    $flickr = $instance['flickr'];
 $pinterest = $instance['pinterest'];
   $youtube = $instance['youtube'];
   $twitter = $instance['twitter'];
    $github = $instance['github'];
  $dribbble = $instance['dribbble'];
     $gplus = $instance['gplus'];
  $linkedin = $instance['linkedin'];
   $spotify = $instance['spotify'];
 $instagram = $instance['instagram'];
   $behance = $instance['behance'];
      $rdio = $instance['rdio'];
$soundcloud = $instance['soundcloud'];
    $pbchk = $instance['pbchk'];

echo $before_widget;

// Check if title is set
if ( $title ) {
echo $before_title . $title . $after_title ;
}


ob_start(); ?>

	<div class="splsocial">

		<?php
		if ( ( $facebook or $twitter or $tumblr or $linkedin or $pinterest or $youtube or $vimeo or $instagram or $flickr or $github or $gplus or $dribbble or $behance or $soundcloud or $spotify or $rdio ) != '' ) { ?>


		    <ul class="social <?php 
		    					if ( $type == 'circle' ) {
		    						echo 'circle color';
		    					}
                                elseif($type == 'square')
                                {
                                  echo 'square color'; 
                                }
                             ?>">
		    	<?php if ( $facebook !='' ) { ?>
		    	<li class="facebook">
		    	    <a href="<?php echo $facebook; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $twitter !='' ) { ?>
		    	<li class="twitter">
		    	    <a href="<?php echo $twitter; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $tumblr !='' ) { ?>
		    	<li class="tumblr">
		    	    <a href="<?php echo $tumblr; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $linkedin !='' ) { ?>
		    	<li class="linkedin">
		    	    <a href="<?php echo $linkedin; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $pinterest !='' ) { ?>
		    	<li class="pinterest">
		    	    <a href="<?php echo $pinterest; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $youtube !='' ) { ?>
		    	<li class="youtube">
		    	    <a href="<?php echo $youtube; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $vimeo !='' ) { ?>
		    	 <li class="vimeo">
		    	    <a href="<?php echo $vimeo; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $instagram !='' ) { ?>
		    	<li class="instagram">
		    	    <a href="<?php echo $instagram; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $flickr !='' ) { ?>
		    	 <li class="flickr">
		    	    <a href="<?php echo $flickr; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $github !='' ) { ?>
		    	 <li class="github">
		    	    <a href="<?php echo $github; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $gplus !='' ) { ?>
		    	 <li class="gplus">
		    	    <a href="<?php echo $gplus; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $dribbble !='' ) { ?>
		    	 <li class="dribbble">
		    	    <a href="<?php echo $dribbble; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $behance !='' ) { ?>
		    	<li class="behance">
		    	    <a href="<?php echo $behance; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $soundcloud !='' ) { ?>
		    	<li class="soundcloud">
		    	    <a href="<?php echo $soundcloud; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $spotify !='' ) { ?>
		    	<li class="spotify">
		    	    <a href="<?php echo $spotify; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $rdio !='' ) { ?>
		    	<li class="rdio">
		    	    <a href="<?php echo $rdio; ?>" target="_blank"></a>
		    	</li>
		    	<?php } ?>
	    </ul><!-- social icons -->

		<?php 
        
        }
                else
                {
                  echo '<p>No social links available in widget.</p>';  
                } 
        
        ?>
        
        <?php if ( $pbchk =='' ) { ?>	
    <p>Developed By: <a href="http://www.sksdev.com">SKSDEV</a></p>
    <?php } ?>
	</div><!-- spl -->

	<?php
		echo ob_get_clean();



echo $after_widget;
}

}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("spl_widget");'));


?>