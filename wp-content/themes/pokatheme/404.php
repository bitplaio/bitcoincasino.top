<?php
// =============================================================================
// The template for displaying 404 pages (Not Found).
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

                                <h1><?php _e( 'Page Not Found', 'poka' ); ?></h1>

                                <p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'poka' ); ?></p>

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
