<?php
/*
  Plugin Name: Stealth Login Page
  Plugin URI: http://www.petersenmediagroup.com/plugins/stealth-login-page
  Version: 0.1.0
  Author: Jesse Petersen
  Author URI: http://www.petersenmediagroup.com
  Description: Protect your /wp-admin and wp-login.php pages from being accessed without editing .htaccess
 */
/*
  Copyright 2013 Jesse Petersen

  Thanks to Andrew Norcross (@norcross) for the redirect code (https://gist.github.com/norcross/4342231) and Billy Fairbank (@billyfairbank) for the idea to turn it into a plugin.

  Licenced under the GNU GPL:

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
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

// Includes ------------------------------ //
include('includes/settings-page.php'); // loads the admin settings page


// Global Variables ---------------------- //
$slp_prefix = 'slp_';
$slp_options  = get_option('slp_settings');


    $slp_settings = array(
	'redirect_url'		=> '',
	'question'			=> '',
	'answer'			=> '',
	);

/* Get current option value */
function slp_option($data) {
	global $slp_options;

	if (isset($slp_options[$option_name])) {
		return $slp_options[$option_name];
	} else {
		return null;
	}
}

	$slp_options = get_option('slp_settings');



/*
* Check the URL of the WordPress login page for a specific query string.
*
* assumes login string is
* http://yoursite/wp-login.php?question=answer
*/
add_action( 'login_init', 'slp_login_stringcheck' );
function slp_login_stringcheck() {
 
	// set the location a failed attempt goes to
	$redirect = $slp_settings('redirect_url');
 
	// missing query string all together
	if (!isset ($_GET['question']) )
		wp_redirect( esc_url_raw ($redirect), 302 );
 
	// incorrect value for query string
	if ($_GET['question'] !== 'answer' )
		wp_redirect( esc_url_raw ($redirect), 302 );
 
}