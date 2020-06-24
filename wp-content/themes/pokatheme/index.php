<?php
// =============================================================================
// The main template file.
// =============================================================================
get_header(); ?>

    <?php do_action( 'poka_before_main' ); ?>

    <main id="main">
        <div class="container">
            <div class="row">
                <?php $poka_main_col_class = apply_filters('poka_main_col_class_filter', 'col-md-8'); ?>
                <div class="<?php echo $poka_main_col_class; ?> main-col">

                    <div class="single-post-wrapper text-area">

                    <?php if( is_front_page() ): ?>

                        <div class="box-text"><?php poka_printmsg('set_home_tpl'); ?></div>

                    <?php else: ?>

                        <h1><?php _e( 'Archives', 'poka' ); ?></h1>

                        <section class="group-category">
                            <?php
                            if( get_field('category_style', 'option') ){
                                get_template_part( 'inc/loops/loop',get_field('category_style', 'option') );
                            }
                            else{
                                get_template_part( 'inc/loops/loop', 'style1' );
                            }
                            ?>
                        </section>
                        <!-- /.group-category -->

                    <?php endif; ?>

                    </div>
                    <!-- /.single-post -->

                </div>
                <!-- /.col9 col-sm-12 -->

                <?php get_sidebar(); ?>
            </div>
        </div>
        <!-- /.container -->
    </main>
    <!-- /#main -->

    <?php do_action( 'poka_after_main' ); ?>

<?php get_footer(); ?>
