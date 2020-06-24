<?php
// =============================================================================
// The template for displaying Archive pages.
// =============================================================================
get_header(); ?>

        <?php do_action( 'poka_before_main' ); ?>

        <main id="main">
            <section class="group-category">
                <div class="container">
                    <div class="row">
                        <?php $poka_main_col_class = apply_filters('poka_main_col_class_filter', 'col-md-8'); ?>
                        <div class="<?php echo $poka_main_col_class; ?> main-col">
                            <div class="single-post-wrapper text-area">
                                <?php
                                    if ( have_posts() )
                                        the_post();
                                ?>
                                <h1>
                                    <?php if ( is_day() ) : ?>
                                                    <?php printf( __( 'Daily Archives: <span>%s</span>', 'poka' ), get_the_date() ); ?>
                                    <?php elseif ( is_month() ) : ?>
                                                    <?php printf( __( 'Monthly Archives: <span>%s</span>', 'poka' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'poka' ) ) ); ?>
                                    <?php elseif ( is_year() ) : ?>
                                                    <?php printf( __( 'Yearly Archives: <span>%s</span>', 'poka' ), get_the_date( _x( 'Y', 'yearly archives date format', 'poka' ) ) ); ?>
                                    <?php elseif ( is_tag() ) : ?>
                                                    <?php echo single_tag_title( '', false ); ?>
                                    <?php else : ?>
                                                    <?php _e( 'Archives', 'poka' ); ?>
                                    <?php endif; ?>
                                </h1>

                                <?php rewind_posts(); ?>

                                <?php
                                if( get_field('category_style', 'option') ){
                                    get_template_part( 'inc/loops/loop',get_field('category_style', 'option') );
                                }
                                else{
                                    get_template_part( 'inc/loops/loop', 'style1' );
                                }
                                ?>

                            </div>
                            <!-- /.single-post -->
                        </div>
                        <!-- /.col9 col-sm-12 -->

                        <?php get_sidebar(); ?>
                    </div>
                </div>
                <!-- /.container -->
            </section>
        </main>
        <!-- /#main -->

        <?php do_action( 'poka_after_main' ); ?>

<?php get_footer(); ?>
