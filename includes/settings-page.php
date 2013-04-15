<?php

add_action('admin_menu', 'slp_plugin_menu');
function slp_plugin_menu() {
	add_options_page( __( 'Stealth Login Page', 'stealth-login-page' ), __( 'Stealth Login Page', 'stealth-login-page' ), 'manage_options', 'stealth-login-page', 'slp_admin' );
	    return;
}

// Add settings link on plugin page
//add_filter( 'plugin_action_links_stealth_login_page', 'slp_plugin_settings_link//' );
//function slp_plugin_settings_link($links) { 
//	wp_die('Foo!');
//	$settings_link = '<a href="'. admin_url('options-general.php?page=stealth-//login-page') .'">' . __('Settings') . '</a>';
//	array_unshift($links, $settings_link); 
//	return $links; 
//}


add_filter( 'plugin_action_links', 'slp_action_links', 10, 2 );
function slp_action_links( $links, $file ) {
    if ( $file == dirname( plugin_dir_path(__FILE__) . '/plugin.php' ) ) {
        $links[] = '<a href="options-general.php?page=stealth-login-page">' . esc_html__( 'Settings', 'stealth-login-page' ) .' </a>';
    }

    return $links;
}


add_action('admin_init', 'slp_register_settings'); // create settings in database
function slp_register_settings() {
	register_setting('slp_settings_group', 'slp_settings');
}

add_action( 'admin_init', 'slp_email_admin' );
function slp_email_admin() {
	global $slp_options;
	if ( isset( $slp_options['enable'] ) && $slp_options['question'] && $slp_options['answer']  && isset ( $_POST['email-admin'] ) && current_user_can( 'manage_options' ) ) {
		$to = get_bloginfo( 'admin_email' );
		$subject = sprintf( __( 'Custom login URL for %s', 'stealth-login-page' ), get_bloginfo( 'name' ) );
		$message = sprintf( __( 'Your custom login URL for %1$s is %2$s', 'stealth-login-page' ), get_bloginfo( 'name' ), wp_login_url() . '?' . $slp_options['question'] . '=' . $slp_options['answer'] );
		wp_mail( $to, $subject, $message );
	}
}

function slp_admin() {

	global $slp_options;

	ob_start(); ?>
	<div class="wrap">
	<h2><?php _e( 'Stealth Login Page Options', 'stealth-login-page' ); ?></h2>
	<form method="post" action="options.php">

		<?php settings_fields('slp_settings_group'); ?>

		<h4><?php _e( 'Enable/Disable Stealth Login Page', 'stealth-login-page' ); ?></h4>

		<input id="slp_settings[enable]" type="checkbox" name="slp_settings[enable]" value="1" <?php checked(1, isset( $slp_options['enable'] ) ); ?> />

		<label class="description" for="slp_settings[enable]"><?php _e( 'Enable Stealth Mode', 'stealth-login-page' ); ?></label>

		<p><?php _e( 'Those attempting to gain access to your login form will be automatcally redirected to a customizble URL. Enter that URL below.', 'stealth-login-page' ); ?></p>

			<label class="description" for="slp_settings[redirect_url]"><?php _e( 'URL to redirect unauthorized attempts to', 'stealth-login-page' ); ?></label>

			<input type="text" id="slp_settings[redirect_url]" name="slp_settings[redirect_url]" value="<?php echo $slp_options['redirect_url']; ?>" />

		<p><?php _e( 'The first part of the new URL string to reach your login form is the "question." It is just an arbitrary word or code. Complexity will not matter much at this time.', 'stealth-login-page' ); ?></p>

			<label class="description" for="slp_settings[question]"><?php _e( 'String used for the "question"', 'stealth-login-page' ); ?></label>

			<input type="text" id="slp_settings[question]" name="slp_settings[question]" value="<?php echo $slp_options['question']; ?>" />

		<p><?php _e( 'The second part of the new URL string to reach your login form is the "answer." It is also just an arbitrary word or code.', 'stealth-login-page' ); ?></p>

			<label class="description" for="slp_settings[answer]"><?php _e( 'String used for the "answer"', 'stealth-login-page' ); ?></label>

			<input type="text" id="slp_settings[answer]" name="slp_settings[answer]" value="<?php echo $slp_options['answer']; ?>"  />

	<p>
		<input id="email-admin" type="checkbox" name="email-admin" value="0" />

		<label class="description" for="email-admin"><?php _e( 'Email login URL to admin', 'stealth-login-page' ); ?></label>
	</p>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'stealth-login-page' ); ?>" />
		</p>
	</form>

	<?php if ( isset( $slp_options['enable'] ) && $slp_options['question'] && $slp_options['answer'] ) { ?>
		<div class="custom-url">
			<p><?php _e( 'Your custom login URL is:', 'stealth-login-page' ); ?> <a href="<?php echo wp_login_url() . '?' . $slp_options['question'] . '=' . $slp_options['answer'] ?>"> <?php echo wp_login_url() . '?' . $slp_options['question'] . '=' . $slp_options['answer']; ?></a></p>
		</div>
		<?php } 
	
		?>

	</div><!-- .wrap -->
	<?php
	echo ob_get_clean();
}