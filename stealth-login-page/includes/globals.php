<?php
/**
 * Global Variables
 *
 * @package     SLP
 * @subpackage  Globals
 * @copyright   Copyright (c) 2013, Jesse Petersen
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       4.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$slp_prefix = 'slp_';
$slp_plugin_name = 'Stealth Login Page';
// retrieve plugin settings from options table
$slp_options  = get_option('slp_settings');
// the URL created via the settings page
$custom_url = site_url() . '/wp-login.php?' . $slp_options['question'] . '=' . $slp_options['answer'];
// the URL created via wp-config.php, if present
if ( isset($slp_question) && isset($slp_answer) && isset($slp_redirect) ) {
  $custom_wp_config = site_url() . '/wp-login.php?' . $slp_question . '=' . $slp_answer;
}