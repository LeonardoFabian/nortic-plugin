<?php

if (!function_exists('nortic_plugin_options_page')) {
    /**
     * Output the content of plugin admin page.
     *
     * @return void
     */
    function nortic_plugin_options_page()
    {
        $options = get_option('nortic_plugin_options');
?>
        <div class="wrap">
            <h1><?php esc_html_e('Nortic Plugin Settings', 'udemy-plus'); ?></h1>

            <?php
            if (isset($_GET['status']) && $_GET['status'] == '1') {
            ?>
                <div class="notice notice-success inline">
                    <p><?php esc_html_e('Options updated successfully!', 'nortic-plugin'); ?></p>
                </div>
            <?php
            }
            ?>

            <form novalidate="novalidate" method="POST" action="admin-post.php">

                <input type="hidden" name="action" value="np_save_options" />
                <input type="hidden" name="page" value="nortic-plugin-options" />

                <?php wp_nonce_field('nortic_plugin_options_verify'); ?>

                <h2><?php esc_html_e('Customize template', 'nortic-plugin'); ?></h2>
                <table class="form-table">
                    <tbody>
                        <!-- Google Analytics Code -->
                        <tr>
                            <th>
                                <label for="np_google_analytics_ua_code">
                                    <?php esc_html_e('Google Analytics UA Code', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <textarea id="np_google_analytics_ua_code" name="np_google_analytics_ua_code" class="large-text"><?php echo esc_attr($options['np_google_analytics_ua_code']); ?></textarea>
                            </td>
                        </tr>

                        <!-- Sello NORTIC Web -->
                        <tr>
                            <th>
                                <label for="np_sello_nortic_web">
                                    <?php esc_html_e('NORTIC Seal (Web)', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <textarea id="np_sello_nortic_web" name="np_sello_nortic_web" class="large-text"><?php echo esc_attr($options['np_sello_nortic_web']); ?></textarea>
                            </td>
                        </tr>

                        <!-- Sello NORTIC Mobile -->
                        <tr>
                            <th>
                                <label for="np_sello_nortic_mobile">
                                    <?php esc_html_e('NORTIC Seal (Mobile)', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <textarea id="np_sello_nortic_mobile" name="np_sello_nortic_mobile" class="large-text"><?php echo esc_attr($options['np_sello_nortic_mobile']); ?></textarea>
                            </td>
                        </tr>

                        <!-- Theme logo -->
                        <tr>
                            <th>
                                <label for="np_theme_logo">
                                    <?php esc_html_e('Theme Main Logo', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <div class="nortic-image-preview-container">
                                    <input type="hidden" name="np_theme_logo" id="np_theme_logo" value="<?php echo esc_attr($options['np_theme_logo']); ?>" />
                                    <img id="np-theme-logo-preview" src="<?php echo esc_attr($options['np_theme_logo']); ?>">
                                </div>
                                <p class="description"><?php esc_html_e('Image', 'nortic-plugin'); ?> (200px x 100px)</p>
                                <a href="#" class="button-primary" id="np-theme-logo-upload-btn">
                                    <?php esc_html_e('Select Image', 'nortic-plugin'); ?>
                                </a>

                            </td>
                        </tr>

                        <!-- Theme Footer logo -->
                        <tr>
                            <th>
                                <label for="np_theme_footer_logo">
                                    <?php esc_html_e('Theme Footer Logo', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <div class="nortic-image-preview-container">
                                    <input type="hidden" name="np_theme_footer_logo" id="np_theme_footer_logo" value="<?php echo esc_attr($options['np_theme_footer_logo']); ?>" />
                                    <img id="np-theme-footer-logo-preview" src="<?php echo esc_attr($options['np_theme_footer_logo']); ?>">
                                </div>
                                <p class="description"><?php esc_html_e('Image', 'nortic-plugin'); ?> (300px x 118px)</p>
                                <a href="#" class="button-primary" id="np-theme-footer-logo-upload-btn">
                                    <?php esc_html_e('Select Image', 'nortic-plugin'); ?>
                                </a>

                            </td>
                        </tr>


                    </tbody>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
<?php
    }
}
