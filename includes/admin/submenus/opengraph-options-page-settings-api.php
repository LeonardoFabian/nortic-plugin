<?php

if (!function_exists('nortic_plugin_opengraph_options_page_old')) {
    /**
     * Load Open Graph settings page in the admin plugin menu.
     *
     * @return void
     */
    function nortic_plugin_opengraph_options_page_old()
    {

        // var_dump($options);
?>
        <div class="wrap">
            <h1><?php esc_html_e('Open Graph Settings', 'nortic-plugin'); ?></h1>



            <form method="POST" action="options.php">

                <?php
                settings_fields('nortic_plugin_options_group');
                do_settings_sections('nortic-plugin-opengraph-options-page');
                submit_button();
                ?>

            </form>
        </div>

<?php
    }
}
