<?php

if (!function_exists('nortic_plugin_add_meta_boxes')) {
    /**
     * Fires after all built-in plugin meta boxes have been added.
     *
     * @return void
     */
    function nortic_plugin_add_meta_boxes()
    {

        // Service parent Dependency meta box

        add_meta_box(
            'service_parent_dependency_metabox',
            __('Dependency', 'nortic-plugin'),
            'nortic_plugin_service_parent_dependency_render_cb',
            'service',
            'side',
            'high'
        );
    }
}

/* Render callback functions */

if (!function_exists('nortic_plugin_service_parent_dependency_render_cb')) {
    /**
     * Renderize Service parent Dependency meta box
     *
     * @param [type] $post
     * @return void
     */
    function nortic_plugin_service_parent_dependency_render_cb($post)
    {
        // $post_type_object = get_post_type_object($post->post_type);
        // $pages = wp_dropdown_pages(
        //     array(
        //         'post_type' => 'dependency',
        //         'selected' => $post->post_parent,
        //         'name' => 'parent_id',
        //         'show_option_none' => __('(no parent)'),
        //         'sort_column' => 'menu_order, post_title',
        //         'echo' => 0
        //     )
        // );

        // if (!empty($pages)) {
        //     echo $pages;
        // }

        // global $post;

        $selected_dependency = get_post_meta($post->ID, 'service_dependency_id', true);

        $selected_dependency =
            empty($selected_dependency)
            ? 0
            : intval($selected_dependency);



        // var_dump($post);

        // return;

        $args = array(
            'post_type' => 'dependency',
            'numberposts' => -1,
            'orderby' => 'post_title',
            'order' => 'ASC',
        );

        $dependencies = get_posts($args);

?>
        <div class="components-base-control">
            <div class="components-base-control__field">
                <div class="components-flex components-select-control">
                    <div class="components-input-control__container">
                        <select class="components-select-control__input" id="service_dependency_id" name="service_dependency_id" style="box-sizing: border-box;">
                            <option value="0"><?php echo esc_html__('(Select an option)', 'nortic-plugin'); ?></option>
                            <?php foreach ($dependencies as $dependency) : ?>
                                <option value="<?php echo $dependency->ID; ?>" <?php selected($selected_dependency, $dependency->ID, false); ?>>
                                    <?php echo $dependency->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
