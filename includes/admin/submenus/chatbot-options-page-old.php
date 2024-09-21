<?php

if (!function_exists('nortic_plugin_chatbot_options_page')) {
    /**
     * Load Chatbot block settings page in the admin plugin menu.
     *
     * @return void
     */
    function nortic_plugin_chatbot_options_page()
    {
        $options = get_option('nortic_plugin_chatbot_options');
?>
        <div class="wrap">
            <h1><?php esc_html_e('Chatbot Settings', 'nortic-plugin'); ?></h1>
            <p><?php esc_html_e('Chatbot uses ChatGPT, the AI (Artificial Intelligence) chatbot prototype developed by OpenAI to generate dialogues with users. You need to provide an OpenAI API KEY to enable chat.', 'nortic-plugin'); ?></p>
            <p><?php esc_html_e('Create your OpenAI account in', 'nortic-plugin'); ?> <a href="https://auth0.openai.com/u/signup/identifier?state=hKFo2SBwV0FvQWdkNEJrVjNEVzRsMXBVdTdpRThIZGo2cnFwR6Fur3VuaXZlcnNhbC1sb2dpbqN0aWTZIDBNeG9ZOEl0UWtuOWR5b2VvRi1KNkdGZ1RUQXN2WmNLo2NpZNkgRFJpdnNubTJNdTQyVDNLT3BxZHR3QjNOWXZpSFl6d0Q" target="_blank">OpenAI</a></p>

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

                <input type="hidden" name="action" value="np_chatbot_save_options" />

                <?php wp_nonce_field('nortic_plugin_chatbot_options_verify'); ?>

                <table class="form-table">
                    <tbody>
                        <!-- OpenAI API KEY -->
                        <tr>
                            <th>
                                <label for="np_chatbot_openai_apikey">
                                    <?php esc_html_e('OPENAI AI API KEY', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <textarea id="np_chatbot_openai_apikey" name="np_chatbot_openai_apikey" class="large-text"><?php echo esc_attr($options['np_chatbot_openai_apikey']); ?></textarea>
                            </td>
                        </tr>
                        <!-- OpenAI Model -->
                        <tr>
                            <th>
                                <label for="np_chatbot_openai_model">
                                    <?php esc_html_e('OPENAI MODEL', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_chatbot_openai_model" type="text" id="np_chatbot_openai_model" class="regular-text" value="<?php echo esc_attr($options['np_chatbot_openai_model']); ?>" />
                                <p class="description"><?php esc_html_e('ID of the model to use. You can use the text-davinci-003 model with this endpoint.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>

                        <!-- OpenAI Temperature -->
                        <tr>
                            <th>
                                <label for="np_chatbot_openai_temperature">
                                    <?php esc_html_e('OPENAI TEMPERATURE', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_chatbot_openai_temperature" type="text" id="np_chatbot_openai_temperature" class="regular-text" value="<?php echo esc_attr($options['np_chatbot_openai_temperature']); ?>" />
                                <p class="description"><?php esc_html_e('What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>

                        <!-- OpenAI Top P -->
                        <tr>
                            <th>
                                <label for="np_chatbot_openai_top_p">
                                    <?php esc_html_e('OPENAI TOP P', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_chatbot_openai_top_p" type="text" id="np_chatbot_openai_top_p" class="regular-text" value="<?php echo esc_attr($options['np_chatbot_openai_top_p']); ?>" />
                                <p class="description"><?php esc_html_e('An alternative to sampling with temperature, called nucleus sampling, where the model considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top 10% probability mass are considered.', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>

                        <!-- OpenAI Max Tokens -->
                        <tr>
                            <th>
                                <label for="np_chatbot_openai_max_tokens">
                                    <?php esc_html_e('OPENAI MAX TOKENS', 'nortic-plugin'); ?>
                                </label>
                            </th>
                            <td>
                                <input name="np_chatbot_openai_max_tokens" type="text" id="np_chatbot_openai_max_tokens" class="regular-text" value="<?php echo esc_attr($options['np_chatbot_openai_max_tokens']); ?>" />
                                <p class="description"><?php esc_html_e('The maximum number of tokens to generate in the completion. The token count of your prompt plus max_tokens cannot exceed the model\'s context length. Most models have a context length of 2048 tokens (except for the newest models, which support 4096).', 'nortic-plugin'); ?></p>
                            </td>
                        </tr>


                        <!-- Enable OpenAI Chatbot -->
                        <tr>
                            <th>
                                <?php esc_html_e('Enable', 'nortic-plugin'); ?>
                            </th>
                            <td>
                                <label for="np_enable_chatbot">
                                    <input name="np_enable_chatbot" type="checkbox" id="np_enable_chatbot" value="1" <?php checked(esc_attr($options['np_enable_chatbot']), 1); ?> />
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
