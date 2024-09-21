<?php

if (!function_exists('nortic_plugin_rest_create_chat_completion')) {
    /**
     * Create Chat Completion
     *
     * @param [type] $request
     * @return void
     */
    function nortic_plugin_rest_create_chat_completion($request)
    {
        $requestResponse = ['status' => 1]; // failed response

        $options = get_option('nortic_plugin_chatbot_options');

        if (!$options['np_enable_chatbot']) {
            return $requestResponse;
        }

        $userIP = $_SERVER['REMOTE_ADDR'];
        $date = date('Y-m-d H:i:s');

        $params = $request->get_json_params();

        if (
            !isset($params['text']) ||
            empty($params['text'])
        ) {
            $requestResponse['error'] = "The input string is required";
            return $requestResponse;
        }

        $session = "";

        if (!isset($_COOKIE['nortic_chatbot_cookie'])) {
            $visit_time = getRandomStringRand();
            $session = nortic_plugin_set_new_chatbot_cookie($visit_time);
        } else {
            $session = $_COOKIE['nortic_chatbot_cookie'];
        }

        // Store user message
        global $wpdb;

        $table = "{$wpdb->prefix}nortic_plugin_chatbot_messages";


        $wpdb->insert(
            "{$table}",
            [
                'session_id' => $session,
                'text' => sanitize_text_field($params['text']),
                'message_date' => $params['message_date'],
                'parent_id' => (!is_null($params['response_id'])) ? $params['response_id'] : null,
                'ip_address' => $userIP
            ],
            ['%s', '%s', '%s', '%d']
        );

        $messageId = $wpdb->insert_id;

        $ch = curl_init();

        $url = 'https://api.openai.com/v1/completions';

        $openai_api_key = $options['np_chatbot_openai_apikey'];

        if (!isset($openai_api_key) || empty($openai_api_key)) {
            $requestResponse['error'] = "Missing API KEY";
            return $requestResponse;
        }


        define('AI_PROMPT', "The following is a conversation with Job. Job's only knowledge is Labor Ministry from Dominican Republic and 
        Government of the Dominican Republic.  Quiero que solo respondas y ofrezcas informacion veridica del año actual sobre temas que tienen que ver con el Ministerio de Trabajo de la República Dominicana y el Gobierno Dominicano, no especules. Consulta informaciones suministradas solamente por las siguientes fuentes: https://www.google.com/, https://mt.gob.do/, https://tss.gob.do/, https://calculo.mt.gob.do/, https://rdtrabaja.mt.gob.do/#/, http://capacitate.mt.gob.do/es, http://sirla.mt.gob.do/, https://mt.gob.do/transparencia/, https://mt.gob.do/index.php/noticias, https://mt.gob.do/index.php/sobre-nosotros/despacho-de-maxima-autoridad, https://mt.gob.do/index.php/contacto, https://mt.gob.do/index.php/servicios/ver-todos-los-servicios, https://mt.gob.do/index.php/servicios/dgt, https://mt.gob.do/index.php/servicios/dge, https://mt.gob.do/index.php/servicios/dghs, https://mt.gob.do/index.php/servicios/oai, https://mt.gob.do/index.php/servicios/servicio-al-cliente, https://mt.gob.do/index.php/resoluciones/resoluciones-sobre-trabajo-domestico, https://mt.gob.do/index.php/sobre-nosotros/marco-legal, https://mt.gob.do/transparencia/index.php/oai/contacto-responsable-de-acceso-a-la-informacion, https://mt.gob.do/index.php/sobre-nosotros/2015-10-12-21-26-43, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Certificacion%20de%20Convenio%20Colectivo.pdf, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Certificacion%20de%20Documentos%20Sindicales.pdf, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Certificacion%20de%20No%20Conflito%20Laboral.pdf, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Certificacion%20de%20Registro%20SIRLA%20y%20Oferta%20de%20Trabajo%20a%20Extranjero.pdf, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Registro%20de%20Contrato%20de%20Trabajo%20de%20Extranjero.pdf, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Registro%20de%20Contrato%20de%20Trabajo.pdf, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Registro%20de%20Reglamento%20Interior%20de%20Trabajo.pdf, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Registro%20Sindical.pdf, https://mt.gob.do/images/docs/dgt/fichas/publicadas/Solicitud%20de%20No%20Objecion%20para%20el%20Consejo%20Nacional%20de%20Zonas%20Francas.pdf, https://mt.gob.do/index.php/servicios/dge/publicar-vacante, https://mt.gob.do/index.php/servicios/dge/registrarme-como-candidato-a-empleo, https://mt.gob.do/index.php/servicios/dghs/direccion-general-de-higiene-y-seguridad-industrial, https://mt.gob.do/index.php/servicios/oai/oficina-de-acceso-a-la-informacion, https://mt.gob.do/index.php/dependencias-mt/direccion-general-de-trabajo, https://www.ilo.org/dyn/natlex/docs/WEBTEXT/29744/64852/S92DOM01.htm, https://www.instagram.com/mtrabajord/?hl=es, https://twitter.com/MTrabajoRD?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor, https://play.google.com/store/apps/details?id=gob.mt.calcprestaciones&pli=1, https://appgallery.huawei.com/#/app/C102427377 y https://presidencia.gob.do/. Si no tienes la respuesta correcta y cuya informacion provenga de las fuentes anteriores solo responde 'No lo tengo claro', si te preguntan tu nombre respondes 'Mucho gusto, me llamo Job', ahora veamos si entendiste, esta es mi pregunta:");

        $formattedPrompt = AI_PROMPT . "\n" . $params['text'];

        $data = [
            'model' => $options['np_chatbot_openai_model'], // 'text-davinci-003',
            'prompt' => $formattedPrompt,
            'temperature' => $options['np_chatbot_openai_temperature'], // 0.7,
            'top_p' => $options['np_chatbot_openai_top_p'], // 0.4,
            'max_tokens' => $options['np_chatbot_openai_max_tokens'], // 1024,
            'stop' => ['\n'],
        ];



        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $openai_api_key
        );

        $data_string = json_encode($data);


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        // return $response;
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);

        $response = json_decode($result);

        $aiResponse = $response->choices[0]->text;


        $wpdb->insert(
            "{$table}",
            [
                'session_id' => $session,
                'text' => $aiResponse,
                'message_date' => $date,
                'parent_id' => $messageId
            ],
            ['%s', '%s', '%s', '%d']
        );

        $responseId = $wpdb->insert_id;

        // sleep(3);

        $requestResponse['status'] = 2;
        $requestResponse['responseID'] = $responseId;
        $requestResponse['result'] = $aiResponse; // OK response
        return $requestResponse;
    }
}
