<?php

namespace Wprightontime\Http;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

use Wprightontime\Notices\ApiMessage;

final class WprotHttp
{
    protected static $request_data;
    protected static $user_data;

    public static function request($request_data, $user_data)
    {
        self::$request_data = $request_data;
        self::$user_data = $user_data;
        
        return self::makeRequest();
    }

    protected static function makeRequest()
    {
        $request = wp_remote_request(self::getRequestUrl(), self::getRequestArgs());
        $response = json_decode(wp_remote_retrieve_body($request));
        if (isset($response->error)) {
            ApiMessage::add(array(
                $response->error->name => array(
                    'type'      => $response->error->type,
                    'message'   => $response->error->message
                )
            ));
            
            return false;
        }
        
        return $response;
    }

    protected static function getRequestUrl()
    {
        $url = WPROT_API.self::$request_data['endpoint'].'/'.self::$user_data['wprightontime_clientkey'].'/'.base64_encode(get_bloginfo('wpurl').'/wp-cron.php');
        if (isset(self::$request_data['val'])) {
            $url .= '/'.self::$request_data['val'];
        }
        return $url;
    }

    protected static function getRequestBody()
    {
        $body = [];
        foreach (self::$request_data as $key => $value) {
            $body[$key] = $value;
        }
        return $body;
    }

    protected static function getRequestArgs()
    {
        $body = self::getRequestBody();
        $args = array(
            'method'        => strtoupper(self::$request_data['api_action']),
            'body'          => $body,
            'timeout'       => '100',
            'redirection'   => '5',
            'httpversion'   => '1.0',
            'blocking'      => true,
            'headers'       => array(),
            'cookies'       => array()
        );
        return $args;
    }

}