<?php

if (!function_exists('nortic_plugin_rest_service_query')) {
    /**
     * Modify the service rest query loop
     *
     * @return void
     */
    function nortic_plugin_rest_service_query($args, $request)
    {
        $orderBy = $request->get_param('orderByRating');

        if (isset($orderBy)) {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'rating';
        }

        return $args;
    }
}
