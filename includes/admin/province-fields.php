<?php 

if(!function_exists('nortic_plugin_province_add_form_fields')) {
    function nortic_plugin_province_add_form_fields() {
        
        ?>
        <!-- SVG path -->
        <div class="form-field rd-trabaja-province-id-wrap">
            <div class="form-field">
                <label for="svg-path"><?php _e('RD-Trabaja province ID', 'nortic-plugin'); ?></label>
                <input type="number" name="rd_trabaja_province_id" />
                <p><?php esc_attr_e('Enter the ID assigned to the province in RD-Trabaja', 'nortic-plugin'); ?></p>
            </div>
        </div>
        <!-- SVG path -->
        <div class="form-field term-svg-path-wrap">
            <div class="form-field">
                <label for="svg-path"><?php _e('SVG Path', 'nortic-plugin'); ?></label>
                <textarea name="svg_path" id="svg-path" rows="5" cols="40" aria-describedby="svg-path-description"></textarea>
                <p id="svg-path-description" class="description"><?php _e('Add a svg path to show a map of the province', 'nortic-plugin'); ?></p>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('nortic_plugin_province_edit_form_fields')) {
    function nortic_plugin_province_edit_form_fields($term) {
        // get province IDs from https://empleateya.mt.gob.do/api/conceptos
        $rd_trabaja_province_id = get_term_meta(
            $term->term_id,
            'rd_trabaja_province_id',
            true
        );
        $svg_path = get_term_meta(
            $term->term_id,
            'svg_path',
            true
        );       

        ?> 
        <!-- RD-Trabaja province ID -->
        <tr class="form-field">
            <th>
                <label><?php esc_attr_e('RD-Trabaja province ID', 'nortic-plugin'); ?></label>
            </th>
            <td>
                <input type="number" name="rd_trabaja_province_id" value="<?php echo $rd_trabaja_province_id; ?>" />
                <p class="description"><?php _e('Replace the ID assigned to the province in RD-Trabaja', 'nortic-plugin'); ?></p>
            </td>
        </tr>
            <tr class="form-field">
                <th>
                    <label><?php _e('SVG Path', 'nortic-plugin'); ?></label>
                </th>
                <td>
                <textarea name="svg_path" id="svg-path" rows="5" cols="40" aria-describedby="svg-path-description" value="<?php echo $svg_path; ?>"></textarea>
                <p id="svg-path-description" class="description"><?php _e('Add a svg path to show a map of the province', 'nortic-plugin'); ?></p>
                </td>
            </tr>
        <?php
    }
}