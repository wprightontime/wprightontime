<?php

namespace Wprightontime\Admin;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

use Wprightontime\View\View;
use Wprightontime\Settings\Settings;
use Wprightontime\Process\CallFormProcess;
use Wprightontime\Process\CronRunProcess;
use Wprightontime\Http\WprotHttp;
use Wprightontime\Notices\ApiMessage;


final class Admin
{
    public $local_timezone;

    public $options;

    public $user_data = array();

    public $view;

    public $settings;

    public $admin_warnings = array();

    public function __construct()
    {
        $lc_tz = get_option('timezone_string');
        $this->local_timezone = $lc_tz == '' ? null : $lc_tz;

        $this->options = get_option('wprot_options');
        
        $this->adminRequirementsCheck();

        $this->view = new View;

        $this->settings = new Settings($this);

        new CallFormProcess($this);
        new CronRunProcess;
        
        if (! empty($this->admin_warnings)) {
            add_action( 'admin_notices', array($this, 'wprotAdminNotices') );
        }
    }

    /**
     * Checks requirements in the admin area (timezone, client key, configured call)
     * show a admin notice if requirements not configured.
     *
     * @return void
     */
    public function adminRequirementsCheck()
    {
        if (! $this->local_timezone) {
            ApiMessage::add(array('tz' => array(
                'type'      => 'warning',
                'message'   => sprintf(
                    __( 'Please configure a city timezone! In <a href="%s">General settings.</a>', 'wprightontime' ),
                    'options-general.php'
                    ))));
        } else {
            unset($_SESSION['wprot_api_message']['tz']);
        }

        if (empty($this->options) || $this->options['wprightontime_clientkey'] == '' || ! $this->checkPlan() || ! $this->checkCall()) {
            $this->admin_warnings[] = array(
                'type'      => 'warning',
                'message'   => sprintf(
                    __( 'ATTENTION! system scheduler is curently disabled, you need to configure your WpRightOnTime api key in <a href="%s">WpRightOnTime settings</a>, and configure one call, in order  for your site scheduled events to function properly.', 'wprightontime' ),
                    'admin.php?page=wprightontime&tab=settings'
                    )
            );
        }
    }

    /**
     * Checks if user's plan is valid and set a time lock to limit this call to be daily.
     *
     * @return bool
     */
    public function checkPlan()
    {
        if (! isset($this->options['wprightontime_plan'])) {
            return false;
        }

        $now = new \DateTime('now', new \DateTimeZone($this->local_timezone));
        $plan_date = \DateTime::createFromFormat('Y-n-d', $this->options['wprightontime_plan'], new \DateTimeZone($this->local_timezone));

        if ($now->format('Y-n-d') == $plan_date->format('Y-n-d')) {
            return true;
        }

        if ($now->format('Y-n-d') > $plan_date->format('Y-n-d')) {
            $plan = WprotHttp::request(['endpoint'  => 'plan', 'api_action'=> 'get'], $this->options);
            if ($plan) {
                $this->options['wprightontime_plan'] = $now->format('Y-n-d');
                update_option('wprot_options', $this->options);
            } else {
                unset($this->options['wprightontime_plan']);
                update_option('wprot_options', $this->options);
                return false;
            }
            
        }

        return true;
    }

    /**
     * Checks if user have a call configured and set a time lock to limit this call to be daily.
     *
     * @return bool
     */
    public function checkCall()
    {
        if (! isset($this->options['wprightontime_calls'])) {
            return false;
        }

        $now = new \DateTime('now', new \DateTimeZone($this->local_timezone));
        $plan_date = \DateTime::createFromFormat('Y-n-d', $this->options['wprightontime_calls'], new \DateTimeZone($this->local_timezone));

        if ($now->format('Y-n-d') == $plan_date->format('Y-n-d')) {
            return true;
        }

        if ($now->format('Y-n-d') > $plan_date->format('Y-n-d')) {
            $plan = WprotHttp::request(['endpoint'  => 'jobs', 'api_action'=> 'get'], $this->options);
            if ($plan) {
                $this->options['wprightontime_calls'] = $now->format('Y-n-d');
                update_option('wprot_options', $this->options);
            } else {
                unset($this->options['wprightontime_calls']);
                update_option('wprot_options', $this->options);
                return false;
            }
            
        }

        return true;
    }

    /**
     * Helper function to print admin notices.
     *
     * @return void
     */
    public function wprotAdminNotices()
    {
        foreach ($this->admin_warnings as $value) {
            $class = 'notice notice-'.$value['type'];

            $message_html = sprintf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $value['message'] );

            echo apply_filters('wprotAdminNotices', $message_html, $class, $value);
        }
    }

}