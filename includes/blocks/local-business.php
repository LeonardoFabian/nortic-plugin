<?php

if (!function_exists('nortic_plugin_local_business_render_cb')) {
    function nortic_plugin_local_business_render_cb($atts)
    {
        ob_start();
?>
        <div itemscope itemtype="http://schema.org/LocalBusiness" class="w-full">
            <h3 class="hidden"><?php echo __('Dates', 'nortic-plugin'); ?></h3>
            <span class="dates-contact text-xl mb-3" itemprop="name"><?php echo $atts['company_name']; ?></span>

            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="mb-3">
                <span class="dates-contact block" itemprop="streetAddress"><?php echo $atts['street_address']; ?></span>
                <span class="dates-contact block" itemprop="addressLocality"><?php echo $atts['address_locality']; ?></span>
                <span class="dates-contact block" itemprop="postalCode"><?php echo $atts['postal_code']; ?></span>
            </div>

            <span itemprop="telephone" class="flex items-center mb-3">
                <div class="bg-blue-50 text-blue-700 mr-6 flex h-14 w-16 max-w-[60px] items-center justify-center overflow-hidden rounded bg-opacity-5 sm:h-[70px] sm:max-w-[70px]">
                    <i class="bi bi-telephone-inbound text-2xl"></i>
                </div>
                <?php echo $atts['telephone']; ?>
            </span>
            <span itemprop="faxNumber" class="flex items-center mb-3">
                <div class="bg-blue-50 text-blue-700 mr-6 flex h-14 w-16 max-w-[60px] items-center justify-center overflow-hidden rounded bg-opacity-5 sm:h-[70px] sm:max-w-[70px]">
                    <i class="bi bi-printer text-2xl"></i>
                </div>
                <?php echo $atts['fax_number']; ?>
            </span>
            <span itemprop="email" class="flex items-center mb-3">
                <div class="bg-blue-50 text-blue-700 mr-6 flex h-14 w-16 max-w-[60px] items-center justify-center overflow-hidden rounded bg-opacity-5 sm:h-[70px] sm:max-w-[70px]">
                    <i class="bi bi-envelope-at text-2xl"></i>
                </div>
                <?php echo $atts['email']; ?>
            </span>
        </div>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
