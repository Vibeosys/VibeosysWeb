<?php
/*
 +-+-+-+-+-+-+-+ +-+-+-+ +-+-+-+-+-+-+
 |S|c|r|i|p|t|s| |a|n|d| |S|t|y|l|e|s|
 +-+-+-+-+-+-+-+ +-+-+-+ +-+-+-+-+-+-+

  Plugin Name: Scripts and Styles
  Plugin URI: http://sethspopupcreator.com/scripts-and-styles-wordpress-plugin
  Description: Add arbitrary JavaScript and CSS files to your WordPress site. Encourages best practices for site performance and compatibility.
  Version: 1.0.12
  Author: Seth Livingston
  Author URI: http://sethspopupcreator.com
  License: Public Domain
  @since 3.0.1
*/

class ScriptsAndStylesBySL {

  private static $TITLE = 'Scripts and Styles';
  private static $ID = 'ScriptsAndStylesBySL';
  private static $SLUG = 'scripts-and-styles';

  private static $SCRIPTS_HEADER_OPTION = '_scripts_head_option';
  private static $SCRIPTS_FOOTER_OPTION = '_scripts_footer_option';
  private static $STYLES_OPTION= '_styles_option';

  private static $ENTRIES_RE = "/(?:\\(([\\w_-]*)\\))?(.*)/";

  private static $name_index = 0;

  public static function register() {
    register_setting( ScriptsAndStylesBySL::$ID.'_options', ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_HEADER_OPTION );
    register_setting( ScriptsAndStylesBySL::$ID.'_options', ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_FOOTER_OPTION );
    register_setting( ScriptsAndStylesBySL::$ID.'_options', ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$STYLES_OPTION );
  }

  public static function menu() {
    add_options_page(
      ScriptsAndStylesBySL::$TITLE,
      ScriptsAndStylesBySL::$TITLE,
      'manage_options',
      ScriptsAndStylesBySL::$ID.'_options',
      array( 'ScriptsAndStylesBySL', 'options_page' ) );
  }

  public static function options_page() {
    if ( !current_user_can( 'manage_options' ) ) {
      wp_die( __('You do not have permission to access this page.' ) );
    }
    $footer_scripts = trim( get_option( ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_FOOTER_OPTION ) );
    $header_scripts = trim( get_option( ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_HEADER_OPTION ) );
    $styles = trim( get_option( ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$STYLES_OPTION ) );
    ?>
      <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Scripts and Styles</h2>
        <p>Use these settings to inject external JavaScript files and CSS files into your web site.</p>
        <form action="options.php" method="post">
          <?php settings_fields( ScriptsAndStylesBySL::$ID.'_options' ); ?>
          <table class="form-table">
            <tbody>
              <tr>
                <th scope="row">Footer Scripts</th>
                <td>
                  <fieldset>
                    <p><textarea
                      placeholder="https://my-cdn/my-amazing-script.js"
                      name="<?php echo ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_FOOTER_OPTION; ?>"
                      id="<?php echo ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_FOOTER_OPTION; ?>"
                      class="large-text code" rows="4"><?php if ( strlen( $footer_scripts ) ) { echo $footer_scripts; } ?></textarea></p>
                    <p class="description">Scripts and Styles will create &lt;script&gt; tags for these URLs<sup>*</sup>
                      and add them to the footer so your page will load faster. This is the preferred way to load
                      JavaScript files.</p>
                  </fieldset>
                </td>
              </tr>
              <tr>
                <th scope="row">Header Scripts</th>
                <td>
                  <fieldset>
                    <p><textarea
                      placeholder="https://my-cdn/my-amazing-script.js"
                      name="<?php echo ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_HEADER_OPTION; ?>"
                      id="<?php echo ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_HEADER_OPTION; ?>"
                      class="large-text code" rows="4"><?php if ( strlen( $header_scripts ) ) { echo $header_scripts; } ?></textarea></p>
                    <p class="description">Scripts and Styles will create &lt;script&gt; tags for these URLs<sup>*</sup>
                      and add them to the header. Your page will load a little slower, but some scripts (and some themes)
                      only work when injected in the header.</p>
                  </fieldset>
                </td>
              </tr>
              <tr>
                <th scope="row">Styles</th>
                <td>
                  <fieldset>
                    <p><textarea
                      placeholder="https://my-cdn/my-beautiful-styles.css"
                      name="<?php echo ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$STYLES_OPTION; ?>"
                      id="<?php echo ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$STYLES_OPTION; ?>"
                      class="large-text code" rows="4"><?php if ( strlen( $styles ) ) { echo $styles; } ?></textarea></p>
                    <p class="description">Scripts and Styles will create &lt;link&gt; tags for these URLs<sup>*</sup>
                      and add them to the header.</p>
                  </fieldset>
                </td>
              </tr>
              <tr>
                <th scope="row">&nbsp;</th>
                <td>
                  <p class="description"><sup>*</sup> For security and compatibility, always prefer URLs that start
                    with <code>https://</code> (HTTPS).</p>
                </td>
            </tbody>
          </table>
          <?php submit_button(); ?>
        </form>
      </div>
    <?php
  }

