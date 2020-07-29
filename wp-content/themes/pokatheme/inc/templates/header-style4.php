<?php
$background_image = '';
if( get_field('header_background' , 'options') ) {
    $background_image = get_field('header_background' , 'options');
}

if( ( is_single() || is_page() ) && get_field('header_backgound_image_override') ) {
    $background_image = get_field('header_backgound_image_override');
}
?>
<div class="fullscreen-bg" <?php if( $background_image ): ?>style="background-image:url(<?php echo $background_image; ?>);"<?php endif; ?>></div>
<header <?php if( $background_image ): ?>style="background-image:url(<?php echo $background_image; ?>);"<?php endif; ?>>
    <div class="head-main">
        <div class="container">
            <a href="<?php echo esc_url( home_url() ); ?>" id="logo">
                <img src="<?php
                                if( get_field('site_logo','options') ){
                                    the_field('site_logo','options');
                                } else {
                                    echo get_theme_file_uri('/images/logo.png');
                                }
                          ?>" alt="<?php bloginfo('name'); ?>">
            </a>
            <?php if( get_field('page_intro','options') && is_front_page() ): ?>
            <div class="text-intro">
                <?php the_field('page_intro','options'); ?>
            </div>
            <!-- /.text-intro -->
            <?php endif; ?>
        </div>
        <!-- /.container -->
    </div>
    <!-- /.head-main -->
</header>
