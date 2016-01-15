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
   function setCookie(cname, cvalue) {
        try{
            document.cookie = cname + "=" + cvalue;
        }catch(ex){
            alert('error while set cookie');
        }
    }
    function getCookie(cname) {
       try{
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)===' ') c = c.substring(1);
            if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
        }
      }catch(ex){
            alert('Error occurd while reading cookie');
   		}
    return "";
    }
    var TempId = getCookie("Vb_Id");
    function s4() {
                return Math.floor((1 + Math.random()) * 0x10000)
                        .toString(16)
                        .substring(1);
    }
    if(!TempId){
       
        var randomUserId = function(){
           try{
            return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                    s4() + '-' + s4() + s4() + s4();
            }catch(ex){
                alert('Error while generating Guid');
            }
        };
        
        var TempId = randomUserId();
        
        setCookie("Vb_Id", TempId);
    }
  
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-XXXXXXXX-X', 'auto');
  var randomId = TempId;
  ga('set', 'userId', randomId);
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>

<script type="text/javascript" id="inspectletjs">
window.__insp = window.__insp || [];
__insp.push(['wid', XXXXXXXXX]);
(function() {
    function ldinsp(){
        if(typeof window.__inspld !== "undefined") 
            return; 
        window.__inspld = 1; 
        var insp = document.createElement('script'); 
        insp.type = 'text/javascript'; 
        insp.async = true; 
        insp.id = "inspsync"; 
        insp.src = ('https:' === document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; 
        var x = document.getElementsByTagName('script')[0]; 
        x.parentNode.insertBefore(insp, x); 
    };
setTimeout(ldinsp, 500); 
document.readyState !== "complete" ? (window.attachEvent ? window.attachEvent('onload', ldinsp) : window.addEventListener('load', ldinsp, false)) : ldinsp();
})();
</script>


<?php }
add_action( 'wp_head', 'vibeosys_google_analytics', 10 );
?>