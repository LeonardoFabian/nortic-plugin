<?php

if (!function_exists('nortic_plugin_social_networks_options_page_old')) {
    /**
     * Load Social Network settings page in the admin plugin menu.
     *
     * @return void
     */
    function nortic_plugin_social_networks_options_page_old()
    {
?>
        <div class="wrap">
            <h1><?php esc_html_e('Social Network Settings', 'nortic-plugin'); ?></h1>

            <form method="POST" action="options.php">

                <?php

                settings_fields('nortic_plugin_options_group');
                do_settings_sections('nortic-plugin-social-networks-options-page');
                submit_button();

                ?>


                <input type="hidden" name="page" value="nortic-plugin-social-networks-options" />

            </form>
        </div>
<?php
    }
}
