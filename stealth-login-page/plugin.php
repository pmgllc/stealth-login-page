<?php
/*
  Plugin Name: Stealth Login Page
  Plugin URI: http://wordpress.org/extend/plugins/stealth-login-page/
  Version: 3.0.0
  Author: Jesse Petersen
  Author URI: http://www.petersenmediagroup.com
  Description: Protect your /wp-admin and wp-login.php pages from being accessed without editing .htaccess
  Text Domain: stealth-login-page
  Domain Path: /languages/
 */
/*
  Copyright 2013 Jesse Petersen

  Thanks to Andrew Norcross (@norcross) for the redirect code (https://gist.github.com/norcross/4342231) and Billy Fairbank (@billyfairbank) for the idea to turn it into a plugin. Last minute thanks for 'mindctrl' (https://github.com/mindctrl) hopping on GitHub and adding more advanced features and correcting my mistakes.

  Thanks to David Decker for DE localization: http://deckerweb.de/kontakt/

  Limit of liability: Installation and use of this plugin acknowledges the
  understanding that this program alters the wp-config.php file and adds
  settings to the WordPress database. The author is not responsible for any
  damages or loss of data that might possibly be incurred through the
  installation or use of the plugin.

  Support: This is a free plugin, therefore support is limited to bugs that
  affect all installations. Requests of any other nature will be at the
  discretion of the plugin author to add or modify the code to account for
  various installations, servers, or plugin conflicts.
  
  Licenced under the GNU GPL:

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
    wp_die( __( 'Sorry, you are not allowed to access this page directly.', 'stealth-login-page' ) );
}

add_action( 'init', 'slp_load_plugin_translations', 1 );
/**
 * Load translations for this plugin
 */
function slp_load_plugin_translations() {
  
  load_plugin_textdomain( 'stealth-login-page', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}

register_activation_hook( __FILE__, 'slp_activate' );
register_deactivation_hook( __FILE__, 'slp_deactivate' );

function slp_activate($networkwide) {
    global $wpdb;

    if (function_exists('is_multisite') && is_multisite()) {
      // check if it is a network activation - if so, run the activation function for each blog id
      if ($networkwide) {
        $old_blog = $wpdb->blogid;
        // Get all blog ids
        $blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
        foreach ($blogids as $blog_id) {
          switch_to_blog($blog_id);
          return _slp_activate($networkwide);
        }
        switch_to_blog($old_blog); 
        return;
      } 
    } 
    return _slp_activate($networkwide);     
  }
     
function slp_network_propagate($pfunction, $networkwide) {
    global $wpdb;
 
    if (function_exists('is_multisite') && is_multisite()) {
        // check if it is a network activation - if so, run the activation function 
        // for each blog id
        if ($networkwide) {
            $old_blog = $wpdb->blogid;
            // Get all blog ids
            $blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
            foreach ($blogids as $blog_id) {
                switch_to_blog($blog_id);
                call_user_func($pfunction, $networkwide);
            }
            switch_to_blog($old_blog);
            return;
        }   
    } 
    call_user_func($pfunction, $networkwide);
}
 
 
function slp_deactivate($networkwide) {
    slp_network_propagate('_slp_deactivate', $networkwide);
}

add_action( 'wpmu_new_blog', 'slp_new_blog', 10, 6);        
 
function slp_new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    global $wpdb;
 
    if (is_plugin_active_for_network('stealth-login-page/plugin.php')) {
        $old_blog = $wpdb->blogid;
        switch_to_blog($blog_id);
        _slp_activate(TRUE);
        switch_to_blog($old_blog);
    }
}

function _slp_activate($networkwide) {
  return ;
}

function _slp_deactivate($networkwide) {
  return ;
}

add_action('admin_menu', 'slp_plugin_menu');
function slp_plugin_menu() {
  add_options_page( __( 'Stealth Login Page', 'stealth-login-page' ), __( 'Stealth Login Page', 'stealth-login-page' ), 'manage_options', 'stealth-login-page', 'slp_admin' );
  add_options_page( __( 'Stealth Login Page Documentation', 'stealth-login-page' ), __( 'Stealth Login Page Documentation', 'stealth-login-page' ),  'activate_plugins', 'stealth-login-page-documentation', 'slp_documentation' );
      return;
}

/**
 * Add settings link on plugin page
 *
 * @since 1.1.3
 * @param array $links
 * @param string $file
 * @return array
 */
add_filter( 'plugin_action_links', 'slp_admin_settings_link', 10, 2  );
function slp_admin_settings_link( $links, $file ) {

  if ( plugin_basename(__FILE__) == $file ) {
    $settings_link = '<a href="' . admin_url( 'options-general.php?page=stealth-login-page' ) . '">' . __( 'Settings', 'stealth-login-page' ) . '</a>';
    $documentation_link = '<a href="' . admin_url( 'options-general.php?page=stealth-login-page-documentation' ) . '">' . __( 'Documentation', 'stealth-login-page' ) . '</a>';
    array_unshift( $links, $settings_link, $documentation_link );
  }

  return $links;

}

