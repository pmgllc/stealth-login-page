<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}


if ( !is_user_logged_in() )
  wp_die( 'You must be logged in to run this script.' );

if ( !current_user_can( 'install_plugins' ) )
  wp_die( 'You do not have permission to run this script.' );

function slp_uninstall() {
  delete_option('slp_options');
}

global $wpdb;
if (function_exists('is_multisite') && is_multisite()) {
  $blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
  $old_blog = $wpdb->blogid;
  foreach ($blogids as $blog_id) {
    switch_to_blog($blog_id);
    slp_uninstall();
  }
  // restore old blog
  switch_to_blog($old_blog);
} else
  slp_uninstall();
?>