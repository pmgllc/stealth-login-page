<?php

/*
* Check the URL of the WordPress login page for a specific query string.
*
* assumes login string is
* http://yoursite/wp-login.php?question=answer
*/

add_action( 'login_init', 'slp_login_stringcheck' );
function slp_login_stringcheck() {

 	global $slp_options, $custom_url;

 	// set the location a failed attempt goes to
	$redirect = $slp_options['redirect_url'];
	$question = $slp_options['question'];
	$answer = $slp_options['answer'];

	// set the request URL
	$form_request = site_url() . $_SERVER['REQUEST_URI'];
	
if ( $form_request !== $custom_url ) {
	wp_redirect( esc_url_raw ($redirect), 302 );
	exit;
}

if ( ! isset( $_GET[$question] ) )
	wp_redirect( esc_url_raw ($redirect), 302 );


	// check for correct answer
	if ( isset( $_GET[$question ] ) ) {

		if ( $_GET[$question] !== $answer )
			wp_redirect( esc_url_raw ($redirect), 302 );
	}
}