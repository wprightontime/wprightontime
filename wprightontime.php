<?php
/**
 * Plugin Name: WpRightOnTime
 * Description: Every WordPress schedule rigth on time!
 * Version:     1.0.1
 * Author:      WpRightOnTime
 * Author URI:  https://www.wprightontime.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wprightontime
 * Domain Path: /i18n
 */

// Dont´t allow to call this file directly
if (! defined('ABSPATH')) {
    die;
}

// Define plugin constants
define('WPROT_ROOT', (__DIR__));
define('WPROT_PLUGIN_FILE', (__FILE__));
define('WPROT_PLUGIN_VERSION', '1.0.1');
define('WPROT_API', 'https://app.wprightontime.com/api/');


/**
 * Validate that is not a manual WpRightOnTime cron action. If it is, let WP_CRON run.
 * 
 * If is not a manual WpRightOnTime cron action, try to disable WP_CRON.
 *
 * @since 0.4.2
 */
if (! isset($_POST['action']) || (isset($_POST['action']) && $_POST['action'] != 'wprot_manual_cron')) {
    // Disable wp_cron
    if (! defined('DISABLE_WP_CRON') || DISABLE_WP_CRON != true) {
        define('DISABLE_WP_CRON', true);
    }
}

/**
 * Validates minimum requirements on plugin activation
 *
 * @since 1.1.0
 */ 
function wprot_minRequirements()
{
    if (version_compare(PHP_VERSION, '5.4.0') < 0) {

        // Deactivates the plugin.
        deactivate_plugins(plugin_basename(__FILE__));

        // Die with message.
        wp_die(esc_html__( 'Sorry you can\'t activate the plugin, your PHP version is lower than 5.4.0. Please update your server environment.', 'wprightontime'));
    }

    return true;
}
register_activation_hook(__FILE__, 'wprot_minRequirements');

/**
 * WpRightOnTime Autoloader
 * 
 * Composer psr-4 autoloader for the namespace "WpRightOnTime".
 *
 * @since 0.1.0
 *
 * @return object   WpRightOnTime object instance.
 */
require_once(WPROT_ROOT.'/vendor/autoload.php');

/**
 * WpRightOnTime READY!
 * 
 * Starts all plugin functionality by instantition of WpRightOnTime main object.
 *
 * @since 0.1.0
 *
 * @return object  WpRightOnTime main object instance.
 */
function WPROT()
{
    return Wprightontime\Wprightontime::getInstance();
}

// WpRightOnTime GO!
WPROT();