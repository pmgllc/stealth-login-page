<?php

add_action('admin_menu', 'slp_plugin_menu');
function slp_plugin_menu() {
	add_options_page( __( 'Stealth Login Page', 'stealth-login-page' ), __( 'Stealth Login Page', 'stealth-login-page' ), 'manage_options', 'stealth-login-page', 'slp_admin' );
	    return;
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
		<?php slp_credits(); ?>
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

/*-------------------------------------------------------------
 Name:      slp_credits

 Purpose:   Promotional stuff shown throughout the plugin
 Since:		1.1.3
-------------------------------------------------------------*/
function slp_credits() {

	echo '<table class="widefat" style="margin-top: .5em">';

	echo '<thead>';
	echo '<tr valign="top">';
	echo '	<th width="27%">'.__('Your support makes a difference', 'stealth-login-page').'</th>';
	echo '	<th>'.__('Useful links', 'stealth-login-page').'</th>';
	echo '	<th width="35%">'.__('Brought to you by', 'stealth-login-page').'</th>';
	echo '</tr>';
	echo '</thead>';

	echo '<tbody>';
	echo '<tr>';
	echo '<td><ul>';
	echo '	<li><center>'.__('Your generous gift will ensure the continued development of Stealth Login Page and bring more benefits and features.
		Thank you for your consideration!', 'stealth-login-page').'</center></li>';
	echo '	<li><center><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7T2JDSM64HQV8" target="_blank"><img src="http://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" /></a></center></li>';
	echo '	<li>'.__('Like the plugin? Please ', 'stealth-login-page').' <a href="http://wordpress.org/support/view/plugin-reviews/stealth-login-page?rate=5#postform" target="_blank">'.__('rate and review', 'stealth-login-page').'</a> it.</li>';
	echo '</ul></td>';

	echo '<td style="border-left:1px #ddd solid;"><ul>';
	
	echo '	<li>'.__('Find my website at', 'stealth-login-page').' <a href="http://www.petersenmediagroup.com" target="_blank">petersenmediagroup.com</a>.</li>';
	echo '	<li>'.__('Beef up your security even more with', 'stealth-login-page').' <a href="http://wordpress.org/extend/plugins/limit-login-attempts/" target="_blank">'.__('Limit Login Attempts','stealth-login-page').'</a>.</li>';
	echo '	<li>'.__('Learn more about secure WordPress hosting with a ', 'stealth-login-page').' <a href="http://www.petersenmediagroup.com/wordpress-hosting/" target="_blank">'.__('managed host', 'stealth-login-page').'</a>.</li>';
	echo '</ul></td>';

	echo '<td style="border-left:1px #ddd solid;"><ul>';
	echo '	<li><a href="http://www.petersenmediagroup.com" title="Petersen Media Group"><img src="'.WP_CONTENT_URL.'/plugins/stealth-login-page/images/pmg-logo.png" alt="pmg-logo" width="150" height="67" align="left" style="padding: 0 10px 10px 0;" /></a>';
	echo '	<a href="http://www.petersenmediagroup.com" title="Petersen Media Group">Petersen Media Group</a> - '.__('I’m a straight-shooter and listen to what my clients want, run it through my filters, and come up with what they need. Not a "yes man" by any stretch of the imagination, I don’t consider a project a success unless it serves my client well. I have a "do no harm" policy to protect them from mis-information and trying things I’ve already learned about the hard way.', 'stealth-login-page').' '.__('Visit the', 'stealth-login-page').' <a href="http://www.petersenmediagroup.com" target="_blank">'.__('Petersen Media Group', 'stealth-login-page').'</a> '.__('website', 'stealth-login-page').'.</li>';
	echo '</ul></td>';
	echo '</tr>';
	echo '</tbody>';

	echo '</table>';
}