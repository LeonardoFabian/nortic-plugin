<?php

function nortic_truncate_string($string, $max_length) {
    if(strlen($string) <= $max_length) {
        return $string;
    }
    return substr($string, 0, $max_length) . '...';
}

function nortic_plugin_get_document_type_by_file_format($file_format)
{
    $document_type = "";

    switch ($file_format) {
        case "vnd.openxmlformats-officedocument.spreadsheetml.sheet":
        case "vnd.ms-excel":
        case "csv":
        case "vnd.oasis.opendocument.spreadsheet":
            $document_type = 'XLS';
            break;
        case "msword":
        case "vnd.openxmlformats-officedocument.wordprocessingml.document":
        case "vnd.oasis.opendocument.text":
            $document_type = 'DOC';
            break;
        case "vnd.ms-powerpoint":
        case "vnd.openxmlformats-officedocument.presentationml.presentation":
            $document_type = 'PPT';
            break;
        case "plain":
            $document_type = 'TXT';
            break;
        case "pdf":
            $document_type = 'PDF';
            break;
        case "mpeg":
            $document_type = 'MPEG';
            break;
        case "mp4":
            $document_type = 'MP4';
            break;
    }

    return $document_type;
}

function nortic_plugin_get_document_viewer_url_by_file_format($file_format)
{
    $document_viewer_url = "";
    $format = nortic_plugin_get_document_type_by_file_format($file_format);

    switch ($file_format) {
        case "PPT":
        case "XLS":
        case "DOC":
            $document_viewer_url = 'https://www.microsoft.com/en-us/microsoft-365/business/compare-all-microsoft-365-business-products-b?ef_id=_k_EAIaIQobChMIhIn1roq0gAMVTXtMCh0xAgRJEAAYASAAEgI-LPD_BwE_k_&OCID=AIDcmmpvtflbl2_SEM__k_EAIaIQobChMIhIn1roq0gAMVTXtMCh0xAgRJEAAYASAAEgI-LPD_BwE_k_&gclid=EAIaIQobChMIhIn1roq0gAMVTXtMCh0xAgRJEAAYASAAEgI-LPD_BwE';
            break;
        case "PDF":
            $document_viewer_url = 'https://get.adobe.com/es/reader/';
            break;
        case "MPEG":
        case "MP4":
            $document_viewer_url = 'https://www.videolan.org/vlc/download-windows.es.html';
            break;
    }

    $output = '<ul class="list-disc text-sm color-dark-gray ml-6"><li>';
    $output .= /* Translators: %s is the document type */ sprintf(__('To download the %s viewer', 'nortic-plugin'), $format);
    $output .= ", ";
    $output .= '<a class="text-blue-500 color-azure-blue hover:underline" href="' . esc_url_raw($document_viewer_url) . '" target="_blank">' . esc_html__('click here', 'nortic-plugin') . '</a>';
    $output .= '</li></ul>';

    return $output;
}

function getRandomStringRand($length = 16)
{
    $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $stringLength = strlen($stringSpace);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString = $randomString . $stringSpace[rand(0, $stringLength - 1)];
    }
    return $randomString;
}

/**
 * Retrieve the custom post type
 *
 * @return string Archive post_type
 */
function nortic_plugin_get_archive_post_type()
{
    $post_type = false;

    global $wp_query;

    if (isset($wp_query->query['post_type'])) {
        $post_type = $wp_query->query['post_type'];
    }

    return $post_type;
}

/**
 * Return pre-formatted textarea content
 *
 * @param string $text
 * @param string $classes (Optional)
 * @return void
 */
function nortic_plugin_sanitize_textarea_field($text, $classes = '')
{

    $rows = explode("\n", $text);

    foreach ($rows as $row) {

        echo '<p class="break-normal leading-normal ' . $classes . '">';
        echo str_replace("*", "<li>", $row);
        echo '</p>';
    }
}

/**
 * Return true if date expired
 *
 * @param string $date
 * @return boolean True if expired
 */
function nortic_plugin_sanitize_event_duration($expiry_date)
{
    nortic_plugin_set_default_timezone();

    $expiry_date = strtotime($expiry_date);

    // current date
    $current_date = nortic_plugin_get_current_date();

    if ($current_date < $expiry_date) {
        __return_false();
    }

    __return_true();
}

/**
 * Sanitizes an iframe from user input or from the database
 *
 * @param string $iframe The iframe from user input
 * @return boolean The sanitized iframe.
 */
