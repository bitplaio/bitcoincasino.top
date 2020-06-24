<?php
// =============================================================================
// Main loop
// =============================================================================
?>
<?php $counter = 0; if (have_posts()) : while (have_posts()) : the_post();?>

        <div class="news-item news-item--dif">
            <?php
            $embeds = poka_get_embeds($post->post_content);

            if ( has_post_format( 'video' ) && isset($embeds[0]) ) {
                echo '<div class="video-wrapper">';
                echo $embeds[0];
                echo '</div>';
            } else {
                if ( has_post_thumbnail() ) {
                    echo '<div class="thumb-wrapper">';
                    the_post_thumbnail('full');
                    echo '</div>';
                }
            }
            ?>
            <div class="new-text-group">
                <?php $category = get_the_category(); ?>
                <div class="news-info clearfix">
                    <strong><?php echo $category[0]->cat_name; ?></strong>
                    <div class="date-item">
                        <span><?php the_time('d, l'); ?></span>
                        <span><?php the_time('F'); ?></span>
                        <span><?php the_time('Y'); ?></span>
                    </div>
                </div>
                <div class="new-text-group__text">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink(); ?>" class="btn btn--blue"><?php _e('read more','poka'); ?></a>
                </div>
                <!-- /.new-text-group__text -->
            </div>
            <!-- /.news-text -->

        </div>
        <!-- /.news-item -->

    <?php  $counter++;  endwhile; endif; ?>



<div class="pagination">
    <?php
    global $wp_query;

    $big = 999999999; // need an unlikely integer

    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<i class="icon-poka icon-poka-arrow-left"></i>',
        'next_text' => '<i class="icon-poka icon-poka-arrow-right"></i>',
    ) );
    ?>
</div>
<!-- /.pagination -->
