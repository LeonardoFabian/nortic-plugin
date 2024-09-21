<?php

if (!function_exists('nortic_plugin_social_networks_options_page')) {
    /**
     * Load Social Network settings page in the admin plugin menu.
     *
     * @return void
     */
    function nortic_plugin_social_networks_options_page()
    {
        $options = get_option('nortic_plugin_options');
?>
        <div class="wrap">
            <h1><?php esc_html_e('Social Network Settings', 'nortic-plugin'); ?></h1>
            <p><?php esc_html_e('Increase your number of followers by adding the main social networks on your website.', 'nortic-plugin'); ?></p>

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
                <input type="hidden" name="page" value="nortic-plugin-social-networks-options" />

                <?php wp_nonce_field('nortic_plugin_options_verify'); ?>

                <hr>
                <h2><span class="dashicons dashicons-facebook" style="margin-right: 1rem;"></span><?php esc_html_e('Facebook', 'nortic-plugin'); ?></h2>
                <p><?php esc_html_e('Do not you have an account yet? Go to', 'nortic-plugin'); ?> <a href="https://www.facebook.com/" target="_blank">Facebook</a></p>
                <table class="form-table">
                    <tbody>

                        <!-- Facebook Profile URL -->
                        <tr>
                            <th>
                                <label for="np_facebook_url">
                                    <?php esc_html_e('Profile URL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_facebook_url" type="text" id="np_facebook_url" class="regular-text" value="<?php echo esc_attr($options['np_facebook_url']); ?>" />
                                <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Facebook link color -->
                        <tr>
                            <th>
                                <label for="np_facebook_color">
                                    <?php esc_html_e('HEX Color', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_facebook_color" type="text" id="np_facebook_color" class="regular-text" value="<?php echo esc_attr($options['np_facebook_color']); ?>" />
                                <button type="button" style="background-color: <?php echo esc_attr($options['np_facebook_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-facebook"></span></button>
                                <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Show Facebook button in Feed -->
                        <tr>
                            <th>
                                <label for="np_facebook_enable">
                                    <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_facebook_enable" type="checkbox" id="np_facebook_enable" value="1" <?php checked(esc_attr($options['np_facebook_enable']), 1); ?> />
                            </td>
                        </tr>

                    </tbody>
                </table>

                <hr>
                <h2><span class="dashicons dashicons-instagram" style="margin-right: 1rem;"></span><?php esc_html_e('Instagram', 'nortic-plugin'); ?></h2>
                <p><?php esc_html_e('Do not you have an account yet? Go to', 'nortic-plugin'); ?> <a href="https://www.instagram.com/" target="_blank">Instagram</a></p>
                <table class="form-table">
                    <tbody>

                        <!-- Instagram Profile URL -->
                        <tr>
                            <th>
                                <label for="np_instagram_url">
                                    <?php esc_html_e('Profile URL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_instagram_url" type="text" id="np_instagram_url" class="regular-text" value="<?php echo esc_attr($options['np_instagram_url']); ?>" />
                                <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Instagram link color -->
                        <tr>
                            <th>
                                <label for="np_instagram_color">
                                    <?php esc_html_e('HEX Color', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_instagram_color" type="text" id="np_instagram_color" class="regular-text" value="<?php echo esc_attr($options['np_instagram_color']); ?>" />
                                <button type="button" style="background-color: <?php echo esc_attr($options['np_instagram_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-instagram"></span></button>
                                <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Show Instagram button in Feed -->
                        <tr>
                            <th>
                                <label for="np_instagram_enable">
                                    <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_instagram_enable" type="checkbox" id="np_instagram_enable" value="1" <?php checked(esc_attr($options['np_instagram_enable']), 1); ?> />
                            </td>
                        </tr>

                    </tbody>
                </table>

                <hr>
                <h2><span class="dashicons dashicons-twitter" style="margin-right: 1rem;"></span><?php esc_html_e('Twitter', 'nortic-plugin'); ?></h2>
                <p><?php esc_html_e('Do not you have an account yet? Go to', 'nortic-plugin'); ?> <a href="https://twitter.com/" target="_blank">Twitter</a></p>
                <table class="form-table">
                    <tbody>

                        <!-- Twitter Profile URL -->
                        <tr>
                            <th>
                                <label for="np_twitter_url">
                                    <?php esc_html_e('Profile URL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_twitter_url" type="text" id="np_twitter_url" class="regular-text" value="<?php echo esc_attr($options['np_twitter_url']); ?>" />
                                <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Twitter link color -->
                        <tr>
                            <th>
                                <label for="np_twitter_color">
                                    <?php esc_html_e('HEX Color', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_twitter_color" type="text" id="np_twitter_color" class="regular-text" value="<?php echo esc_attr($options['np_twitter_color']); ?>" />
                                <button type="button" style="background-color: <?php echo esc_attr($options['np_twitter_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-twitter"></span></button>
                                <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Show Twitter button in Feed -->
                        <tr>
                            <th>
                                <label for="np_twitter_enable">
                                    <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_twitter_enable" type="checkbox" id="np_twitter_enable" value="1" <?php checked(esc_attr($options['np_twitter_enable']), 1); ?> />
                            </td>
                        </tr>

                    </tbody>
                </table>

                <hr>
                <h2><span class="dashicons dashicons-youtube" style="margin-right: 1rem;"></span><?php esc_html_e('YouTube', 'nortic-plugin'); ?></h2>
                <p><?php esc_html_e('Do not you have an account yet? Go to', 'nortic-plugin'); ?> <a href="https://www.youtube.com/" target="_blank">YouTube</a></p>
                <table class="form-table">
                    <tbody>

                        <!-- YouTube Profile URL -->
                        <tr>
                            <th>
                                <label for="np_youtube_url">
                                    <?php esc_html_e('Profile URL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_youtube_url" type="text" id="np_youtube_url" class="regular-text" value="<?php echo esc_attr($options['np_youtube_url']); ?>" />
                                <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- YouTube link color -->
                        <tr>
                            <th>
                                <label for="np_youtube_color">
                                    <?php esc_html_e('HEX Color', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_youtube_color" type="text" id="np_youtube_color" class="regular-text" value="<?php echo esc_attr($options['np_youtube_color']); ?>" />
                                <button type="button" style="background-color: <?php echo esc_attr($options['np_youtube_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-youtube"></span></button>
                                <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Show Youtube button in Feed -->
                        <tr>
                            <th>
                                <label for="np_youtube_enable">
                                    <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_youtube_enable" type="checkbox" id="np_youtube_enable" value="1" <?php checked(esc_attr($options['np_youtube_enable']), 1); ?> />
                            </td>
                        </tr>

                    </tbody>
                </table>

                <hr>
                <h2><span class="dashicons dashicons-linkedin" style="margin-right: 1rem;"></span><?php esc_html_e('LinkedIn', 'nortic-plugin'); ?></h2>
                <p><?php esc_html_e('Do not you have an account yet? Go to', 'nortic-plugin'); ?> <a href="https://www.linkedin.com/" target="_blank">LinkedIn</a></p>
                <table class="form-table">
                    <tbody>

                        <!-- LinkedIn Profile URL -->
                        <tr>
                            <th>
                                <label for="np_linkedin_url">
                                    <?php esc_html_e('Profile URL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_linkedin_url" type="text" id="np_linkedin_url" class="regular-text" value="<?php echo esc_attr($options['np_linkedin_url']); ?>" />
                                <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- LinkedIn link color -->
                        <tr>
                            <th>
                                <label for="np_linkedin_color">
                                    <?php esc_html_e('HEX Color', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_linkedin_color" type="text" id="np_linkedin_color" class="regular-text" value="<?php echo esc_attr($options['np_linkedin_color']); ?>" />
                                <button type="button" style="background-color: <?php echo esc_attr($options['np_linkedin_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-linkedin"></span></button>
                                <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Show LinkedIn button in Feed -->
                        <tr>
                            <th>
                                <label for="np_linkedin_enable">
                                    <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_linkedin_enable" type="checkbox" id="np_linkedin_enable" value="1" <?php checked(esc_attr($options['np_linkedin_enable']), 1); ?> />
                            </td>
                        </tr>

                    </tbody>
                </table>

                <hr>
                <h2><span class="dashicons dashicons-format-gallery" style="margin-right: 1rem;"></span><?php esc_html_e('Flickr', 'nortic-plugin'); ?></h2>
                <p><?php esc_html_e('Do not you have an account yet? Go to', 'nortic-plugin'); ?> <a href="https://flickr.com/" target="_blank">Flickr</a></p>
                <table class="form-table">
                    <tbody>

                        <!-- LinkedIn Profile URL -->
                        <tr>
                            <th>
                                <label for="np_flickr_url">
                                    <?php esc_html_e('Profile URL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_flickr_url" type="text" id="np_flickr_url" class="regular-text" value="<?php echo esc_attr($options['np_flickr_url']); ?>" />
                                <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- LinkedIn link color -->
                        <tr>
                            <th>
                                <label for="np_flickr_color">
                                    <?php esc_html_e('HEX Color', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_flickr_color" type="text" id="np_flickr_color" class="regular-text" value="<?php echo esc_attr($options['np_flickr_color']); ?>" />
                                <button type="button" style="background-color: <?php echo esc_attr($options['np_flickr_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-format-gallery"></span></button>
                                <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Show LinkedIn button in Feed -->
                        <tr>
                            <th>
                                <label for="np_flickr_enable">
                                    <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_flickr_enable" type="checkbox" id="np_flickr_enable" value="1" <?php checked(esc_attr($options['np_flickr_enable']), 1); ?> />
                            </td>
                        </tr>

                    </tbody>
                </table>

                <hr>
                <h2><span class="dashicons dashicons-pinterest" style="margin-right: 1rem;"></span><?php esc_html_e('Pinterest', 'nortic-plugin'); ?></h2>
                <p><?php esc_html_e('Do not you have an account yet? Go to', 'nortic-plugin'); ?> <a href="https://www.pinterest.com/" target="_blank">Pinterest</a></p>
                <table class="form-table">
                    <tbody>

                        <!-- LinkedIn Profile URL -->
                        <tr>
                            <th>
                                <label for="np_pinterest_url">
                                    <?php esc_html_e('Profile URL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_pinterest_url" type="text" id="np_pinterest_url" class="regular-text" value="<?php echo esc_attr($options['np_pinterest_url']); ?>" />
                                <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- LinkedIn link color -->
                        <tr>
                            <th>
                                <label for="np_pinterest_color">
                                    <?php esc_html_e('HEX Color', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_pinterest_color" type="text" id="np_pinterest_color" class="regular-text" value="<?php echo esc_attr($options['np_pinterest_color']); ?>" />
                                <button type="button" style="background-color: <?php echo esc_attr($options['np_pinterest_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-pinterest"></span></button>
                                <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Show LinkedIn button in Feed -->
                        <tr>
                            <th>
                                <label for="np_pinterest_enable">
                                    <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_pinterest_enable" type="checkbox" id="np_pinterest_enable" value="1" <?php checked(esc_attr($options['np_pinterest_enable']), 1); ?> />
                            </td>
                        </tr>

                    </tbody>
                </table>

                <hr>
                <h2><span class="dashicons dashicons-whatsapp" style="margin-right: 1rem;"></span><?php esc_html_e('WhatsApp', 'nortic-plugin'); ?></h2>
                <table class="form-table">
                    <tbody>

                        <!-- LinkedIn Profile URL -->
                        <tr>
                            <th>
                                <label for="np_whatsapp_url">
                                    <?php esc_html_e('Profile URL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_whatsapp_url" type="text" id="np_whatsapp_url" class="regular-text" value="<?php echo esc_attr($options['np_whatsapp_url']); ?>" />
                                <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- LinkedIn link color -->
                        <tr>
                            <th>
                                <label for="np_whatsapp_color">
                                    <?php esc_html_e('HEX Color', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_whatsapp_color" type="text" id="np_whatsapp_color" class="regular-text" value="<?php echo esc_attr($options['np_whatsapp_color']); ?>" />
                                <button type="button" style="background-color: <?php echo esc_attr($options['np_whatsapp_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-whatsapp"></span></button>
                                <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>
                        <!-- Show LinkedIn button in Feed -->
                        <tr>
                            <th>
                                <label for="np_whatsapp_enable">
                                    <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_whatsapp_enable" type="checkbox" id="np_whatsapp_enable" value="1" <?php checked(esc_attr($options['np_whatsapp_enable']), 1); ?> />
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
