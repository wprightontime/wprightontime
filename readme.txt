=== WpRightOnTime ===
Contributors: telmoteixeira
Tags: cron, scheduler, wp cron, webcron, wprightontime
Requires at least: 4.7
Tested up to: 5.0
Stable tag: 1.2.0
License: GPL2 or Later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Every WordPress schedule right on time!
Make sure your scheduled events happen exactly when you want. 
Use it to automate your backups, newsletters, social sharing, whatever you need that relies on schedules.

== Description ==
WpRightOnTime is a webcron service dedicated to WordPress powered sites.

It enables its users to control all scheduled events, by overriding the visitor-activated cron system, with a user defined call to wp-cron.php.

<strong>WpRightOnTime is a webservice</strong>, you can start with a free account.

To use this service you will need a valid API key from <a href="https://www.wprightontime.com">wprightontime.com</a>.

This plugin is the interface for connecting with the service API.

== Installation ==
1. You need to create an account in <a href="https://www.wprightontime.com">wprightontime.com</a>.
2. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the \'Plugins\' screen in WordPress
4. Use the Settings->WpRightOnTime->Settings screen to save the API key
5. Add a call in the Settings->WpRightOnTime->Call screen to activate the desired time interval
6. Make sure your scheduled events match your call time.

== Screenshots ==
1. Calls screen
2. Settings screen
3. Reports screen

== Changelog ==
= 1.2.0 =
* Add wprotAdminNotices filter.

= 1.1.0 =
* Add wprotActionLinks filter.

= 1.0.1 =
* New api url.

= 1.0.0 =
* First stable version.