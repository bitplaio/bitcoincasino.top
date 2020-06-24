<?php
// =============================================================================
// Search loop
// =============================================================================

if (have_posts()) : ?>
    <h1><?php printf( __( 'Search Results for: %s', 'poka' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
<?php $counter = 0;  while (have_posts()) : the_post(); ?>

        <?php
        if ($counter % 2 == 0) {
            echo '<div class="row">';
        }
        ?>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="news-item<?php if ( get_post_type( $post->ID ) == ' affiliates') { ?> news-item--reviews
          <?php  } ?>">
                <?php
                $embeds = poka_get_embeds($post->post_content);

                if ( has_post_format( 'video' ) && isset($embeds[0]) ) {
                    echo '<div class="video-wrapper">';
                    echo $embeds[0];
                    echo '</div>';
                } else {
                    if ( has_post_thumbnail() ) {
                        echo '<div class="thumb-wrapper">';
                        if ( get_post_type( $post->ID ) == 'affiliates'){
                            the_post_thumbnail('aff-thumb');
                        } else {
                            the_post_thumbnail('post-sm');
                        }
                        echo '</div>';
                    }
                }
                ?>
                <div class="new-text-group">
                    <?php $category = get_the_category(); ?>
                    <div class="news-info clearfix">
                        <?php if($category){ echo $category[0]->cat_name; } ?>
                        <span class="pull-right"><?php the_time('d-m-Y'); ?></span>
                    </div>
                    <h2><?php the_title(); ?></h2>
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('read more','poka'); ?></a>
                    <?php /* poka_social_social(); */ ?>
                </div>
                <!-- /.news-text -->

            </div>
            <!-- /.news-item -->
        </div>

        <?php
        if ($counter % 2 != 0 || ($wp_query->current_post +1) == ($wp_query->post_count)) {
            echo '</div>';
        }

 $counter++; endwhile; else: ?>
    <h1><?php _e( 'Nothing Found', 'poka' ); ?></h1>
    <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'poka' ); ?></p>
<?php endif; ?>

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
