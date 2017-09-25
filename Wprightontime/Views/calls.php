<?php

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

use Wprightontime\Http\WprotHttp;

if ((isset($_GET['page']) && $_GET['page'] == 'wprightontime') && isset($_GET['jobupdt'])) {
    $api_action = 'put';
    $submit = 'Update Call';
    $job_to_update = WprotHttp::request([
                        'endpoint'  => 'singlejob',
                        'api_action'=> 'get',
                        'val'       => filter_var(intval($_GET['jobupdt']), FILTER_SANITIZE_NUMBER_INT)
                    ], $this->admin_object->options);
} else {
    $api_action = 'post';
    $submit = 'Save Call';
}

?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php do_action('admin_nav'); ?>
    <h1 class="wp-heading-inline">Calls</h1>
    <a href="" class="page-title-action job-form-js"><?php esc_html_e('Add New', 'wprightontime') ?></a></br>
    <div id="job-form" class="<?php echo isset($_GET['jobupdt']) ? '' : 'hidden';?>">
        <form method="post" action="admin-post.php">
            <table class="form-table">
                <tbody>
                    <tr class="wprightontime_job_row">
                        <th scope="row"><label for="job-start-selector"><?php esc_html_e('Make a call Every:', 'wprightontime') ?></label></th>
                        <td>
                            <select id="job-start-selector" name="job-start-selector" class="job-start-selector-js">
                                <option value="no-freq" ><?php esc_html_e('When?', 'wprightontime') ?></option>
                                <?php if ($this->admin_object->view->user_data['plan']) : ?>
                                    <option value="month" <?php if (isset($job_to_update) && $job_to_update->month == 1) echo 'selected' ?>><?php esc_html_e('Month', 'wprightontime') ?></option>
                                    <option value="monday" <?php if (isset($job_to_update) && $job_to_update->day_week == 1) echo 'selected' ?>><?php esc_html_e('Monday', 'wprightontime') ?></option>
                                    <option value="tuesday" <?php if (isset($job_to_update) && $job_to_update->day_week == 2) echo 'selected' ?>><?php esc_html_e('Tuesday', 'wprightontime') ?></option>
                                    <option value="wednesday" <?php if (isset($job_to_update) && $job_to_update->day_week == 3) echo 'selected' ?>><?php esc_html_e('Wednesday', 'wprightontime') ?></option>
                                    <option value="thursday" <?php if (isset($job_to_update) && $job_to_update->day_week == 4) echo 'selected' ?>><?php esc_html_e('Thursday', 'wprightontime') ?></option>
                                    <option value="friday" <?php if (isset($job_to_update) && $job_to_update->day_week == 5) echo 'selected' ?>><?php esc_html_e('Friday', 'wprightontime') ?></option>
                                    <option value="saturday" <?php if (isset($job_to_update) && $job_to_update->day_week == 6) echo 'selected' ?>><?php esc_html_e('Saturday', 'wprightontime') ?></option>
                                    <option value="sunday" <?php if (isset($job_to_update) && $job_to_update->day_week == 7) echo 'selected' ?>><?php esc_html_e('Sunday', 'wprightontime') ?></option>
                                    <option value="day_month" <?php if (isset($job_to_update) && empty($job_to_update->day_week) && empty($job_to_update->month) && $job_to_update->day_month == 1) echo 'selected' ?>><?php esc_html_e('Day', 'wprightontime') ?></option>

                                    <?php if ($this->admin_object->view->user_data['plan'] && ($this->admin_object->view->user_data['plan']->min_freq == 'hour' || $this->admin_object->view->user_data['plan']->min_freq == 'minute')) : ?>
                                        <option value="hour" <?php if (isset($job_to_update) && empty($job_to_update->day_week) && empty($job_to_update->month) && empty($job_to_update->day_month) && $job_to_update->hour == 1) echo 'selected' ?>><?php esc_html_e('Hour', 'wprightontime') ?></option>
                                    <?php endif; ?>

                                    <?php if ($this->admin_object->view->user_data['plan'] && $this->admin_object->view->user_data['plan']->min_freq == 'minute') : ?>
                                        <option value="minute" <?php if (isset($job_to_update) && empty($job_to_update->day_week) && empty($job_to_update->month) && empty($job_to_update->day_month) && empty($job_to_update->hour) && $job_to_update->minute == 1) echo 'selected' ?>><?php esc_html_e('Minute', 'wprightontime') ?></option>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </select>
                            <p class="description"><?php esc_html_e('Select a recuring event option.', 'wprightontime') ?></p>
                        </td>
                    </tr>

                    <tr class="wprightontime_job_row job-day_month-js">
                        <th scope="row"><label for="job-day_month"><?php esc_html_e('Day:', 'wprightontime') ?></label></th>
                        <td>
                            <input id="job-day_month" type="text" name="day_month" size="5" value="<?php if (isset($job_to_update)) echo $job_to_update->day_month ?>" />
                            <p class="description"><?php esc_html_e('A value between 1 and 31. Don\'t add leading 0, and beware that for values above 28, there\'s a chance that your call will skip some months.', 'wprightontime') ?></p>
                        </td>
                    </tr>

                    <tr class="wprightontime_job_row job-hour-js">
                        <th scope="row"><label for="job-hour"><?php esc_html_e('Hour:', 'wprightontime') ?></label></th>
                        <td>
                            <input id="job-hour" type="text" name="hour" size="5" value="<?php if (isset($job_to_update)) echo $job_to_update->hour ?>" />
                            <p class="description"><?php esc_html_e('A value between 0 and 23. Don\'t add leading 0.', 'wprightontime') ?></p>
                        </td>
                    </tr>

                    <tr class="wprightontime_job_row job-minute-js">
                        <th scope="row"><label for="job-minute"><?php esc_html_e('Minute:', 'wprightontime') ?></label></th>
                        <td>
                            <input id="job-minute" type="text" name="minute" size="5" value="<?php if (isset($job_to_update)) echo $job_to_update->minute ?>" />
                            <p class="description"><?php esc_html_e('A value between 0 and 59. Don\'t add leading 0.', 'wprightontime') ?></p>
                        </td>
                    </tr>

                </tbody>
            </table>
            <input id="job-day_week" type="hidden" name="day_week" size="5" value="<?php if (isset($job_to_update)) echo $job_to_update->day_week ?>" />
            <input id="job-month" type="hidden" name="month" size="5" value="<?php if (isset($job_to_update)) echo $job_to_update->month ?>" />
            <input type="hidden" id="action" name="action" value="call_form" />
            <input type="hidden" id="api_action" name="api_action" value="<?php echo $api_action; ?>" />
            <input type="hidden" id="endpoint" name="endpoint" value="jobs" />
            <input type="hidden" id="timezone" name="timezone" value="<?php echo get_option('timezone_string') ?>">
            <?php if (isset($_GET['jobupdt'])) : ?>
                <input type="hidden" id="val" name="val" value="<?php if (isset($job_to_update)) echo $job_to_update->id ?>" />
            <?php endif; ?>
            <input type="submit" class="button button-primary" name="ontime-job" value="<?php echo $submit; ?>" />
        </form>
    </div>
    <?php
        $this->admin_object->view->current_wp_table->raw_data = $this->admin_object->view->user_data['calls'];
        $this->admin_object->view->current_wp_table->prepare_items(); 
        $this->admin_object->view->current_wp_table->display(); 
    ?>
</div>