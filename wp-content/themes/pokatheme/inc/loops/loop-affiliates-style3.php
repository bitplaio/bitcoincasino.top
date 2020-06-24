<?php
// =============================================================================
// Main loop
// =============================================================================
?>

<div class="table-s1 table-s1--ncount table-big table-taxonomy-list">
    <?php $count = 1; ?>
    <?php if (have_posts()) : while (have_posts()) : the_post();?>
        <div class="item clearfix"
        ><div class="c1">
                <div class="table">
                    <div class="table-cell">
                        <div class="count"><?php echo $count; ?>.</div>
                    </div>
                </div>
            </div>
            <div class="c2">
                <div class="table">
                    <div class="table-cell">
                        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'aff-thumb' ); ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>">
                        </a>
                    </div>
                </div>
            </div>
            <div class="c3">
                <div class="table">
                    <div class="table-cell">
                        <?php echo poka_affiliates_ratings(get_the_ID()); ?>
                        <a href="<?php the_permalink(); ?>" class="review-link"><?php _e('Read review','poka'); ?></a>
                    </div>
                </div>
            </div>
            <div class="c4">
                <div class="table">
                    <div class="table-cell">
                        <i class="icon-poka icon-poka-arrow-right"></i>
                        <h4><?php the_field('bonus_promo_title'); ?></h4>
                        <p><?php the_field('affiliate_small_info'); ?></p>
                        <i class="icon-poka icon-poka-arrow-right icon-right"></i>
                    </div>
                </div>
            </div>
            <div class="c5">
                <div class="table">
                    <div class="table-cell">
                        <?php if( get_field('affiliate_link') ): ?>
                            <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID ); ?>" class="btn btn--shadow btn--green btn--full d-none d-lg-block" target="_blank" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID); ?>><?php echo poka_get_translation('Play now'); ?></a>
                            <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID , 'mobile' ); ?>" class="btn btn--shadow btn--green btn--full hidden-lg-up" target="_blank" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID , 'mobile'); ?>><?php echo poka_get_translation('Play now'); ?></a>
                        <?php endif; ?>
                        <?php echo poka_terms_text_return( get_the_ID() ); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php $count++; endwhile; endif; ?>
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
