<?php

namespace Wprightontime\User;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

use Wprightontime\Http\WprotHttp;

class UserData
{
    public static function getUserData($tab, $options)
    {
        $data = [];

        switch ($tab) {
            case 'reports':
                $reports = WprotHttp::request([
                        'endpoint'  => 'reports',
                        'api_action'=> 'get',
                        'val'       => 20
                    ], $options);
                $data['reports'] = $reports;
                break;

            case 'schedule':
                $schedule = WprotHttp::request([
                        'endpoint'  => 'predictions',
                        'api_action'=> 'get',
                        'val'       => 10
                    ], $options);
                $data['schedule'] = $schedule;
                break;

            case 'calls':
                $calls = WprotHttp::request([
                        'endpoint'  => 'jobs',
                        'api_action'=> 'get'
                    ], $options);
                $data['calls'] = $calls;
                if ($calls) {
                    
                    if (! isset($options['wprightontime_calls'])) {
                        $now = new \DateTime('now', new \DateTimeZone(get_option('timezone_string')));
                        $options['wprightontime_calls'] = $now->format('Y-n-d');
                        update_option('wprot_options', $options);
                    }
                } else {
                    if (isset($options['wprightontime_calls'])) {
                        unset($options['wprightontime_calls']);
                        update_option('wprot_options', $options);
                    }
                }

                $plan = WprotHttp::request([
                        'endpoint'  => 'plan',
                        'api_action'=> 'get'
                    ], $options);
                $data['plan'] = $plan;
                if ($plan) {
                    if (! isset($options['wprightontime_plan'])) {
                        $now = new \DateTime('now', new \DateTimeZone(get_option('timezone_string')));
                        $options['wprightontime_plan'] = $now->format('Y-n-d');
                        update_option('wprot_options', $options);
                    }
                } else {
                    if (isset($options['wprightontime_plan'])) {
                        unset($options['wprightontime_plan']);
                        update_option('wprot_options', $options);
                    }
                }
                
                break;
            
            default:
                break;
        }
        
        return $data;
    }
}