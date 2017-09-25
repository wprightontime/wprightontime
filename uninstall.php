<?php

// Make sure that the uninstall was correctly started, before cleaning the options and session.
if (! defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

/**
 * Deletes WpRightOnTime options array
 *
 * @since 0.5.0
 */
delete_option('wprot_options');

/**
 * Destroy WpRightOnTime messages session, if is still set.
 *
 * @since 0.5.0
 */
 if (isset($_SESSION['wprot_api_message'])) unset($_SESSION['wprot_api_message']);
 session_destroy();