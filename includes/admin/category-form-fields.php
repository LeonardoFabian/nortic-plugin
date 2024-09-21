<?php

if (!function_exists('nortic_plugin_category_add_form_fields')) {
    /**
     * Add form fields to category
     *
     * @return void
     */
    function nortic_plugin_category_add_form_fields()
    {
?>
        <!-- color -->
        <div class="form-field term-color-wrap">
            <label><?php _e('Color', 'nortic-plugin'); ?></label>
            <input type="text" name="taxonomy_color" />
            <p><?php esc_attr_e('HEX color code, for example: #FFFFFF', 'nortic-plugin'); ?></p>
        </div>

    <?php
    }
}

if (!function_exists('nortic_plugin_category_edit_form_fields')) {
    function nortic_plugin_category_edit_form_fields($term)
    {
        $color = get_term_meta(
            $term->term_id,
            'taxonomy_color',
            true
        );

    ?>
        <!-- more info url -->
        <tr class="form-field">
            <th>
                <label><?php esc_attr_e('Color', 'nortic-plugin'); ?></label>
            </th>
            <td>
                <input type="text" name="taxonomy_color" value="<?php echo $color; ?>" />
                <p class="description"><?php _e('HEX color code, for example: #FFFFFF', 'nortic-plugin'); ?></p>
            </td>
        </tr>

<?php
    }
}
