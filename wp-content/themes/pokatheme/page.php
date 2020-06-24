<?php
// =============================================================================
// The template for displaying all pages.
// =============================================================================
get_header(); ?>

        <?php do_action( 'poka_before_main' ); ?>

        <?php //If there is no content hide two columns ?>
        <?php if( trim($post->post_content) != "" || poka_is_elementor_page() ): ?>
        <main id="main">
            <div class="container">
                <div class="row">
                    <?php $poka_main_col_class = apply_filters('poka_main_col_class_filter', 'col-md-8'); ?>
                    <div class="<?php echo $poka_main_col_class; ?> text-area main-col">

                        <?php if (have_posts()) : while (have_posts()) : the_post();?>

                            <?php if( get_field('show_title_top') ): ?>
                                <h1><?php the_title(); ?></h1>
                            <?php endif; ?>
                            
                            <?php the_content(); ?>

                        <?php endwhile; endif; ?>

                    </div>
                    <!-- /.col9 col-sm-12 -->

                    <?php get_sidebar(); ?>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </main>
        <!-- /#main -->

        <?php endif; ?>

        <?php do_action( 'poka_after_main' ); ?>

<?php get_footer(); ?>
