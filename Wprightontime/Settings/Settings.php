<?php

namespace Wprightontime\Settings;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

class Settings 
{
    public $admin_object;

    public function __construct($admin_object)
    {
        $this->admin_object = $admin_object;
        
        add_action('admin_init', array($this, 'settingsInit'), 10);
        add_action('admin_menu', array($this, 'addSettingsPage' ), 10);

    }

    public function addSettingsPage()
    {
        add_options_page('WpRightOnTime', 'WpRightOnTime', 'manage_options', 'wprightontime', array($this, 'settingsMenuPage'));
    }

    public function settingsMenuPage()
    {
        
        if (! current_user_can('manage_options')) {
            return;
        }
        
        include($this->admin_object->view->getView($this->admin_object->options));
    }

    public function settingsInit()
    {
        register_setting('wprightontime', 'wprot_options');

        add_settings_section('wprightontime_section_settings', __( 'Settings', 'wprightontime' ), '', 'wprightontime');

        add_settings_field(
            'wprightontime_clientkey',
            __( 'API Key', 'wprightontime' ),
            array($this, 'wprightontime_clientkey_field'),
            'wprightontime',
            'wprightontime_section_settings',
            [
                'label_for' => 'wprightontime_clientkey',
                'class' => 'wprightontime_row',
                'wprightontime_custom_data' => 'custom',
                'options' => $this->admin_object->options
            ]
        );
    }

    public function wprightontime_clientkey_field( $args )
    {
        include(WPROT_ROOT.'/Wprightontime/Views/Fields/clientkey_field.php');
    }
}