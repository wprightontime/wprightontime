<?php

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

if ( isset( $_GET['settings-updated'] ) ) {
    add_settings_error('wprot_messages', 'wprot_message', __('Settings Saved', 'wprightontime'), 'updated');
}

?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php do_action('admin_nav'); ?>
    <form method="post" action="options.php">
        <?php
            settings_fields('wprightontime');
           
            do_settings_sections('wprightontime');
            
            submit_button('Save Settings');
        ?>
    </form>
    <form method="post" action="admin-post.php">
        <table class="form-table">
            <tbody>
                <tr class="wprightontime_row">
                    <th scope="row">
                        <label for="wprightontime_clientkey"><?php esc_html_e('System Cron manual run', 'wprightontime') ?></label>
                    </th>
                    <td>
                        <input type="submit" class="button button-primary" name="cron_submit" value="<?php esc_attr_e('Run Cron', 'wprightontime') ?>" />
                        <p class="description">
                            <?php 
                            esc_html_e('If you ever need to activate a scheduled event, and dont want to change the call time. Click "Run cron".', 'wprightontime');
                            ?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" id="action" name="action" value="wprot_manual_cron" />
    </form>
</div>