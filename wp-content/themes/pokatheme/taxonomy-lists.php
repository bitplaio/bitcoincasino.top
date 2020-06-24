<?php
// =============================================================================
// The template for displaying Affiliates taxonomy
// =============================================================================
get_header();
?>

        <?php do_action( 'poka_before_main' ); ?>

        <?php $queried_object = get_queried_object(); ?>

        <main id="main">
            <section class="section-review-taxonomy text-area">
                <div class="container">
                    <div class="row">
                        <?php $poka_main_col_class = apply_filters('poka_main_col_class_filter', 'col-md-8'); ?>
                        <div class="<?php if( get_field('taxonomy_view',$queried_object) === 'style4' || get_field('taxonomy_view',$queried_object) === 'style5' || ( get_field('taxonomy_view',$queried_object) === "" && get_field('taxonomy_review_style','options') === 'style4' ) || ( get_field('taxonomy_view',$queried_object) === "" && get_field('taxonomy_review_style','options') === 'style5' ) ){ echo $poka_main_col_class . ' main-col'; } else { echo 'col-md-12'; } ?> text-area">
                            <h1><?php single_term_title(); ?></h1>

                            <?php $description = term_description(); ?>
                            <?php if( $description ): ?>
                            <div class="taxonomy-intro">
                                <?php echo $description; ?>
                            </div>
                            <!-- /.taxonomy-intro -->
                            <?php endif; ?>

                           <?php
                            if( get_field('taxonomy_view',$queried_object) != "" ){
                                get_template_part( 'inc/loops/loop-affiliates', get_field('taxonomy_view',$queried_object) );
                            } else {
                                if( get_field('taxonomy_review_style','options') ){
                                    get_template_part( 'inc/loops/loop-affiliates', get_field('taxonomy_review_style','options') );
                                } else {
                                    get_template_part( 'inc/loops/loop-affiliates', 'style1' );
                                }
                            }
                            ?>

                        </div>
                        <!-- /.col-md-8 -->
                        <?php if( get_field('taxonomy_view',$queried_object) === 'style4' || get_field('taxonomy_view',$queried_object) === 'style5' || ( get_field('taxonomy_view',$queried_object) === "" && get_field('taxonomy_review_style','options') === 'style4' ) || ( get_field('taxonomy_view',$queried_object) === "" && get_field('taxonomy_review_style','options') === 'style5' ) ): ?>
                            <?php get_sidebar(); ?>
                        <?php endif; ?>
                    </div>
                    <!-- /.row -->
                </div>
            <!-- /.container -->
            </section>
            <!-- /.section-review-taxonomy -->
        </main>
        <!-- /#main -->

        <?php do_action( 'poka_after_main' ); ?>

<?php get_footer(); ?>
