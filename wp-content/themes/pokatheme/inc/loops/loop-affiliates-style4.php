<?php
// =============================================================================
// Main loop
// =============================================================================
?>

<div class="taxonomy-list-dif">
    <div class="row">
        <?php if (have_posts()) : while (have_posts()) : the_post();?>
            <div class="col-md-6 col-sm-12">

            <?php
                $rating = poka_affiliates_ratings($post->ID);
                if( get_field('affiliate_link', $post->ID) ) {
                    $btn_aff = '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID ).'" class="btn btn--full btn--green d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID).'>'.poka_get_translation('Play now').'</a>';
                    $btn_aff .= '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID , 'mobile' ).'" class="btn btn--full btn--green hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID , 'mobile').'>'.poka_get_translation('Play now').'</a>';
                } else {
                    $btn_aff =  '';
                }
                ?>
                <div class="aff-single-widget">
                    <div class="img"><?php the_post_thumbnail('aff-thumb'); ?></div>
                    <div class="ratings-wrapper"><?php echo $rating; ?></div>
                    <div class="item-bonus"><?php echo get_field('affiliate_small_info',$post->ID) ?> </div>
                    <div class="item-btns">
                        <div class="row row-sm">
                            <?php if( $btn_aff ): ?>
                                <div class="col-lg-6">
                                    <a href="<?php echo get_permalink($post->ID) ?>" class="btn btn--blue btn--full"><?php echo poka_get_translation('Review'); ?></a>
                                </div>
                                <div class="col-lg-6"><?php echo $btn_aff ?></div>
                            <?php else : ?>
                                <div class="col-lg-12">
                                    <a href="<?php echo get_permalink($post->ID) ?>" class="btn btn--blue btn--full"><?php echo poka_get_translation('Review'); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php echo poka_terms_text_return( get_the_ID() ); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>

</div>


<div class="pagination">
    <?php
    global $wp_query;

    $big = 999999999; // need an unlikely integer

    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages
    ) );
    ?>
</div>
<!-- /.pagination -->
