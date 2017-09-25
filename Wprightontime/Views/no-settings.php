<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php do_action('admin_nav'); ?>
    <p>
        <?php
            printf(
                __('It seems that you dont have your api key configured. Please addit in the <a href="%s">settings tab</a>.', 'wprightontime'),
                'admin.php?page=wprightontime&tab=settings'
            );
        ?>
    </p>
</div>