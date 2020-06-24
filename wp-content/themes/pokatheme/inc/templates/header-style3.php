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
    <div class="head-inline">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
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
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <?php poka_social_links(); ?>
                    <form action="<?php echo esc_url( home_url() ); ?>" class="form-inline top-bar-search" method="get">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="s" placeholder="<?php _e( 'Search', 'poka' ); ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn"><i class="icon-poka icon-poka-search"></i></button>
                    </form>
                    <!-- /.top-bar-search -->
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
    <!-- /.head-logo -->
    <div class="head-menu head-menu--s3 clearfix">
        <div class="container">
            <a href="#mobile-menu" class="trigger-mmenu hidden-lg-up">
                <div class="icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span><?php _e( 'Menu', 'poka' ); ?></span>
            </a>
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'menu hidden-md-down', 'container' => false ) ); ?>
            <nav id="mobile-menu">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'mobmenu', 'container' => false ) ); ?>
            </nav>
        </div>
        <!-- /.container -->
    </div>
    <!-- /#menu -->
</header>
