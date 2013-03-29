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

		<h4>Enable/Disable Stealth Login Page</h4>
		
		<input id="slp_settings[enable]" type="checkbox" name="slp_settings[enable]" value="1" <?php checked(1, $slp_options['enable']); ?> />
		
		<label class="description" for="slp_settings[enable]"><?php _e('Enable Stealth Mode', 'slp_domain'); ?></label>

		<p>Those attempting to gain access to your login form will be automatcally redirected to a customizble URL. Enter that URL below.</p>

			<label class="description" for="slp_settings[redirect_url]"><?php _e('URL to redirect unauthorized attempts to', 'slp_domain'); ?></label>

			<input type="text" id="slp_settings[redirect_url]" name="slp_settings[redirect_url]" value="<?php echo $slp_options[redirect_url]; ?>" />

		<p>The first part of the new URL string to reach your login form is the "question." It is just an arbitrary word or code. Complexity will not matter much at this time.</p>

			<label class="description" for="slp_settings[question]"><?php _e('String used for the "question"', 'slp_domain'); ?></label>

			<input type="text" id="slp_settings[question]" name="slp_settings[question]" value="<?php echo $slp_options[question]; ?>" />

		<p>The second part of the new URL string to reach your login form is the "answer." It is also just an arbitrary word or code.</p>

			<label class="description" for="slp_settings[answer]"><?php _e('String used for the "answer"', 'slp_domain'); ?></label>

			<input type="text" id="slp_settings[answer]" name="slp_settings[answer]" value="<?php echo $slp_options[answer]; ?>"  />
		
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'slp_domain'); ?>" />
		</p>
	</form>
	</div>
	<?php
	echo ob_get_clean();
}