<?php

namespace Wprightontime\Process;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

use Wprightontime\Http\WprotHttp;

class CallFormProcess
{
    public $admin_object;

    public function __construct($admin_object)
    {
        $this->admin_object = $admin_object;

        add_action('admin_post_call_form', array($this, 'callFormProcess'), 10);
    }

    public function callFormProcess()
    {
        unset($_SESSION['wprot_api_message']);
        
        $request_data = isset($_POST['ontime-job']) ? $_POST : $_GET;

        $args = array(
            'job-start-selector'    => FILTER_SANITIZE_STRING,
            'day_month'             => FILTER_SANITIZE_NUMBER_INT,
            'hour'                  => FILTER_SANITIZE_NUMBER_INT,
            'minute'                => FILTER_SANITIZE_NUMBER_INT,
            'day_week'              => FILTER_SANITIZE_NUMBER_INT,
            'month'                 => FILTER_SANITIZE_NUMBER_INT,
            'action'                => FILTER_SANITIZE_STRING,
            'api_action'            => FILTER_SANITIZE_STRING,
            'endpoint'              => FILTER_SANITIZE_STRING,
            'timezone'              => FILTER_SANITIZE_STRING,
            'val'                   => FILTER_SANITIZE_NUMBER_INT,
            'ontime-job'            => FILTER_SANITIZE_STRING
        );

        $safe_request_data = filter_var_array($request_data, $args);

        $response = WprotHttp::request($safe_request_data, $this->admin_object->options);
        wp_redirect(get_bloginfo('wpurl').'/wp-admin/admin.php?page=wprightontime&tab=calls');
        
        exit;
    }
}