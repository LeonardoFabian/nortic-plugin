<?php

if (!function_exists('nortic_plugin_area_add_form_fields')) {
    /**
     * Add form fields to area taxonomy
     *
     * @return void
     */
    function nortic_plugin_area_add_form_fields()
    {
        $options = [
            [
                "name" => "Oranismos Consultivos",
                "value" => 'organismos-consultivos'
            ],
            [
                "name" => "Viceministerios",
                "value" => 'viceministerios'
            ],
            [
                "name" => "Direcciones Generales",
                "value" => 'direcciones-generales'
            ],
            [
                "name" => "Direcciones",
                "value" => 'direcciones'
            ],
            [
                "name" => "Departamentos",
                "value" => 'departamentos'
            ],
            [
                "name" => "Divisiones",
                "value" => 'divisiones'
            ],
            [
                "name" => "Secciones",
                "value" => 'secciones'
            ],
        ];
?>
        <div class="form-field">
            <label><?php _e('Classification', 'nortic-plugin'); ?></label>
            <select name="area_classification" class="postform">
                <option value="-1"><?php _e('None', 'nortic-plugin'); ?></option>
                <?php foreach ($options as $key => $option) : ?>
                    <option class="classification-<?php echo $key; ?>" value="<?php echo $option['value'] ?>"><?php echo $option['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php
    }
}

if (!function_exists('nortic_plugin_area_edit_form_fields')) {
    function nortic_plugin_area_edit_form_fields($term)
    {
        $classification = get_term_meta(
            $term->term_id,
            'area_classification',
            true
        );

        $options = [
            [
                "name" => "Oranismos Consultivos",
                "value" => 'organismos-consultivos'
            ],
            [
                "name" => "Viceministerios",
                "value" => 'viceministerios'
            ],
            [
                "name" => "Direcciones Generales",
                "value" => 'direcciones-generales'
            ],
            [
                "name" => "Direcciones",
                "value" => 'direcciones'
            ],
            [
                "name" => "Departamentos",
                "value" => 'departamentos'
            ],
            [
                "name" => "Divisiones",
                "value" => 'divisiones'
            ],
            [
                "name" => "Secciones",
                "value" => 'secciones'
            ],
        ];

    ?>
        <!-- more info url -->
        <tr class="form-field">
            <th>
                <label><?php esc_attr_e('Classification', 'nortic-plugin'); ?></label>
            </th>
            <td>
                <select name="area_classification" class="postform">
                    <option value="-1"><?php _e('None', 'nortic-plugin'); ?></option>
                    <?php foreach ($options as $key => $option) : ?>
                        <option class="classification-<?php echo $key; ?>" value="<?php echo $option['value'] ?>" <?php selected($option['value'], $classification); ?>><?php echo $option['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
<?php
    }
}
