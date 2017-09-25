<?php

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

?>

<input 
    type="text" 
    id="<?php echo esc_attr($args['label_for']); ?>"
    size="30" 
    name="wprot_options[<?php echo esc_attr($args['label_for']); ?>]"
    value="<?php echo esc_attr($args['options']['wprightontime_clientkey']); ?>" 
/>
<p class="description">
    <?php 
        printf(
            __( 'You can find the api key in your account dashboard. <a href="%s">wprightontime.com</a>.', 'wprightontime' ),
            'https://www.wprightontime.com/auth/signin'
        );
    ?>
</p>