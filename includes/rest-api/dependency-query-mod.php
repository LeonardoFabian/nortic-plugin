<?php

if (!function_exists('nortic_plugin_rest_dependency_query')) {
    /**
     * Modify the rest dependency query loop
     *
     * @return void
     */
    function nortic_plugin_rest_dependency_query($args, $request)
    {
        $orderByName = $request->get_param('orderByName');

        if (isset($orderByName)) {
            $args['orderby'] = 'title';
        }

        return $args;
    }
}
