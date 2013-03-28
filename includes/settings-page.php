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

	global $slp_settings;

	ob_start(); ?>
	<div class="wrap">
	<h2>Stealth Login Page Options</h2>
	<form method="post" action="options.php">
		
		<?php settings_fields('slp_settings_group'); ?>

		<div class="slp-page">
		<p>Those attempting to gain access to your login form will be automatcally redirected to a customizble URL. Enter that URL below.</p>
		<div class="clear">
			<label class="description" for="slp_settings[redirect_url]"><?php _e('URL to redirect unauthorized attempts to:', 'slp_domain'); ?></label>
			<input id="slp_settings[redirect_url]" name="slp_settings[redirect_url]" type="text" value="<?php echo $slp_settings['redirect_url']; ?>" />
		</div>
		<p>The first part of the new URL string to reach your login form is the "question." It is just an arbitrary word or code. Complexity will not matter much at this time.</p>
		<div class="clear">
			<label class="description" for="<?php echo $slp_settings['question']; ?>"><?php _e('String used for the "question"', 'slp_domain'); ?></label>
			<input type="text" name="<?php echo $slp_settings['question']; ?>" value="<?php echo $slp_settings['question']; ?>" />
		</div>
		<p>The second part of the new URL string to reach your login form is the "answer." It is also just an arbitrary word or code.</p>
		<div class="clear">
			<label class="description" for="<?php echo $slp_settings['answer']; ?>"><?php _e('String used for the "answer"', 'slp_domain'); ?></label>
			<input type="text" name="<?php echo $slp_settings['answer']; ?>" value="<?php echo $slp_settings['answer']; ?>"  />
		</div>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'slp_domain'); ?>" />
		</p>
		</div>
	</form>
	<style type="text/css">
	div.slp-page {
		max-width: 600px;
		min-width: 50%;
	}
	.slp-page div.clear {
		clear: both;
	}
	.slp-page p {
		font-size: 1.1em;
		margin-bottom: 1em;
		line-spacing: 1.4em;
	}
	.slp-page input[type="submit"],
	.slp-page input[type="button"] {
		margin-top: 1em;
	}
	</style>
	</div>
	<?php
	echo ob_get_clean();
}