function nortic_plugin_sanitize_iframe($iframe)
{
   // Usar wp_kses para permitir solo iframes y atributos seguros
   return wp_kses(
    $iframe,
    array(
        'iframe' => array(
            'src'             => array(),
            'width'           => array(),
            'height'          => array(),
            'frameborder'     => array(),
            'allowfullscreen' => array(),
            'loading'         => array(),
            'referrerpolicy'  => array(),
        ),
    )
);
}

/**
 * Current unix timestamp
 *
 * @return void Returns a timestamp on success, false otherwise.
 */
function nortic_plugin_get_current_date()
{
    $date_format = nortic_plugin_get_date_format();
    $time_format = nortic_plugin_get_time_format();

    $datetime_format = $date_format . " " . $time_format;

    return strtotime(date($datetime_format));
}

/**
 * Get Wordpress date format option
 *
 * @return string Settings date format
 */
function nortic_plugin_get_date_format()
{
    return get_option('date_format');
}

/**
 * Get Wordpress time format option
 *
 * @return string Settings time format
 */
function nortic_plugin_get_time_format()
{
    return get_option('time_format');
}

/**
 * Set default timezone
 *
 * @return void
 */
function nortic_plugin_set_default_timezone()
{
    $timezone_name = nortic_plugin_get_timezone_name();
    date_default_timezone_set($timezone_name);
}

/**
 * Undocumented function
 *
 * @return string
 */
function nortic_plugin_get_timezone_name()
{
    $timezone_offset = nortic_plugin_get_timezone_offset_in_minutes();

    // convert minutes to seconds
    $timezone_name = timezone_name_from_abbr("", $timezone_offset * 60, false);

    // timezone name
    return $timezone_name;
}

/**
 * Return timezone difference in minutes such as 330 or -360 or 0
 *
 * @return int Timezone difference in minutes
 */
function nortic_plugin_get_timezone_offset_in_minutes()
{
    // new Date().getTimezoneOffset();

    // timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone;

    return $timezone_offset_minutes = isset($_POST['timezone_offset_minutes']) ? absint($_POST['timezone_offset_minutes']) : null;
}

function nortic_plugin_validate_time($time)
{
    $format = nortic_plugin_get_time_format();

    // create the format time
    $d = DateTime::createFromFormat($format, $time);

    // return the comparison
    return $d && $d->format($format) === $time;
}


function the_breadcrumb()
{
    global $post;

    $ancestor = get_post_ancestors($post->ID);


    echo "<span class='text-sm mr-2'>" . __('Is here', 'nortic-plugin') . ":</span>";

    if (!is_front_page()) {
        echo "<a class='color-ultimate-gray text-sm' href=" . home_url('/') . ">" . __('Home', 'nortic-plugin') . "</a><span class='color-ultimate-gray mx-2'>/</span>";
    }

    if (!is_front_page() && !is_post_type_archive()) {
        for ($i = count($ancestor) - 1; $i >= 0; $i--) {
            if ($i == count($ancestor) - 1) {
                echo "<a class='color-ultimate-gray text-sm' href=" . get_permalink($ancestor[$i]) . ">" . get_the_title($ancestor[$i]) . "</a>";
            }
            if ($i != 1) {
                echo "<span class='color-ultimate-gray mx-2 text-sm'>/</span>";
            }
        }
    }

    if (is_post_type_archive()) {
        for ($i = count($ancestor) - 1; $i >= 0; $i--) {
            if ($i == count($ancestor) - 1) {
                echo "<a class='color-ultimate-gray text-sm' href=" . get_permalink($ancestor[$i]) . ">" . post_type_archive_title($ancestor[$i]) . "</a>";
            }
            if ($i != 1) {
                echo "<span class='color-ultimate-gray mx-2'>/</span>";
            }
        }
    }

    if (!is_front_page() && !is_post_type_archive() && !is_tax() && !is_page() && !is_category()) {
        echo "<a class='current-breadcrumb-item color-blue font-medium text-sm' href=" . get_permalink() . ">" . get_the_title() . "</a>";
    }

    if (is_post_type_archive()) {
        echo "<a class='current-breadcrumb-item color-blue font-medium text-sm' href=" . get_permalink() . ">" . post_type_archive_title() . "</a>";
    }

    if (is_tax()) {
        $term = get_queried_object();
        echo "<a class='current-breadcrumb-item color-blue font-medium text-sm' href=" . get_term_link($term) . ">" . $term->name . "</a>";
    }

    if (is_page()) {
        echo "<a class='current-breadcrumb-item color-blue font-medium text-sm' href=" . get_permalink() . ">" . get_the_title() . "</a>";
    }

    if (is_category()) {
        echo "<a class='current-breadcrumb-item color-blue font-medium text-sm' href=" . get_permalink() . ">" . single_cat_title() . "</a>";
    }
}
