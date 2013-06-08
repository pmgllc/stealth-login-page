<?php

add_action( 'login_init', 'slp_settings_login_stringcheck' );
function slp_settings_login_stringcheck() {

 	global $slp_options, $custom_url, $message, $custom_wp_config;

	$form_request_local = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$form_request = $_SERVER['HTTP_REFERER'];
	$custom_url = site_url() . '/wp-login.php?' . $slp_options['question'] . '=' . $slp_options['answer'];

	if ( (is_user_logged_in(TRUE)) ) {
			return;
	}

	elseif (! ( ($form_request_local == $custom_url) || ($form_request == $custom_url) ) ) {
		
			wp_redirect( esc_url_raw ($slp_options['redirect_url']), 302 );
			die;
	}

}