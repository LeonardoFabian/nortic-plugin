<?php

if (!function_exists('nortic_plugin_contact_form')) {

    /**
     * Fires when contact form is submitted
     *
     * @return void
     */
    function nortic_plugin_contact_form()
    {
        // Make WP_Error global object
        global $contact_form_errors;

        // Instantiate the class
        $contact_form_errors = new WP_Error();


        if (!isset($_POST['contact-form-submitted']) && !wp_verify_nonce($_POST['wp_nonce_contact_form'], 'contact_form')) {
            return;
        }

        $name = sanitize_text_field($_POST['sender_name']);
        $email = sanitize_email($_POST['sender_email']);
        $subject = sanitize_text_field($_POST['email_subject']);
        $message = sanitize_textarea_field($_POST['email_message']);

        /*
        validations 
        */

        // If any field is left empty, add the error message to the error object
        if (empty($name) || empty($email) || empty($message)) {
            $contact_form_errors->add("empty_name", __('The name field must not be empty.', 'nortic-plugin'));
        }

        if (empty($email)) {
            $contact_form_errors->add("empty_email", __('The email field must not be empty.', 'nortic-plugin'));
        }

        if (empty($message)) {
            $contact_form_errors->add("empty_message", __('The message field must not be empty.', 'nortic-plugin'));
        }

        if( preg_match( '/^\D*$/', $name ) == 0 ) {
			$contact_form_errors->add("invalid_name", __("Invalid name entered", "nortic-plugin"));
		}

        if (!is_email($email)) {
            $contact_form_errors->add("invalid_email", __('The email field is not valid.', 'nortic-plugin'));
        }


        // validate length
        if (strlen($name) < 2 || strlen($name) > 50) {
            $contact_form_errors->add("name_length", __("The name field must have between 2 and 50 characters.", 'nortic-plugin'));
        }

        if (strlen($email) < 6 || strlen($email) > 100) {
            $contact_form_errors->add("email_length", __("The email field must have between 6 and 100 characters.", "nortic-plugin"));
        }

        if (strlen($subject) > 100) {
            $contact_form_errors->add("subject_length", __("The subject field must have 100 characters.", "nortic-plugin"));
        }

        if (strlen($message) > 500) {
            $contact_form_errors->add("message_length", __("The message field must have 500 characters.", "nortic-plugin"));
        }








        // if (empty($subject)) {
        //     $contact_form_errors->add("empty-subject", __('The subject field is required.', 'nortic-plugin'));
        // }

        if (count($contact_form_errors->get_error_messages()) == 0) {
            $to = get_bloginfo('admin_email');
            // $to = 'ramon.fabian@mt.gob.do';

            $response = wp_mail($to, $subject, $message);

            if (!$response) {
                $contact_form_errors->add("email", __("Email failed", "nortic-plugin"));
            } else {
                unset($_POST['sender_name']);
                unset($_POST['sender_email']);
                unset($_POST['email_subject']);
                unset($_POST['email_message']);
            }


        }
    }
}
