<?php
// =============================================================================
// The template for displaying Search Results pages.
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

                                <?php get_template_part( 'inc/loops/loop','search' ); ?>

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
