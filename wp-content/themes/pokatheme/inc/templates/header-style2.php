<?php
$background_image = '';
if( get_field('header_background' , 'options') ) {
    $background_image = get_field('header_background' , 'options');
}

if( ( is_single() || is_page() ) && get_field('header_backgound_image_override') ) {
    $background_image = get_field('header_backgound_image_override');
}
?>
<header <?php if( $background_image ): ?>style="background-image:url(<?php echo $background_image; ?>);"<?php endif; ?>>
    <div class="head-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <?php poka_social_links(); ?>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <form action="<?php echo esc_url( home_url() ); ?>" class="form-inline top-bar-search" method="get">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="s" placeholder="<?php _e( 'Search', 'poka' ); ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn"><i class="icon-poka icon-poka-search"></i></button>
                    </form>
                    <!-- /.top-bar-search -->
                    <?php //Check if WPML is installed and active ?>
                    <?php if ( function_exists('icl_object_id') ): ?>
                    <div class="lang-selector">
                        <?php do_action( 'wpml_add_language_selector' ); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.head-top -->
    <div class="head-logo">
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
        </div>
        <!-- /.container -->
    </div>
    <!-- /.head-logo -->
</header>
