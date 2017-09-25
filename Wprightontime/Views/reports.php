<?php

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php do_action('admin_nav'); ?>

    <?php
        $this->admin_object->view->current_wp_table->raw_data = $this->admin_object->view->user_data['reports'];
        $this->admin_object->view->current_wp_table->prepare_items(); 
        $this->admin_object->view->current_wp_table->display(); 
    ?>
    <p>* For more information about http status codes see <a href="https://httpstatuses.com/">httpstatuses.com</a></p>
</div>


