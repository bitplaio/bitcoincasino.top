<?php
// =============================================================================
// The template for displaying Archive pages.
// =============================================================================
get_header(); ?>

        <?php do_action( 'poka_before_main' ); ?>

        <main id="main">
            <section class="section-review-taxonomy">
                <div class="container">
                    <div class="row">
                        <?php $poka_main_col_class = apply_filters('poka_main_col_class_filter', 'col-md-8'); ?>
                        <div class="<?php if( get_field('taxonomy_review_style','options') === 'style4' ||  get_field('taxonomy_review_style','options') === 'style5' ){ echo $poka_main_col_class . ' main-col'; } else { echo 'col-md-12'; } ?> text-area">
                                <?php
                                    if ( have_posts() )
                                        the_post();
                                ?>
                                <h1>
                                    <?php _e( 'Reviews archive', 'poka' ); ?>
                                </h1>

                                <?php rewind_posts(); ?>

                                <?php if( get_field('taxonomy_review_style','options') ){
                                    get_template_part( 'inc/loops/loop-affiliates', get_field('taxonomy_review_style','options') );
                                } else {
                                    get_template_part( 'inc/loops/loop-affiliates', 'style1' );
                                } ?>

                        </div>
                        <?php if( get_field('taxonomy_review_style','options') === 'style4' ||  get_field('taxonomy_review_style','options') === 'style5' ): ?>
                            <?php get_sidebar(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.container -->
            </section>
            <!-- /.section-review-taxonomy -->
        </main>
        <!-- /#main -->

        <?php do_action( 'poka_after_main' ); ?>

<?php get_footer(); ?>
