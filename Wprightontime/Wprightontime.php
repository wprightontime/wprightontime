<?php

namespace Wprightontime;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

final class Wprightontime
{
    protected static $instance = null;
     
    public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    private function __construct()
    {
        if (is_admin()) {

            $this->startSession();

            // TODO: criate update and messaging system in the api
            // $this->checkForUpdates();
            // $this->checkForMessages();

            add_action('admin_enqueue_scripts', array($this, 'scriptsInit'), 10);
            add_filter('plugin_action_links_'.plugin_basename(WPROT_PLUGIN_FILE), array($this, 'wprotActionLinks'));
            
            add_action('wp_logout', array($this, 'endSession'));
            add_action('wp_login', array($this, 'endSession'));

            $this->adminInit();
        }
    }

    /**
     * Setting up plugin list action links
     */
    public function wprotActionLinks($links)
    {
        array_unshift(
            $links,
            '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=wprightontime') ) .'">Settings</a>',
            '<a href="mailto:support@wprightontime.com" target="_blank">Support</a>'
            );
            
        return $links;
    }

    /**
     * Enqueue plugin scripts
     */
    public function scriptsInit()
    {
        wp_enqueue_script( 'job-form', plugins_url('/wprightontime/assets/js/job-form.js') );
    }

    /**
     * Initialization of Admin area
     * 
     * @since 0.1.0 
     *
     * @return object   Returns the instance of the Admin area.
     */
    private function adminInit()
    {
        return new Admin\Admin;
    }

    /**
     * Starts a individual session to store messages.
     * 
     * @since  0.4.3
     */
    public function startSession()
    {
        if(! session_id()) {
            session_start();
        }
    }

    /**
     * Cleans individual messages session on login/logout.
     * 
     * @since  0.4.3
     */
    public function endSession()
    {
        session_destroy();
    }
       
}