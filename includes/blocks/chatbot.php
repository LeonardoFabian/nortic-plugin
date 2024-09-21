<?php

if (!function_exists('nortic_plugin_chatbot_render_cb')) {
    function nortic_plugin_chatbot_render_cb()
    {
        ob_start();
?>




        <div id="chatbot" class="wp-block-nortic-plugin-chatbot chatbot flex flex-col justify-end items-center z-50">
            <!-- <div class="chatbot-container w-full rounded-lg shadow-lg p-4" style="display: none;">
                <div class="chatbot-header p-4 rounded-lg mb-4 text-sm flex items-start gap-4 font-semibold">
                    <span class="chatbot-avatar flex items-center justify-center rounded-full py-2 px-3">
                        <i class="bi bi-robot text-2xl text-white"></i>
                    </span>
                    <div><?php _e('Hi, I\'m your Job Assistant, how can I help you?', 'nortic-plugin'); ?></div>
                </div>
                <div id="chat-ref" ref="chatRef" class="chat-container flex flex-col gap-4 my-4 w-full h-64 p-8 overflow-scroll">
                 
                    <div key="message_date" data-session="message.session" class="chat-message flex flex-row items-start bg-white border border-gray-200 py-2 px-4 rounded-lg">
                        <span class="user-avatar rounded-full bg-gray-500 py-2 px-3 mr-4">
                            <i class="bi bi-chat-left-dots"></i>
                        </span>
                        <div class="user-message w-full text-sm">
                            Esto es un mensaje de prueba
                        </div>
                    </div>
                    <time class="chat-message-time">
                        <?php echo date('Y-m-d h:i:sa') ?>
                    </time>
        







                </div>


                <div class="relative w-full flex items-center mt-4">
                    <textarea id="chat-box" rows="2" class="w-full p-2.5 text-sm text-gray-900 bg-slate-50 rounded-lg border border-gray-300" data-value="" data-on-submit=""></textarea>
                </div>
            </div>

            <div class="relative w-full flex items-center justify-end mt-4">
                <a id="floating-chatbot-button" class="floating-chatbot-button cursor-pointer flex items-center justify-center rounded-full w-14 h-14 shadow-white">
                    <i class="bi bi-robot text-4xl text-white"></i>
                </a>
            </div> -->
        </div>




<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
