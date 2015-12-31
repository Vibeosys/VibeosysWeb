<?php
/*
Plugin Name: Simple Google Analytics Plugin
Plugin URI: http://vibeosys.com
Description: Adds a Google analytics trascking code to the <head> of your theme, by hooking to wp_head.
Author: Vibeosys
Version: 1.0
 */

function vibeosys_google_analytics() { ?>
<script>
    var random = function(){
        return Math.floor(Math.random() * 3);
    };
     var prefix = ['abc','def','ghi'];
     var middle = ['123','456','768'];
     var suffix = ['rst','uvw','xyz'];
     
     var randomUserId = function(){
         return prefix[random()] + '-' + middle[random()] + '-' + suffix[random()];
     };
     
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71829158-1', 'auto');
  var randomId = randomUserId();
  ga('set', 'userId', randomId);
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>


<?php }
add_action( 'wp_head', 'vibeosys_google_analytics', 10 );
?>