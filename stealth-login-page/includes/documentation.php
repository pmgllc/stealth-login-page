<?php

/**
 * Documentation page
 *
 * @since 3.0.0
 */
function slp_documentation() {

	global $slp_options, $custom_url;

	ob_start(); ?>
	<div class="wrap">
	<h2><?php _e( 'Stealth Login Page Documentation', 'stealth-login-page' ); ?></h2>
	
	<h3><?php _e( 'Network (multi-site) Activation', 'stealth-login-page' ); ?></h3>
	<p><?php _e( 'Version 3.0.0 added full multi-site capabilities. Previously, the plugin needed each site to have the settings page filled out and the enable checkbox checked. Now, for v3.0.0 and above, Network Activate the plugin.' ); ?></p>
	<p><?php _e( 'Add the following 3 lines to wp-config.php (right after the $table_prefix variable is good placement) to fully engage the plugin across the network:', 'stealth-login-page' ); ?></p>
	<ul>
		<li>$slp_redirect = "URL"</li>
		<li>$slp_question = "question";</li>
		<li>$slp_answer = "answer";</li>
	</ul>
	<p><?php _e( 'Change each variable to customize the redirect URL, question, and answer settings. If one of the variable entries (not the custom "answer" for each) is missing, the plugin will not activate the redirect function. All three are required to be in the file.', 'stealth-login-page' ); ?></p>
	<p><strong><?php _e( 'Note: Adding these to wp-config.php will override any and all settings on any site (single or multi-site install both) and put that custom URL and redirect URL in play.', 'stealth-login-page' ); ?></strong></p>
	<p><?php _e( 'There is no e-mail URL for the wp-config.php route because (obviously) if you have the ability to put those in place, you also have the ability to change settings or disable it.', 'stealth-login-page' ); ?></p>
	<p><?php _e( 'If you remove the wp-config.php variables, then any site that has the settings page filled out and the "enable" checkbox checked will revert to the settings page behavior.', 'stealth-login-page' ); ?></p>
	<h3><?php _e( 'Lost Password/Logout', 'stealth-login-page' ); ?></h3>
	<p><?php _e( 'Due to the number of support requests involving the lost password function or logouts (or anything else that happens aside from purely attempting to visit the login page from direct navigation), the URL filter that was in place in v2.1.2 has been removed. While it solved many issues, it created more than it solved.', 'stealth-login-page' ); ?></p>
	<h4><?php _e( 'To make up for that...', 'stealth-login-page' ); ?></h4>
	<p><?php _e( 'The redirect function is bypassed if the system recognizes you as being in a logged in session. As of yet, it is not certain how this will behave in 3.6 when a session times out and the pop-up appears, but hopefully nothing will need to be altered.', 'stealth-login-page' ); ?></p>
	<h3><?php _e( 'Donations', 'stealth-login-page' ); ?></h3>
	<p><?php _e( 'An additional 15 hours of programming went into v3.0.0 to enable multi-site, streamline the code, and rebuild the redirect functions from the ground up to eliminate as many potential scenarios as possible.', 'stealth-login-page' ); ?></p>
	<p><?php _e( 'Any donations will allow this to continue to be developed and supported, as there are several new features that should be included, but there is not enough funding to neglect paid projects.', 'stealth-login-page' ); ?></p>
	<p><strong><?php _e('Like the plugin? Please ', 'stealth-login-page'); ?> <a href="http://wordpress.org/support/view/plugin-reviews/stealth-login-page?rate=5#postform" target="_blank"> <?php _e('rate and review', 'stealth-login-page'); ?></a> <?php _e(' it', 'stealth-login-page'); ?>.</strong></p>
	<br />
	<p><center><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7T2JDSM64HQV8" target="_blank"><img src="http://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" /></a></center></p>
	</div><!-- .wrap -->
	<?php
	echo ob_get_clean();
}