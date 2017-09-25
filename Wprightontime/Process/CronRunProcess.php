<?php

namespace Wprightontime\Process;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

class CronRunProcess
{
    public function __construct()
    {
        add_action('admin_post_wprot_manual_cron', array($this, 'cronRunProcess'), 10);
    }

    public function cronRunProcess()
    {
        unset($_SESSION['wprot_api_message']);
        
        wp_redirect(get_bloginfo('wpurl').'/wp-admin/admin.php?page=wprightontime&tab=settings');
        
        exit;
    }
}