// Global Variables ---------------------- //
$slp_prefix = 'slp_';
$slp_plugin_name = 'Stealth Login Page';
// retrieve plugin settings from options table
$slp_options  = get_option('slp_settings');
$custom_url = site_url() . '/wp-login.php?' . $slp_options['question'] . '=' . $slp_options['answer'];
if ( isset($slp_question) && isset($slp_answer) && isset($slp_redirect) ) {
  $custom_wp_config = site_url() . '/wp-login.php?' . $slp_question . '=' . $slp_answer;
}
$message = '<h2 style="text-align: center; margin-top: 4em;">You suck! Go hack someone else.</h2>';

/*-------------------------------------------------------------
 Name:      slp_credits

 Purpose:   Promotional stuff shown throughout the plugin
 Since:   1.1.3
-------------------------------------------------------------*/
function slp_credits() {

  echo '<table class="widefat" style="margin-top: .5em">';

  echo '<thead>';
  echo '<tr valign="top">';
  echo '  <th width="27%">'.__('Your support makes a difference', 'stealth-login-page').'</th>';
  echo '  <th>'.__('Useful links', 'stealth-login-page').'</th>';
  echo '  <th width="35%">'.__('Brought to you by', 'stealth-login-page').'</th>';
  echo '</tr>';
  echo '</thead>';

  echo '<tbody>';
  echo '<tr>';
  echo '<td><ul>';
  echo '  <li>'.__('Your generous gift will ensure the continued development of Stealth Login Page and bring more benefits and features. Thank you for your consideration!', 'stealth-login-page').'</li>';
  
  echo '  <li><center><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7T2JDSM64HQV8" target="_blank"><img src="http://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" /></a></center></li>';
  echo '  <li>'.__('Like the plugin? Please ', 'stealth-login-page').' <a href="http://wordpress.org/support/view/plugin-reviews/stealth-login-page?rate=5#postform" target="_blank">'.__('rate and review', 'stealth-login-page').'</a> '.__('it', 'stealth-login-page').'.</li>';
  echo '</ul></td>';

  echo '<td style="border-left:1px #ddd solid;"><ul>';
  
  echo '  <li><strong>'.__('Plugin documentation', 'stealth-login-page').' <a href="'.admin_url() . 'options-general.php?page=stealth-login-page-documentation" target="_blank">right here in the dashboard</a>.</strong></li><br /><br />';
  echo '  <li>'.__('Find my website at', 'stealth-login-page').' <a href="http://www.petersenmediagroup.com" target="_blank">petersenmediagroup.com</a>.</li>';
  echo '  <li>'.__('Beef up your security even more with', 'stealth-login-page').' <a href="http://wordpress.org/extend/plugins/limit-login-attempts/" target="_blank">'.__('Limit Login Attempts','stealth-login-page').'</a>.</li>';
  echo '  <li>'.__('Learn more about secure WordPress hosting with a ', 'stealth-login-page').' <a href="http://www.petersenmediagroup.com/wordpress-hosting/" target="_blank">'.__('managed host', 'stealth-login-page').'</a>.</li>';
  echo '</ul></td>';

  echo '<td style="border-left:1px #ddd solid;"><ul>';
  echo '  <li><a href="http://www.petersenmediagroup.com" title="Petersen Media Group"><img src="'. plugins_url( 'images/pmg-logo.png' , __FILE__ ) .'" alt="pmg-logo" width="150" height="67" align="left" style="padding: 0 10px 10px 0;" /></a>';
  echo '  <a href="http://www.petersenmediagroup.com" title="Petersen Media Group">Petersen Media Group</a> - '.__('I’m a straight-shooter and listen to what my clients want, run it through my filters, and come up with what they need. Not a "yes man" by any stretch of the imagination, I don’t consider a project a success unless it serves my client well. I have a "do no harm" policy to protect them from mis-information and trying things I’ve already learned about the hard way.', 'stealth-login-page').' '.__('Visit the', 'stealth-login-page').' <a href="http://www.petersenmediagroup.com" target="_blank">'.__('Petersen Media Group', 'stealth-login-page').'</a> '.__('website', 'stealth-login-page').'.</li>';
  echo '</ul></td>';
  echo '</tr>';
  echo '</tbody>';

  echo '</table>';
}

// Includes ------------------------------ //
include('includes/settings-page.php'); // loads the admin settings page
include('includes/documentation.php'); // loads the admin settings page
if ( $slp_options['enable'] ) {
  include('includes/settings-functions.php'); // loads the settings page functions
}
elseif ( isset($custom_wp_config) ) {
  include('includes/wp-config-functions.php'); // loads the wp-config.php functions
}