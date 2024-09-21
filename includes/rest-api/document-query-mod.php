<?php

if (!function_exists('nortic_plugin_rest_document_query')) {
    /**
     * Modify the rest document query loop
     *
     * @return void
     */
    function nortic_plugin_rest_document_query($args, $request)
    {
        $orderBy = $request->get_param('orderby');

        if (isset($orderByDate)) {
            $args['orderby'] = $orderBy;
        }

        return $args;
    }
}
