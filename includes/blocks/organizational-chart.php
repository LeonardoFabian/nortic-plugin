<?php 

if (!function_exists('nortic_plugin_organizational_chart_render_cb')) {

/**
 * Renders a block that displays an organizational chart of team members.
 *
 * @param array  $attrs     The block's attributes.
 * @param string $content   The block's content.
 * @param object $block     The block object.
 *
 * @return string The rendered block.
 * @author Leonardo Fabian <ramon.fabian@mt.gob.do>
 * @date 2025-07-06
 * @version 1.0.0
 */
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

    /**
     * Builds a hierarchical tree structure of team members starting from a given parent ID.
     *
     * This function recursively retrieves and constructs an array representing the organizational
     * hierarchy of team members with the specified parent ID. Each node in the tree contains the
     * ID, title, content of the post, and its children nodes.
     *
     * @param int $parent_id The ID of the parent post to start building the tree from.
     * @return array An associative array representing the hierarchical structure. Each node
     *               includes 'id', 'title', 'content', and 'children'.
     * @author Leonardo Fabian <ramon.fabian@mt.gob.do>
     * @date 2025-07-06
     * @version 1.0.0
     */

    function nortic_plugin_build_team_tree($parent_id) {

        $parent = get_post($parent_id);
        if (!$parent) return [];

        $content = $parent->post_content; 
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);

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
            // $children[] = nortic_plugin_build_team_tree($dependency->ID);
            $child_content = apply_filters('the_content', $dependency->post_content);
            $child_content = str_replace(']]>', ']]&gt;', $child_content);

            $children[] = [
                'id' => $dependency->ID,
                'title' => get_the_title($dependency),
                'content' => $child_content,
                'children' => nortic_plugin_build_team_tree($dependency->ID)['children'] ?? [],
            ];
        }
  

        return [
            'id' => $parent->ID,
            'title' => get_the_title($parent),
            'children' => $children,
            'content' => $content,
        ];
    }
}