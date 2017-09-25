<?php

namespace Wprightontime\View;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

use Wprightontime\User\UserData;
use Wprightontime\Table;
use Wprightontime\Notices\ApiMessage;

class View
{
    public $current_tab = [];

    public $current_wp_table;

    public $user_data;

    public $tabs = [
        'calls'     => 'Calls',
        'reports'   => 'Reports',
        'schedule'  => 'Next calls',
        'settings'  => 'Settings'
    ];

    public function __construct()
    {
        add_action('admin_nav', array($this, 'getAdminNav'));
        $this->checkUrlTab();
    }

    // set $current_tab
    public function setCurrentTab($key, $value)
    {
        $this->current_tab['key'] = $key;
        $this->current_tab['value'] = $value;
    }

    // render view
    public function getView($options)
    {   
        if (empty($options['wprightontime_clientkey']) && $this->current_tab['key'] != 'settings') {
            return WPROT_ROOT.'/Wprightontime/Views/no-settings.php';
        }

        if ($this->current_tab['key'] != 'welcome') {
            $this->user_data = UserData::getUserData($this->current_tab['key'], $options);
            $this->getWpTable();
        }

        if (isset($_SESSION['wprot_api_message'])) {
            ApiMessage::get();
        }
        
        return WPROT_ROOT.'/Wprightontime/Views/'.$this->current_tab['key'].'.php';
    }

    public function getAdminNav()
    {
        echo '<h2 class="nav-tab-wrapper">';
            foreach ($this->tabs as $key => $value) {
                echo '<a href="'.admin_url('admin.php?page=wprightontime&tab='.$key).'" class="nav-tab '.($this->current_tab['key'] == $key ? 'nav-tab-active' : '').'">'.$value.'</a>';  
            }
        echo '</h2>';
    }

    public function checkUrlTab()
    {
        if (! isset($_GET['tab'])) {
            $this->setCurrentTab('calls', 'Calls');
        }

        if (isset($_GET['tab']) && $_GET['tab'] == 'welcome') {
            $this->current_tab['welcome'] = 'Welcome';
            $this->setCurrentTab('welcome', 'Welcome');
        }

        if (isset($_GET['tab']) && array_key_exists($_GET['tab'], $this->tabs)) {
            $this->setCurrentTab(filter_var($_GET['tab'], FILTER_SANITIZE_STRING), $this->tabs[filter_var($_GET['tab'], FILTER_SANITIZE_STRING)]);
        }

        return true;
    }

    public function getWpTable()
    {
        switch ($this->current_tab['key']) {
            case 'calls':
                $this->current_wp_table = new Table\JobTable;
                break;

            case 'reports':
                $this->current_wp_table = new Table\ReportTable;
                break;

            case 'schedule':
                $this->current_wp_table = new Table\ScheduleTable;
                break;
            
            default:
                # code...
                break;
        }
        return true;
    }

    
}