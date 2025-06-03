<?php 

if (!function_exists('nortic_plugin_organizational_chart_render_cb')) {
    function nortic_plugin_organizational_chart_render_cb($attrs, $content, $block) {
        $parent_id = absint($attrs['rootParentId']);
        $tree = nortic_plugin_build_team_tree($parent_id);

        ob_start();
        ?>

        <div class="wp-block-nortic-plugin-organizational-chart" data-tree="<?php echo esc_attr(json_encode($tree)); ?>"></div>

        <?php 
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    function nortic_plugin_build_team_tree($parent_id) {

        $parent = get_post($parent_id);
        if (!$parent) return [];

        $dependencies = get_posts([
            'post_type' => 'dependency',
            'post_status' => 'publish',
            'post_parent' => $parent_id,
            'numberposts' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ]);

        $children = [];
        foreach ($dependencies as $dependency) {
            $children[] = nortic_plugin_build_team_tree($dependency->ID);
        }
        // $children = array_map(function($dependency) use ($visited_ids) {
        //     return [
        //         'id' => $dependency->ID,
        //         'title' => get_the_title($dependency),
        //         'children' => nortic_plugin_build_team_tree($dependency->ID, $visited_ids),
        //         // 'position' => get_post_meta($member->ID, 'job_title', true),
        //         // 'image' => get_the_post_thumbnail_url($member->ID, 'thumbnail'),
        //         // 'description' => apply_filters('the_content', $member->post_content),
        //         // 'link' => get_permalink($member->ID)
        //     ];
        // }, $dependencies);

        // $parent = get_post($parent_id);
        // if (!$parent) {
        //     return [];
        // } 

        return [
            'id' => $parent->ID,
            'title' => get_the_title($parent),
            'children' => $children
        ];
    }
}