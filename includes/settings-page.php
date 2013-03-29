<?php

add_action('admin_menu', 'slp_plugin_menu');
function slp_plugin_menu() {
	add_options_page('Stealth Login Page', 'Stealth Login Page', 'manage_options', 'stealth-login-page', 'slp_admin');
	    return;
}

add_action('admin_init', 'slp_register_settings'); // create settings in database
function slp_register_settings() {
	register_setting('slp_settings_group', 'slp_settings');
}

function slp_admin() {

	global $slp_options;

	ob_start(); ?>
	<div class="wrap">
	<h2>Stealth Login Page Options</h2>
	<form method="post" action="options.php">
		
		<?php settings_fields('slp_settings_group'); ?>

		<p>Those attempting to gain access to your login form will be automatcally redirected to a customizble URL. Enter that URL below.</p>
			<label class="description" for="<?php echo $slp_settings[redirect_url]; ?>"><?php _e('URL to redirect unauthorized attempts to', 'slp_domain'); ?>" ></label>
			<input id="<?php echo $slp_settings[redirect_url]; ?>" name="<?php echo $slp_settings[redirect_url]; ?>" type="text" value="<?php echo $slp_settings[redirect_url]; ?>" />

		<p>The first part of the new URL string to reach your login form is the "question." It is just an arbitrary word or code. Complexity will not matter much at this time.</p>
			<label class="description" for="<?php echo $slp_settings[question]; ?>"><?php _e('String used for the "question"', 'slp_domain'); ?></label>
			<input type="text" name="<?php echo $slp_settings[question]; ?>" value="<?php echo $slp_settings[question]; ?>" />

		<p>The second part of the new URL string to reach your login form is the "answer." It is also just an arbitrary word or code.</p>
			<label class="description" for="<?php echo $slp_settings[answer]; ?>"><?php _e('String used for the "answer"', 'slp_domain'); ?></label>
			<input type="text" name="<?php echo $slp_settings[answer]; ?>" value="<?php echo $slp_settings[answer]; ?>"  />
		
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'slp_domain'); ?>" />
		</p>
	</form>
	</div>
	<?php
	echo ob_get_clean();
}