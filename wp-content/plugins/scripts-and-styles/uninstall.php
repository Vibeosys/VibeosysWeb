<?php
  if ( !defined ( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

  delete_option( 'ScriptsAndStylesBySL_scripts_head_option' );
  delete_option( 'ScriptsAndStylesBySL_scripts_footer_option' );
  delete_option( 'ScriptsAndStylesBySL_styles_option' );
?>