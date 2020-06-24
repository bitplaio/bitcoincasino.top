<?php
// =============================================================================
// The Template for displaying all single affiliates posts.
// =============================================================================
get_header(); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post();

    endwhile; endif; ?>

    <?php do_action( 'poka_before_main' );
    
    if( get_field('review_style_override') != "" ){
        get_template_part( 'inc/templates/affiliates-single', get_field('review_style_override') );
    } else {
        if( get_field('review_style','options') ){
            get_template_part( 'inc/templates/affiliates-single', get_field('review_style','options') );
        } else {
            get_template_part( 'inc/templates/affiliates-single', 'style1' );
        }
    }

    do_action( 'poka_after_main' ); ?>

<?php get_footer(); ?>
