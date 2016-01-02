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
    function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
    }
    function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') c = c.substring(1);
        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
    }
    return "";
    }
    var TempId = getCookie("Vb_Id");
    
    if(!TempId){
    var random = function(){
        return Math.floor(Math.random() * 3);
    };
     var prefix = ['abc','def','ghi'];
     var middle = ['123','456','768'];
     var suffix = ['rst','uvw','xyz'];
     
     var randomUserId = function(){
         return prefix[random()] + '-' + middle[random()] + '-' + suffix[random()];
     };
     var TempId = randomUserId();
     setCookie("Vb_Id", TempId);
    }
   
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71829158-1', 'auto');
  var randomId = TempId;
  ga('set', 'userId', randomId);
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>

<!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
window.__insp = window.__insp || [];
__insp.push(['wid', 316412001]);
(function() {
function ldinsp(){if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
setTimeout(ldinsp, 500); document.readyState != "complete" ? (window.attachEvent ? window.attachEvent('onload', ldinsp) : window.addEventListener('load', ldinsp, false)) : ldinsp();
})();
</script>
<!-- End Inspectlet Embed Code -->

<?php }
add_action( 'wp_head', 'vibeosys_google_analytics', 10 );
?>