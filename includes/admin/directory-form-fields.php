<?php

if (!function_exists('nortic_plugin_directory_add_form_fields')) {
    /**
     * Add form fields to directory taxonomy
     *
     * @return void
     */
    function nortic_plugin_directory_add_form_fields()
    {
?>
        <!-- more info url -->
        <div class="form-field term-more-info-url-wrap">
            <label><?php _e('More Info URL', 'nortic-plugin'); ?></label>
            <input type="text" name="directory_more_info_url" />
            <p><?php esc_attr_e('A URL that the user can click to see more information about this directory', 'nortic-plugin'); ?></p>
        </div>
        <!-- directory order -->
        <div class="form-field term-ordering-wrap">
            <label><?php esc_attr_e('Directory Order', 'nortic-plugin'); ?></label>
            <input type="number" name="directory_ordering" />
            <p><?php esc_attr_e('Set the order number to be assigned to the directory', 'nortic-plugin'); ?></p>
        </div>
        <!-- published -->
        <div class="form-field term-published-wrap">
            <p><?php esc_attr_e('Published', 'nortic-plugin'); ?></p>
            <fieldset>
                <legend class="screen-reader-text"><span><?php esc_attr_e('Show directory to the public', 'nortic-plugin'); ?></span></legend>
                <label title="<?php esc_attr_e('Unpublish', 'nortic-plugin'); ?>">
                    <input type="radio" name="directory_published" value="no" />
                    <span><?php esc_attr_e('No', 'nortic-plugin') ?></span>
                </label>
                <label title="<?php esc_attr_e('Publish', 'nortic-plugin'); ?>">
                    <input type="radio" name="directory_published" value="yes" />
                    <span><?php esc_attr_e('Yes', 'nortic-plugin') ?></span>
                </label>
            </fieldset>
        </div>
    <?php
    }
}

if (!function_exists('nortic_plugin_directory_edit_form_fields')) {
    function nortic_plugin_directory_edit_form_fields($term)
    {
        $url = get_term_meta(
            $term->term_id,
            'more_info_url',
            true
        );

        $ordering = get_term_meta(
            $term->term_id,
            'ordering',
            true
        );

        $published = get_term_meta(
            $term->term_id,
            'published',
            true
        );
    ?>
        <!-- more info url -->
        <tr class="form-field">
            <th>
                <label><?php esc_attr_e('More Info URL', 'nortic-plugin'); ?></label>
            </th>
            <td>
                <input type="text" name="directory_more_info_url" value="<?php echo $url; ?>" />
                <p class="description"><?php _e('A URL that the user can click to see more information about this directory', 'nortic-plugin'); ?></p>
            </td>
        </tr>
        <!-- directory order -->
        <tr class="form-field">
            <th>
                <label><?php esc_attr_e('Directory Order', 'nortic-plugin'); ?></label>
            </th>
            <td>
                <input type="number" name="directory_ordering" />
                <p><?php esc_attr_e('Set the order number to be assigned to the directory', 'nortic-plugin'); ?></p>
            </td>
        </tr>
        <!-- published -->
        <tr class="form-field">
            <th>
                <p><?php esc_attr_e('Published', 'nortic-plugin'); ?></p>
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php esc_attr_e('Show directory to the public', 'nortic-plugin'); ?></span></legend>
                    <label title="<?php esc_attr_e('Unpublish', 'nortic-plugin'); ?>">
                        <input type="radio" name="directory_published" value="no" <?php checked('no' == $published); ?> />
                        <span><?php esc_attr_e('No', 'nortic-plugin') ?></span>
                    </label>
                    <label title="<?php esc_attr_e('Publish', 'nortic-plugin'); ?>">
                        <input type="radio" name="directory_published" value="yes" <?php checked('yes' == $published); ?> />
                        <span><?php esc_attr_e('Yes', 'nortic-plugin') ?></span>
                    </label>
                </fieldset>
            </td>
        </tr>
<?php
    }
}
