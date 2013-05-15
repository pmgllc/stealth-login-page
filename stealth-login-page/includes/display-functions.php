<?php

/*
* Check the URL of the WordPress login page for a specific query string.
*
*/

add_action( 'login_init', 'slp_login_stringcheck' );
function slp_login_stringcheck() {

 	global $slp_options, $custom_url;

 	// set the location a failed attempt goes to
	$redirect = $slp_options['redirect_url'];
	$question = $slp_options['question'];
	$answer = $slp_options['answer'];

	// get the requested URL
	$form_request = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if ( $form_request !== $custom_url ) {
				wp_redirect( esc_url_raw ($redirect), 302 );
			}

}