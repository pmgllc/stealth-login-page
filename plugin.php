<?php

/*
  Plugin Name: Stealth Login Page
  Plugin URI: http://www.petersenmediagroup.com/plugins/stealth-login-page
  Version: 0.1.0
  Author: Jesse Petersen
  Author URI: http://www.petersenmediagroup.com
  Description: Protect your /wp-admin and wp-login.php pages from being accessed without editing .htaccess
 */

/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
		wp_die( __( "Sorry, you are not allowed to access this page directly.", 'slp' ) );
}

define( 'SLP_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'SLP_SETTINGS_FIELD', 'slp-settings' );

register_activation_hook( __FILE__, 'slp_activation_check' );

add_action( 'init', 'slp_init', 15 );

/** Loads required files when needed */
function slp_init() {

	/** Load textdomain for translation */
	load_plugin_textdomain( 'slp', false, basename( dirname( __FILE__ ) ) . '/languages/' );

}

function slp_plugin_menu() {
	add_options_page('Stealth Login Page', 'Stealth Login Page', 'manage_options', 'slp-plugin.php', 'slp_admin');
	}

function slp_admin() {
	if ( is_admin () ) {
		require_once(SLP_PLUGIN_DIR . '/admin.php');
	}
}

/*
* Check the URL of the WordPress login page for a specific query string.
*
* assumes login string is
* http://yoursite/wp-login.php?question=answer
*/
add_action( 'login_init', 'slp_login_stringcheck' );
function slp_login_stringcheck() {
 
	// set the location a failed attempt goes to
	$redirect = 'http://youtu.be/dQw4w9WgXcQ?t=2m6s';
 
	// missing query string all together
	if (!isset ($_GET['question']) )
		wp_redirect( esc_url_raw ($redirect), 302 );
 
	// incorrect value for query string
	if ($_GET['question'] !== 'answer' )
		wp_redirect( esc_url_raw ($redirect), 302 );
 
}
