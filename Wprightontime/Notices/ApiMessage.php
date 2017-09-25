<?php

namespace Wprightontime\Notices;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

final class ApiMessage
{
    /**
     * Adds messages to message session array.
     *
     * @since 0.3.3
     *
     * @return bool     True.
     */
    public static function add(array $notices)
    {
        foreach ($notices as $key => $value) {
            if (! isset($_SESSION['wprot_api_message'][$key])) {
                $_SESSION['wprot_api_message'][$key] = array(
                    'type'      => $value['type'],
                    'message'   => $value['message']
                );
            }
        }
        
        return true;
    }

    /**
     * Prints out the messages that are stored in the message cookie.
     *
     * @since 0.3.3
     *
     * @return print     Echo out a formated strin with the messages.
     */
    public static function get()
    {
        $wprot_api_message_get = $_SESSION['wprot_api_message'];
        
        if ($wprot_api_message_get) {
            foreach ($wprot_api_message_get as $message) {
                if (is_array($message['message'])) {
                    foreach ($message['message'] as $value) {
                        printf( '<div class="notice notice-'.$message['type'].' is-dismissible"><p>'.$value.'</p></div>');
                    }
                } else {
                    printf( '<div class="notice notice-'.$message['type'].' is-dismissible"><p>'.$message['message'].'</p></div>');
                }
            }
        }

        // Reset the session to an empty value;
        unset($_SESSION['wprot_api_message']);
    }
}