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

    /**
     * Public function to make the reques to the api.
     * 
     * Sets the protected static variables $request_data and $user_data.
     *
     * @param Array $request_data
     * @param Array $user_data
     * @return The result of the makeRequest() function
     */
    public static function request($request_data, $user_data)
    {
        self::$request_data = $request_data;
        self::$user_data = $user_data;
        
        return self::makeRequest();
    }

    /**
     * Helper function to make a http request to the api
     *
     * @return Object|bool Returns the response object if sucessfull, returns false if response error
     */
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

    /**
     * Helper function to construct the url to the request endpoint
     *
     * @return string $url
     */
    protected static function getRequestUrl()
    {
        $url = WPROT_API.self::$request_data['endpoint'].'/'.self::$user_data['wprightontime_clientkey'].'/'.base64_encode(get_bloginfo('wpurl').'/wp-cron.php');

        if (isset(self::$request_data['val'])) {
            $url .= '/'.self::$request_data['val'];
        }

        return $url;
    }

    /**
     * Helper function to construct the request body
     *
     * @return array $body
     */
    protected static function getRequestBody()
    {
        $body = [];

        foreach (self::$request_data as $key => $value) {
            $body[$key] = $value;
        }

        return $body;
    }

    /**
     * Helper function that construct the arguments to the request call
     *
     * @return array $args The options of the request call
     */
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