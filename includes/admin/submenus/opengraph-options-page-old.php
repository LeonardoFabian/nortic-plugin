<?php

if (!function_exists('nortic_plugin_opengraph_options_page')) {
    /**
     * Load Open Graph settings page in the admin plugin menu.
     *
     * @return void
     */
    function nortic_plugin_opengraph_options_page()
    {
        $options = get_option('nortic_plugin_opengraph_options');

        // var_dump($options);
?>
        <div class="wrap">
            <h1><?php esc_html_e('Open Graph Settings', 'nortic-plugin'); ?></h1>
            <p><?php esc_html_e('Open Graph control how your website is being displayed on Facebook. Now, other social media sites such as Twitter, LinkedIn are recognizing Open Graph meta tags.', 'nortic-plugin'); ?></p>
            <p><?php esc_html_e('More details in', 'nortic-plugin'); ?> <a href="https://www.opengraph.xyz/" target="_blank">Open Graph</a></p>

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

                <input type="hidden" name="action" value="np_opengraph_save_options" />

                <?php wp_nonce_field('nortic_plugin_opengraph_options_verify'); ?>

                <table class="form-table">
                    <tbody>
                        <!-- Open Graph Title -->
                        <tr>
                            <th>
                                <label for="np_og_title">
                                    <?php esc_html_e('Open Graph Title', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_og_title" type="text" id="np_og_title" class="regular-text" value="<?php echo esc_attr($options['np_og_title']); ?>" />
                            </td>
                        </tr>
                        <!-- Open Graph Image -->
                        <tr>
                            <th>
                                <label for="np_og_image">
                                    <?php esc_html_e('Open Graph Image', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <div class="nortic-image-preview-container">
                                    <input type="hidden" name="np_og_image" id="np_og_image" value="<?php echo esc_attr($options['np_og_image']); ?>" />
                                    <img id="np-og-img-preview" src="<?php echo esc_attr($options['np_og_image']); ?>">
                                </div>
                                <p class="description"><?php esc_html_e('Image', 'nortic-plugin'); ?> (1200px x 630px)</p>
                                <a href="#" class="button-primary" id="np-og-img-upload-btn">
                                    <?php esc_html_e('Select Image', 'nortic-plugin'); ?>
                                </a>
                            </td>
                        </tr>
                        <!-- Open Graph Description -->
                        <tr>
                            <th>
                                <label for="np_og_description">
                                    <?php esc_html_e('Open Graph Description', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <textarea id="np_og_description" name="np_og_description" class="large-text"><?php echo esc_attr($options['np_og_description']); ?></textarea>
                            </td>
                        </tr>
                        <!-- Enable Open Graph -->
                        <tr>
                            <th>
                                <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                            </th>
                            <td>
                                <label for="np_enable_og">
                                    <input name="np_enable_og" type="checkbox" id="np_enable_og" value="1" <?php checked(esc_attr($options['np_enable_og']), 1); ?> />
                                    <span><?php esc_html_e('Enable', 'nortic-plugin'); ?></span>
                                </label>
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
