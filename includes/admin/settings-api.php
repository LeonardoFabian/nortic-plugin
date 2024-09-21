<?php

if (!function_exists('nortic_plugin_settings_api')) {
    /**
     * Register all plugin settings group
     *
     * @return void
     */
    function nortic_plugin_settings_api()
    {
        register_setting(
            'nortic_plugin_options_group',
            'nortic_plugin_options',
        );

        register_setting(
            'nortic_plugin_options_group',
            'nortic_plugin_opengraph_options',
        );

        register_setting(
            'nortic_plugin_options_group',
            'nortic_plugin_chatbot_options'
        );


        add_settings_section(
            'nortic_plugin_options_section',
            __('Nortic Plugin Settings', 'nortic-plugin'),
            'nortic_plugin_options_section_cb',
            'nortic-plugin-options-page'
        );

        add_settings_section(
            'nortic_plugin_opengraph_options_section',
            __('Manage Open Graph Settings', 'nortic-plugin'),
            'nortic_plugin_opengraph_options_section_cb',
            'nortic-plugin-opengraph-options-page'
        );

        add_settings_section(
            'nortic_plugin_chatbot_options_section',
            __('OpenAI Settings', 'nortic-plugin'),
            'nortic_plugin_chatbot_options_section_cb',
            'nortic-plugin-chatbot-options-page'
        );

        add_settings_section(
            'nortic_plugin_social_networks_options_section',
            __('Social network settings', 'nortic-plugin'),
            'nortic_plugin_social_networks_options_section_cb',
            'nortic-plugin-social-networks-options-page'
        );

        /**
         * Settings Fields
         */

        add_settings_field(
            'np_og_title',
            __('Open Graph Title', 'nortic-plugin'),
            'np_og_title_input_cb',
            'nortic-plugin-opengraph-options-page',
            'nortic_plugin_opengraph_options_section'
        );

        add_settings_field(
            'np_og_image',
            __('Open Graph Image', 'nortic-plugin'),
            'np_og_image_input_cb',
            'nortic-plugin-opengraph-options-page',
            'nortic_plugin_opengraph_options_section'
        );

        add_settings_field(
            'np_og_description',
            __('Open Graph Description', 'nortic-plugin'),
            'np_og_description_input_cb',
            'nortic-plugin-opengraph-options-page',
            'nortic_plugin_opengraph_options_section'
        );

        add_settings_field(
            'np_enable_og',
            __('Enable Open Graph', 'nortic-plugin'),
            'np_enable_og_input_cb',
            'nortic-plugin-opengraph-options-page',
            'nortic_plugin_opengraph_options_section'
        );

        add_settings_field(
            'np_chatbot_openai_apikey',
            __('OPENAI API KEY', 'nortic-plugin'),
            'np_chatbot_openai_apikey_input_cb',
            'nortic-plugin-chatbot-options-page',
            'nortic_plugin_chatbot_options_section'
        );

        add_settings_field(
            'np_chatbot_openai_model',
            __('OPENAI MODEL', 'nortic-plugin'),
            'np_chatbot_openai_model_input_cb',
            'nortic-plugin-chatbot-options-page',
            'nortic_plugin_chatbot_options_section'
        );

        add_settings_field(
            'np_chatbot_openai_temperature',
            __('OPENAI TEMPERATURE', 'nortic-plugin'),
            'np_chatbot_openai_temperature_input_cb',
            'nortic-plugin-chatbot-options-page',
            'nortic_plugin_chatbot_options_section'
        );

        add_settings_field(
            'np_chatbot_openai_top_p',
            __('OPENAI TOP P', 'nortic-plugin'),
            'np_chatbot_openai_top_p_input_cb',
            'nortic-plugin-chatbot-options-page',
            'nortic_plugin_chatbot_options_section'
        );

        add_settings_field(
            'np_chatbot_openai_max_tokens',
            __('OPENAI MAX TOKENS', 'nortic-plugin'),
            'np_chatbot_openai_max_tokens_input_cb',
            'nortic-plugin-chatbot-options-page',
            'nortic_plugin_chatbot_options_section'
        );

        add_settings_field(
            'np_enable_chatbot',
            __('Enable', 'nortic-plugin'),
            'np_enable_chatbot_input_cb',
            'nortic-plugin-chatbot-options-page',
            'nortic_plugin_chatbot_options_section'
        );

        add_settings_field(
            'np_facebook_url',
            __('Facebook', 'nortic-plugin'),
            'np_facebook_url_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_facebook_color',
            __('Facebook HEX Color', 'nortic-plugin'),
            'np_facebook_color_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_facebook_enable',
            __('Enable Facebook'),
            'np_facebook_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_instagram_url',
            __('Instagram'),
            'np_instagram_url_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_instagram_color',
            __('Instagram HEX Color'),
            'np_instagram_color_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_instagram_enable',
            __('Enable Instagram'),
            'np_instagram_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_twitter_url',
            __('Twitter'),
            'np_twitter_url_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_twitter_color',
            __('Twitter HEX color'),
            'np_twitter_color_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_twitter_enable',
            __('Enable Twitter'),
            'np_twitter_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_youtube_url',
            __('YouTube'),
            'np_youtube_url_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_youtube_color',
            __('YouTube HEX color'),
            'np_youtube_color_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_youtube_enable',
            __('Enable YouTube'),
            'np_youtube_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_linkedin_url',
            __('LinkedIn', 'nortic-plugin'),
            'np_linkedin_url_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_linkedin_color',
            __('LinkedIn HEX color', 'nortic-plugin'),
            'np_linkedin_color_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_linkedin_enable',
            __('Enable LinkedIn', 'nortic-plugin'),
            'np_linkedin_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_linkedin_enable',
            __('Enable LinkedIn', 'nortic-plugin'),
            'np_linkedin_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_flickr_url',
            __('Flickr', 'nortic-plugin'),
            'np_flickr_url_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_flickr_color',
            __('Flickr HEX color', 'nortic-plugin'),
            'np_flickr_color_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_flickr_enable',
            __('Enable Flickr', 'nortic-plugin'),
            'np_flickr_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_pinterest_url',
            __('Pinterest', 'nortic-plugin'),
            'np_pinterest_url_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_pinterest_color',
            __('Pinterest HEX color', 'nortic-plugin'),
            'np_pinterest_color_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_pinterest_enable',
            __('Enable Pinterest'),
            'np_pinterest_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_whatsapp_url',
            __('WhatsApp', 'nortic-plugin'),
            'np_whatsapp_url_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_whatsapp_color',
            __('WhatsApp HEX color', 'nortic-plugin'),
            'np_whatsapp_color_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        add_settings_field(
            'np_whatsapp_enable',
            __('Enable WhatsApp', 'nortic-plugin'),
            'np_whatsapp_enable_input_cb',
            'nortic-plugin-social-networks-options-page',
            'nortic_plugin_social_networks_options_section'
        );

        function np_whatsapp_enable_input_cb()
        {
            $options = get_option('nortic_plugin_options');
?>
            <input name="nortic_plugin_options[np_whatsapp_enable]" type="checkbox" id="np_whatsapp_enable" value="1" <?php checked(esc_attr($options['np_whatsapp_enable']), 1); ?> />
        <?php
        }

        function np_whatsapp_color_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_whatsapp_color]" type="text" id="np_whatsapp_color" class="regular-text" value="<?php echo esc_attr($options['np_whatsapp_color']); ?>" />
            <button type="button" style="background-color: <?php echo esc_attr($options['np_whatsapp_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-whatsapp"></span></button>
            <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_whatsapp_url_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_whatsapp_url]" type="text" id="np_whatsapp_url" class="regular-text" value="<?php echo esc_attr($options['np_whatsapp_url']); ?>" />
            <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_pinterest_enable_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_pinterest_enable]" type="checkbox" id="np_pinterest_enable" value="1" <?php checked(esc_attr($options['np_pinterest_enable']), 1); ?> />

            <hr>
        <?php
        }

        function np_pinterest_color_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_pinterest_color]" type="text" id="np_pinterest_color" class="regular-text" value="<?php echo esc_attr($options['np_pinterest_color']); ?>" />
            <button type="button" style="background-color: <?php echo esc_attr($options['np_pinterest_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-pinterest"></span></button>
            <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_pinterest_url_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_pinterest_url]" type="text" id="np_pinterest_url" class="regular-text" value="<?php echo esc_attr($options['np_pinterest_url']); ?>" />
            <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_flickr_enable_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_flickr_enable]" type="checkbox" id="np_flickr_enable" value="1" <?php checked(esc_attr($options['np_flickr_enable']), 1); ?> />

            <hr>
        <?php
        }

        function np_flickr_color_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_flickr_color]" type="text" id="np_flickr_color" class="regular-text" value="<?php echo esc_attr($options['np_flickr_color']); ?>" />
            <button type="button" style="background-color: <?php echo esc_attr($options['np_flickr_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-format-gallery"></span></button>
            <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_flickr_url_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_flickr_url]" type="text" id="np_flickr_url" class="regular-text" value="<?php echo esc_attr($options['np_flickr_url']); ?>" />
            <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_linkedin_enable_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_linkedin_enable]" type="checkbox" id="np_linkedin_enable" value="1" <?php checked(esc_attr($options['np_linkedin_enable']), 1); ?> />

            <hr>
        <?php
        }

        function np_linkedin_color_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_linkedin_color]" type="text" id="np_linkedin_color" class="regular-text" value="<?php echo esc_attr($options['np_linkedin_color']); ?>" />
            <button type="button" style="background-color: <?php echo esc_attr($options['np_linkedin_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-linkedin"></span></button>
            <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_linkedin_url_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_linkedin_url]" type="text" id="np_linkedin_url" class="regular-text" value="<?php echo esc_attr($options['np_linkedin_url']); ?>" />
            <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_youtube_enable_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_youtube_enable]" type="checkbox" id="np_youtube_enable" value="1" <?php checked(esc_attr($options['np_youtube_enable']), 1); ?> />

            <hr>
        <?php
        }

        function np_youtube_color_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_youtube_color]" type="text" id="np_youtube_color" class="regular-text" value="<?php echo esc_attr($options['np_youtube_color']); ?>" />
            <button type="button" style="background-color: <?php echo esc_attr($options['np_youtube_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-youtube"></span></button>
            <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_youtube_url_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_youtube_url]" type="text" id="np_youtube_url" class="regular-text" value="<?php echo esc_attr($options['np_youtube_url']); ?>" />
            <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_twitter_enable_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_twitter_enable]" type="checkbox" id="np_twitter_enable" value="1" <?php checked(esc_attr($options['np_twitter_enable']), 1); ?> />

            <hr>
        <?php
        }

        function np_twitter_color_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_twitter_color]" type="text" id="np_twitter_color" class="regular-text" value="<?php echo esc_attr($options['np_twitter_color']); ?>" />
            <button type="button" style="background-color: <?php echo esc_attr($options['np_twitter_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-twitter"></span></button>
            <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_twitter_url_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_twitter_url]" type="text" id="np_twitter_url" class="regular-text" value="<?php echo esc_attr($options['np_twitter_url']); ?>" />
            <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_instagram_enable_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_instagram_enable]" type="checkbox" id="np_instagram_enable" value="1" <?php checked(esc_attr($options['np_instagram_enable']), 1); ?> />

            <hr>
        <?php
        }

        function np_instagram_color_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_instagram_color]" type="text" id="np_instagram_color" class="regular-text" value="<?php echo esc_attr($options['np_instagram_color']); ?>" />
            <button type="button" style="background-color: <?php echo esc_attr($options['np_instagram_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-instagram"></span></button>
            <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_instagram_url_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_instagram_url]" type="text" id="np_instagram_url" class="regular-text" value="<?php echo esc_attr($options['np_instagram_url']); ?>" />
            <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_facebook_enable_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_facebook_enable]" type="checkbox" id="np_facebook_enable" value="1" <?php checked(esc_attr($options['np_facebook_enable']), 1); ?> />

            <hr>
        <?php
        }

        function np_facebook_color_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_facebook_color]" type="text" id="np_facebook_color" class="regular-text" value="<?php echo esc_attr($options['np_facebook_color']); ?>" />
            <button type="button" style="background-color: <?php echo esc_attr($options['np_facebook_color']); ?>;color: #fff; text-align: center; border: none; padding: .5rem; border-radius: .5rem;"><span class="dashicons dashicons-facebook"></span></button>
            <p class="description"><?php esc_html_e('Enter a social network HEX color or your custom HEX value with a # prefix.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_facebook_url_input_cb()
        {
            $options = get_option('nortic_plugin_options');
        ?>
            <input name="nortic_plugin_options[np_facebook_url]" type="text" id="np_facebook_url" class="regular-text" value="<?php echo esc_attr($options['np_facebook_url']); ?>" />
            <p class="description"><?php esc_html_e('Enter your profile URL', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_enable_chatbot_input_cb()
        {
            $options = get_option('nortic_plugin_chatbot_options');
        ?>
            <label for="np_enable_chatbot">
                <input name="nortic_plugin_chatbot_options[np_enable_chatbot]" type="checkbox" id="np_enable_chatbot" value="1" <?php checked(esc_attr($options['np_enable_chatbot']), 1); ?> />
                <span><?php esc_html_e('Enable', 'nortic-plugin'); ?></span>
            </label>
        <?php
        }

        function np_chatbot_openai_max_tokens_input_cb()
        {
            $options = get_option('nortic_plugin_chatbot_options');
        ?>
            <input name="nortic_plugin_chatbot_options[np_chatbot_openai_max_tokens]" type="text" id="np_chatbot_openai_max_tokens" class="regular-text" value="<?php echo esc_attr($options['np_chatbot_openai_max_tokens']); ?>" />
            <p class="description"><?php esc_html_e('The maximum number of tokens to generate in the completion. The token count of your prompt plus max_tokens cannot exceed the model\'s context length. Most models have a context length of 2048 tokens (except for the newest models, which support 4096).', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_chatbot_openai_top_p_input_cb()
        {
            $options = get_option('nortic_plugin_chatbot_options');
        ?>
            <input name="nortic_plugin_chatbot_options[np_chatbot_openai_top_p]" type="text" id="np_chatbot_openai_top_p" class="regular-text" value="<?php echo esc_attr($options['np_chatbot_openai_top_p']); ?>" />
            <p class="description"><?php esc_html_e('An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_chatbot_openai_temperature_input_cb()
        {
            $options = get_option('nortic_plugin_chatbot_options');
        ?>
            <input name="nortic_plugin_chatbot_options[np_chatbot_openai_temperature]" type="text" id="np_chatbot_openai_temperature" class="regular-text" value="<?php echo esc_attr($options['np_chatbot_openai_temperature']); ?>" />
            <p class="description"><?php esc_html_e('What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_chatbot_openai_model_input_cb()
        {
            $options = get_option('nortic_plugin_chatbot_options');
        ?>
            <input name="nortic_plugin_chatbot_options[np_chatbot_openai_model]" type="text" id="np_chatbot_openai_model" class="regular-text" value="<?php echo esc_attr($options['np_chatbot_openai_model']); ?>" />
            <p class="description"><?php esc_html_e('ID of the model to use. You can use the text-davinci-003 model with this endpoint.', 'nortic-plugin'); ?></p>
        <?php
        }

        function np_chatbot_openai_apikey_input_cb()
        {
            $options = get_option('nortic_plugin_chatbot_options');
        ?>
            <textarea id="np_chatbot_openai_apikey" name="nortic_plugin_chatbot_options[np_chatbot_openai_apikey]" class="large-text"><?php echo esc_attr($options['np_chatbot_openai_apikey']); ?></textarea>
        <?php
        }

        function np_enable_og_input_cb()
        {
            $options = get_option('nortic_plugin_opengraph_options');
        ?>
            <input name="nortic_plugin_opengraph_options[np_enable_og]" type="checkbox" id="np_enable_og" value="1" <?php checked(esc_attr($options['np_enable_og']), 1); ?> />
            <span><?php esc_html_e('Enable', 'nortic-plugin'); ?></span>
        <?php
        }

        function np_og_description_input_cb()
        {
            $options = get_option('nortic_plugin_opengraph_options');
        ?>
            <textarea id="np_og_description" name="nortic_plugin_opengraph_options[np_og_description]" class="large-text"><?php echo esc_attr($options['np_og_description']); ?></textarea>
        <?php
        }

        function np_og_title_input_cb()
        {
            $options = get_option('nortic_plugin_opengraph_options');
        ?>
            <input name="nortic_plugin_opengraph_options[np_og_title]" type="text" id="np_og_title" class="regular-text" value="<?php echo esc_attr($options['np_og_title']); ?>" />
        <?php
        }

        function np_og_image_input_cb()
        {
            $options = get_option('nortic_plugin_opengraph_options');
        ?>
            <div class="nortic-image-preview-container">
                <input type="hidden" name="nortic_plugin_opengraph_options[np_og_image]" id="np_og_image" value="<?php echo esc_attr($options['np_og_image']); ?>" />
                <img id="np-og-img-preview" src="<?php echo esc_attr($options['np_og_image']); ?>">
            </div>
            <p class="description"><?php esc_html_e('Image', 'nortic-plugin'); ?> (1200px x 630px)</p>
            <a href="#" class="button-primary" id="np-og-img-upload-btn">
                <?php esc_html_e('Select Image', 'nortic-plugin'); ?>
            </a>
        <?php
        }

        function nortic_plugin_options_section_cb()
        {
        ?>
            <p>Plugin Option page</p>
        <?php
        }

        /**
         * Render Open Graph Options section
         *
         * @return void
         */
        function nortic_plugin_opengraph_options_section_cb()
        {
        ?>
            <p><?php esc_html_e('Open Graph control how your website is being displayed on Facebook. Now, other social media sites such as Twitter, LinkedIn are recognizing Open Graph meta tags.', 'nortic-plugin'); ?></p>
            <p><?php esc_html_e('More details in', 'nortic-plugin'); ?> <a href="https://www.opengraph.xyz/" target="_blank">Open Graph</a></p>
        <?
        }

        /**
         * Render OpenAI Options section
         *
         * @return void
         */
        function nortic_plugin_chatbot_options_section_cb()
        {
        ?>
            <p><?php esc_html_e('Chatbot uses ChatGPT, the AI (Artificial Intelligence) chatbot prototype developed by OpenAI to generate dialogues with users. You need to provide an OpenAI API KEY to enable chat.', 'nortic-plugin'); ?></p>
            <p><?php esc_html_e('Create your OpenAI account in', 'nortic-plugin'); ?> <a href="https://auth0.openai.com/" target="_blank">OpenAI</a></p>
        <?php
        }

        /**
         * Renderize social network options section
         *
         * @return void
         */
        function nortic_plugin_social_networks_options_section_cb()
        {
        ?>
            <p><?php esc_html_e('Increase your number of followers by adding the main social networks on your website.', 'nortic-plugin'); ?></p>
<?php
        }
    }
}
