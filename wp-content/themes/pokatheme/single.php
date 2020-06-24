<?php
// =============================================================================
// The Template for displaying all single posts.
// =============================================================================
get_header(); ?>

    <?php do_action( 'poka_before_main' ); ?>

    <main id="main">
        <div class="container">
            <div class="row">
                <?php $poka_main_col_class = apply_filters('poka_main_col_class_filter', 'col-md-8'); ?>
                <div class="<?php echo $poka_main_col_class; ?> main-col">
                    <div class="single-post-wrapper text-area">

                       <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                       <h1><?php the_title(); ?></h1>

                        <div class="post-info clearfix">
                            <div class="post-info__left">
                                <strong><?php _e( 'Categories:', 'poka' ); ?></strong> <?php echo get_the_category_list( ', ' ); ?>
                                <span class="seperator">|</span>
                                <strong><?php _e( 'Published by:', 'poka' ); ?></strong> <?php the_author(); ?>
                            </div>
                            <div class="post-info__right">
                                <span class="date"><?php the_time('d/m/Y'); ?></span>
                            </div>
                            <!-- /.post-info__right -->
                        </div>
                        <!-- /.post-info -->

                        <?php
                        if ( has_post_thumbnail() && !get_field('hide_featured_image' , 'options') ) {
                            echo '<div class="img-wrapper">';
                            the_post_thumbnail('full');
                            echo '</div>';
                        }
                        ?>
                        <?php the_content(); ?>

                        <div class="post-share">
                            <?php poka_social_share(); ?>
                        </div>
                        <!-- /.post-share -->

                        <?php endwhile; endif; ?>

                        <?php if( get_field('show_related_articles_post','options') ): ?>
                            <?php
                            //Relevant articles
                            $query_string = array(
                                'post__not_in' => array( $post->ID ),
                                'category__in' => wp_get_post_categories( $post->ID ),
                                'posts_per_page' => 6
                            );

                            $news_query = new WP_query();
                            $news_query->query( $query_string );
                            if ($news_query->have_posts()) :
                            ?>
                            <h3><?php _e('Relevant news','poka'); ?></h3>
                            <div class="relevant-news-wrapper news-list">
                                <div class="owl-carousel carousel-relevant">
                                <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                                    <div class="item">
                                        <?php the_post_thumbnail('post-sm'); ?>
                                        <div class="text">
                                            <h4><?php the_title(); ?></h4>
                                            <p><?php echo wp_trim_words(get_the_content(),15); ?></p>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="btn btn--blue"><?php _e('read more +','poka'); ?></a>
                                    </div>
                                <?php endwhile; ?>
                                </div>
                                <!-- /.owl-carousel -->
                            </div>
                            <!-- /.relevant-news-wrapper -->

                            <?php endif; ?>
                            <?php wp_reset_query(); ?>
                        <?php endif; ?>

                        <div id="comments-section">
                            <?php
                            if( get_field('users_comment_posts','options') ){
                                if ( comments_open() || get_comments_number() ) {
                                    comments_template();
                                }
                            }
                            ?>
                        </div>
                        <!-- /#comments-section -->

                    </div>
                    <!-- /.single-post -->

                </div>
                <!-- /.col-md-8 -->

                <?php get_sidebar(); ?>
            </div>
        </div>
        <!-- /.container -->
    </main>
    <!-- /#main -->

    <?php do_action( 'poka_after_main' ); ?>

<?php get_footer(); ?>
