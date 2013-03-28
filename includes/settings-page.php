<?php

add_action('admin_menu', 'slp_plugin_menu');
function slp_plugin_menu() {
	add_options_page('Stealth Login Page', 'Stealth Login Page', 'manage_options', 'stealth-login-page', 'slp_admin');
	    return;
}

function slp_register_settings() {
	register_setting('slp_settings_group', 'slp_settings');
}
add_action('admin_init', 'slp_register_settings');

function slp_admin() {

	global $slp_settings;

	ob_start(); ?>
	<div class="wrap">
	<h2>Stealth Login Page Options</h2>
	<form method="post" action="options.php">
		
		<?php settings_fields('slp_settings_group'); ?>

	<input type="hidden" name="redirect" value="true" />
		<div class="slp-page">
		<p>Those attempting to gain access to your login form will be automatcally redirected to a customizble URL. Enter that URL below.</p>
		<div class="clear">
			<label class="description" for="slp_settings[redirect_url]"><?php _e('URL to redirect unauthorized attempts to:'); ?></label>
			<input id="slp_settings[redirect_url]" name="slp_settings[redirect_url]" type="text" value="<?php echo $slp_settings['redirect_url']; ?>" size="60" />
		</div>
		<p>The first part of the new URL string to reach your login form is the "question." It is just an arbitrary word or code. Complexity will not matter much at this time.</p>
		<div class="clear">
			<label for="question">
				String used for the "question" (limit: 30 characters):
			</label>
			<input type="text" name="<?php echo SLP_SETTINGS_FIELD; ?>question" value="<?php echo esc_attr( get_option('question', SLP_SETTINGS_FIELD) ); ?>" size="30" />
		</div>
		<p>The second part of the new URL string to reach your login form is the "answer." It is also just an arbitrary word or code.</p>
		<div class="clear">
			<label for="answer">
				String used for the "answer" (limit: 30 characters):
			</label>
			<input type="text" name="answer" value="' . htmlentities($slp_settings['answer']) . '" size="30" />
		</div>
		<input name="update_options" value="Save Settings &raquo;" type="submit" />
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