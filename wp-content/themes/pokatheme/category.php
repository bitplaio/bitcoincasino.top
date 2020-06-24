<?php
// =============================================================================
// The template for displaying Category Archive pages.
// =============================================================================
get_header(); ?>

        <?php do_action( 'poka_before_main' ); ?>

        <?php $queried_object = get_queried_object(); ?>

        <main id="main">
            <section class="group-category">
                <div class="container">
                    <div class="row">
                        <?php $poka_main_col_class = apply_filters('poka_main_col_class_filter', 'col-md-8'); ?>
                        <div class="<?php echo $poka_main_col_class; ?> main-col">
                            <div class="single-post-wrapper text-area">
                                <h1><?php echo single_cat_title( '', false ); ?></h1>

                                <?php $description = category_description(); ?>
                                <?php if( $description ): ?>
                                <div class="taxonomy-intro">
                                    <?php echo $description; ?>
                                </div>
                                <!-- /.taxonomy-intro -->
                                <?php endif; ?>

                                <?php
                                if( get_field('category_style_override',$queried_object) != "" ){
                                    get_template_part( 'inc/loops/loop', get_field('category_style_override',$queried_object) );
                                } else {
                                    if( get_field('category_style', 'option') ){
                                        get_template_part( 'inc/loops/loop',get_field('category_style', 'option') );
                                    }
                                    else{
                                        get_template_part( 'inc/loops/loop', 'style1' );
                                    }
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
            <!-- /.group-category -->
        </main>
        <!-- /#main -->

        <?php do_action( 'poka_after_main' ); ?>

<?php get_footer(); ?>
