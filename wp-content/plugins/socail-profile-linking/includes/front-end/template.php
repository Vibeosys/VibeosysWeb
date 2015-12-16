<?php

/**
 * Create Template Structure for the Display of Social Links
*/

function spl_show_template() {
	
	ob_start(); ?>

	<div class="splsocial">

		<?php

		// URL in a variable.
	    $facebook = spl_options_each( 'facebook' );
	    $twitter = spl_options_each( 'twitter' );
	    $tumblr = spl_options_each( 'tumblr' );
	    $linkedin = spl_options_each( 'linkedin' );
	    $pinterest = spl_options_each( 'pinterest' );
	    $youtube = spl_options_each( 'youtube' );
	    $vimeo = spl_options_each( 'vimeo' );
	    $instagram = spl_options_each( 'instagram' );
	    $flickr = spl_options_each( 'flickr' );
	    $github = spl_options_each( 'github' );
	    $gplus = spl_options_each( 'gplus' );
	    $dribbble = spl_options_each( 'dribbble' );
	    $behance = spl_options_each( 'behance' );
	    $soundcloud = spl_options_each( 'soundcloud' );
	    $spotify = spl_options_each( 'spotify' );
	    $rdio = spl_options_each( 'rdio' );

	    //choose the Social icon styles. 
	    $type = spl_options_each( 'type' );

		?>

		<?php
		if ( ( $facebook or $twitter or $tumblr or $linkedin or $pinterest or $youtube or $vimeo or $instagram or $flickr or $github or $gplus or $dribbble or $behance or $soundcloud or $spotify or $rdio ) != '' ) { ?>


		    <ul class="social <?php 
		    					if ( $type == 'http://circle' ) {
		    						echo 'circle color';
		    					} elseif ( $type == 'http://square' ) {
		    						echo 'square color';
		    					} ?>">
		    	<?php if ( $facebook !='' ) { ?>
		    	<li class="facebook">
		    	    <a href="<?php echo $facebook; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $twitter !='' ) { ?>
		    	<li class="twitter">
		    	    <a href="<?php echo $twitter; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $tumblr !='' ) { ?>
		    	<li class="tumblr">
		    	    <a href="<?php echo $tumblr; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $linkedin !='' ) { ?>
		    	<li class="linkedin">
		    	    <a href="<?php echo $linkedin; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $pinterest !='' ) { ?>
		    	<li class="pinterest">
		    	    <a href="<?php echo $pinterest; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $youtube !='' ) { ?>
		    	<li class="youtube">
		    	    <a href="<?php echo $youtube; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $vimeo !='' ) { ?>
		    	 <li class="vimeo">
		    	    <a href="<?php echo $vimeo; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $instagram !='' ) { ?>
		    	<li class="instagram">
		    	    <a href="<?php echo $instagram; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $flickr !='' ) { ?>
		    	 <li class="flickr">
		    	    <a href="<?php echo $flickr; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $github !='' ) { ?>
		    	 <li class="github">
		    	    <a href="<?php echo $github; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $gplus !='' ) { ?>
		    	 <li class="gplus">
		    	    <a href="<?php echo $gplus; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $dribbble !='' ) { ?>
		    	 <li class="dribbble">
		    	    <a href="<?php echo $dribbble; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $behance !='' ) { ?>
		    	<li class="behance">
		    	    <a href="<?php echo $behance; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $soundcloud !='' ) { ?>
		    	<li class="soundcloud">
		    	    <a href="<?php echo $soundcloud; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $spotify !='' ) { ?>
		    	<li class="spotify">
		    	    <a href="<?php echo $spotify; ?>"></a>
		    	</li>
		    	<?php } ?>
		    	<?php if ( $rdio !='' ) { ?>
		    	<li class="rdio">
		    	    <a href="<?php echo $rdio; ?>"></a>
		    	</li>
		    	<?php } ?>
	    </ul><!-- social icons -->

		<?php
        
         }
                 else
                {
                  echo '<p>No social links available in setting options.</p>';  
                } 
        
         ?>	
    
	</div><!-- spl -->

	<?php
		echo ob_get_clean();

}