<?php

if (!function_exists('nortic_plugin_chatbot_options_page_old')) {
    /**
     * Load Chatbot block settings page in the admin plugin menu.
     *
     * @return void
     */
    function nortic_plugin_chatbot_options_page_old()
    {
?>
        <div class="wrap">
            <h1><?php esc_html_e('Chatbot Settings', 'nortic-plugin'); ?></h1>


            <form method="POST" action="options.php">

                <?php
                settings_fields('nortic_plugin_options_group');
                do_settings_sections('nortic-plugin-chatbot-options-page');
                submit_button();
                ?>

            </form>
        </div>
<?php
    }
}