  public static function enqueue() {
    $styles_option = get_option( ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$STYLES_OPTION, '' );
    $footer_scripts_option = get_option( ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_FOOTER_OPTION, '' );
    $header_scripts_option = get_option( ScriptsAndStylesBySL::$ID.ScriptsAndStylesBySL::$SCRIPTS_HEADER_OPTION, '' );

    if ( strlen( $styles_option ) > 0 ) {
      ScriptsAndStylesBySL::enqueue_styles( $styles_option );
    }
    if ( strlen( $footer_scripts_option ) > 0 ) {
      ScriptsAndStylesBySL::enqueue_scripts( $footer_scripts_option, true );
    }
    if ( strlen( $header_scripts_option ) > 0 ) {
      ScriptsAndStylesBySL::enqueue_scripts( $header_scripts_option, false );
    }
  }

  private static function extract_entries( $option ) {
    $lines = explode( PHP_EOL, $option );
    $matches = array();
    $entries = array();

    if ( WP_DEBUG ) {
      echo "<!-- Scripts and Styles: processing ".count( $lines )." URLs:\n";
      print_r( $lines );
      echo "-->";
    }

    foreach ( $lines as $line ) {
      if ( preg_match(ScriptsAndStylesBySL::$ENTRIES_RE, $line, $matches) ) {
        if ( count( $matches ) == 3 && strlen( $matches[1] ) > 0 ) {
          array_push( $entries, array( array( $matches[1] ), $matches[2] ) );
        } else {
          array_push( $entries, array( array() , $matches[2] ) );
        }
      }
    }

    return $entries;
  }

  private static function enqueue_styles( $option ) {
    $styles = ScriptsAndStylesBySL::extract_entries( $option );

    for ( $i = 0; $i < count( $styles ); ++$i ) {
      $uri = $styles[$i][1];
      $dep = count( $styles[$i][0] ) > 0 ? $styles[$i][0] : false;
      $name = ScriptsAndStylesBySL::$SLUG . '-' . ++ScriptsAndStylesBySL::$name_index;
      $result = wp_enqueue_style( $name, $uri );
    }
  }

  private static function enqueue_scripts( $option, $footer ) {
    $scripts = ScriptsAndStylesBySL::extract_entries( $option );

    for ( $i = 0; $i < count( $scripts ); ++$i ) {
      $uri = $scripts[$i][1];
      $dep = count( $scripts[$i][0] ) > 0 ? $scripts[$i][0] : false;
      $name = ScriptsAndStylesBySL::$SLUG . '-' . ++ScriptsAndStylesBySL::$name_index;
      $result = wp_enqueue_script( $name, $uri, $dep, false, $footer );
    }
  }
}

if ( is_admin() ) {
    add_action( 'admin_init', array( 'ScriptsAndStylesBySL', 'register' ) );
    add_action( 'admin_menu', array( 'ScriptsAndStylesBySL', 'menu' ) );
}

add_action( 'wp_enqueue_scripts', array( 'ScriptsAndStylesBySL', 'enqueue' ) );
