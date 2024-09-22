<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 */

// If uninstall not called from WordPress, then exit.
if(!defined('WP_UNINSTALL_PLUGIN')){
	exit;
}


try {
    $licenceKey = get_option('sp_dsgvo_dsgvo_licence');
    $activated = get_option('sp_dsgvo_license_activated');

    if ($activated === '1' && $licenceKey !== '')
    {

        $url = 'https://legalweb.io/spdsgvo-bin/deactivate.php';
        $url .= '?license_key=' .$licenceKey;
        
        $request = wp_remote_get($url);
    }
}
catch ( Exception $e )
{
    error_log('error during licence deactivation');
    error_log($e);
}

global $wpdb;
try {
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}sp_dsgvo_logs");
}
catch ( Exception $e )
{
    error_log('error during log table dropping');
    error_log($e);
}



try {
    $plugin_options = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'sp_dsgvo_%'" );
    
    foreach( $plugin_options as $option ) {
        delete_option( $option->option_name );
    }
}
catch ( Exception $e )
{
    error_log('error while deleting all options');
    error_log($e);
}
