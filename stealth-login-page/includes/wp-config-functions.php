<?php

add_action( 'login_init', 'slp_wpconfig_login_stringcheck' );
function slp_wpconfig_login_stringcheck() {

 	global $slp_redirect, $slp_question, $slp_answer, $custom_wp_config, $message;

	// get the requested URL
	$form_request_local = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$form_request = $_SERVER['HTTP_REFERER'];

	if ( (is_user_logged_in(TRUE)) ) {
		return;
	}
	elseif (! ( ($form_request_local == $custom_wp_config) || ($form_request == $custom_wp_config) ) ) {

			wp_redirect( esc_url_raw ($slp_redirect), 302 );
			echo $message;
			die;

	}
}