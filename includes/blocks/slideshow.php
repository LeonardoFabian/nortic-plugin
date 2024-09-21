<?php

if (!function_exists('nortic_plugin_slideshow_render_cb')) {
    function nortic_plugin_slideshow_render_cb()
    {
        ob_start();
?>
        <div <?php echo get_block_wrapper_attributes(); ?>>
            <!-- Slideshow wrapper -->
            <div class="glide__track" data-glide-el="track">

                <div class="glide__slides">


                </div>

                <!-- Slider indicators  -->
                <div class="glide__bullets slide-indicators absolute bottom-4 w-full z-30 flex items-center justify-center mx-auto space-x-3" data-glide-el="controls[nav]">
                    <button type="button" class="glide__bullet w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-glide-dir="0"></button>
                    <button type="button" class="glide__bullet w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-glide-dir="1"></button>
                    <button type="button" class="glide__bullet w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-glide-dir="2"></button>
                    <button type="button" class="glide__bullet w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-glide-dir="3"></button>
                    <button type="button" class="glide__bullet w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-glide-dir="4"></button>
                </div>

                <!-- Slider controls  -->
                <div data-glide-el="controls">
                    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                        <span class="slide-control inline-flex items-center justify-center w-8 h-8 rounded-full">
                            <i class="bi bi-arrow-left text-md"></i>
                            <span class="sr-only"><?php __("Previous", "nortic-plugin") ?></span>
                        </span>
                    </button>
                    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                        <span class="slide-control inline-flex items-center justify-center w-8 h-8 rounded-full">
                            <i class="bi bi-arrow-right text-md"></i>
                            <span class="sr-only"><?php __("Next", "nortic-plugin") ?></span>
                        </span>
                    </button>
                </div>

            </div>
        </div>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
