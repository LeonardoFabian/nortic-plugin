<?php 

if(!function_exists('nortic_plugin_system_list_render_cb')) {
    function nortic_plugin_system_list_render_cb($atts) {
        $post_type = $atts['postType'];
        $heading = $atts['heading'];
        $sub_heading = $atts['subHeading'];
        $useGlidejs = $atts['renderType'] === "carousel" || $atts['renderType'] === "slider" ? true : false;

        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );

        $query = new WP_Query($args);

        ob_start();

?>

        <div class="wp-block-nortic-plugin-system-list" >
            <?php if($atts['showHeader']) : ?>
                <div class="system-list-header">
                    <h2><?php echo $atts['heading'] ?></h2>
                    <span><?php  echo $atts['subHeading']; ?></span>
                </div>
            <?php endif; ?>
            <div <?php if($useGlidejs ) echo 'data-glide-el="track"'; ?> >
                <div class="system-list-wrapper grid grid-cols-2 md:flex md:items-center md:space-between gap-4 md:gap-0 <?php $useGlidejs === true ? 'glide__slides' : ''; ?>">
                    <?php if($query->have_posts()) : ?>
                        <?php while($query->have_posts()) : $query->the_post(); ?>
                            <?php 
                                $post_id = get_the_ID();
                                $post_title = get_the_title();
                                $system_alias = get_post_meta($post_id, 'alias', true);
                                $system_url = get_post_meta($post_id, 'url', true);
                                $system_icon = get_post_meta($post_id, 'icon', true);
                                $featured_image_url = get_the_post_thumbnail_url(); 
                            ?>
                            <div class="system-list-item <?php $useGlidejs === true ? 'glide__slide' : ''; ?>">
                                <a href="<?php echo $system_url; ?>" target="_blank" role="link" title="<?php echo $post_title; ?>"> 
                                    <?php if($featured_image_url) : ?>
                                        <div class="system-list-item__icon">
                                            <img src="<?php echo $featured_image_url; ?>" />
                                        </div>
                                    <?php else : ?>
                                        <div class="system-list-item__icon"><?php echo $system_icon; ?></div>
                                    <?php endif; ?>
                                </a>
                                <div class="system-list-item__meta text-center">
                                    <h3>
                                        <a href="<?php echo $system_url; ?>" target="_blank" role="link" title="<?php echo $post_title; ?>">    
                                            <?php echo $system_alias; ?>
                                        </a>
                                    </h3>  
                                                        
                                </div>                            
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        </div>

<?php 

        $output = ob_get_contents();
        ob_end_clean();

        return $output;

    }
}