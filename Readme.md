=== Stealth Login Page ===
Contributors: peterdog
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7T2JDSM64HQV8
Tags: login, wp-admin, redirect, security, 302
Requires at least: 3.4.2
Tested up to: 3.5.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Protect your /wp-admin and wp-login.php pages from being accessed without editing .htaccess

== Description ==

Protect your /wp-admin and wp-login.php pages from being accessed without editing .htaccess files. Without locking down access via IP address or file permissions, this plugin creates a secret, customizable, login URL string. Those attempting to gain access to your login form will be automatcally redirected to a customizble URL.

== Installation ==

1. Upload contents of the directory to /wp-content/plugins/ (or use the automatic installer)
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the settings to create the secret URL string and redirect URL.
1. Verify it works by going to your default login form URL.

== Frequently Asked Questions ==

= Does this work on MU sites? =

Absolutely.

= Are both the redirected folder /wp-admin and the page wp-login.php secured? =

Yes, as long as you are not actively logged into the site on that computer. You may enter your dashboard normally if you're in an active session. Once the session expires, you're further protected by it automatically redirecting rather than gaining access to the login form since WordPress redirects session timeouts to wp-login.php, unaware of the new URL string.

== Screenshots ==

1. The options page.

See more [examples](http://www.petersenmediagroup.com/plugins/stealth-login-page/ "Stealth Login Page Plugin URI") here.

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
Initial stable release. Please update from alpha now.
