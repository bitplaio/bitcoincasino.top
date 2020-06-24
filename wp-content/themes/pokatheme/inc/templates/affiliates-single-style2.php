<main id="main">
    <div class="main-area-review">
        <div class="container">
            <div class="row">
                <?php $poka_main_col_class = apply_filters('poka_main_col_class_filter', 'col-md-8'); ?>
                <div class="<?php echo $poka_main_col_class; ?>" id="main-text">
                    <div class="single-post text-area">
                        <h1><?php the_title(); ?></h1>
                        <div class="review-up-area review-up-area--dif">
                            <div class="review-up-area__top">
                                <div class="row row--20">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="review-logo-group">
                                            <?php the_post_thumbnail('aff-thumb'); ?>
                                            <div class="clearfix ratings-wrapper">
                                                <?php
                                                if( get_field('allow_user_rating_in_reviews','options') ){
                                                    echo poka_affiliates_user_ratings($post->ID);
                                                } else {
                                                    echo poka_affiliates_ratings($post->ID);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="review-bonus">
                                            <?php if( get_field('bonus_promo_title') ): ?>
                                                <div class="item">
                                                    <h5><?php _e('Bonus','poka'); ?></h5>
                                                    <h4><?php the_field('bonus_promo_title'); ?></h4>
                                                </div>
                                                <!-- /.item -->
                                            <?php endif; ?>
                                            <?php if( get_field('free_spins_promo') ): ?>
                                                <div class="item">
                                                    <h5><?php _e('Free spins','poka'); ?></h5>
                                                    <h4><?php the_field('free_spins_promo'); ?></h4>
                                                </div>
                                                <!-- /.item -->
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.review-up-area__top -->
                            <div class="review-overview">
                                <h5><?php _e('Overview','poka'); ?></h5>
                                <div class="review-info">
                                    <ul>
                                        <?php while ( have_rows('affiliate_info_list') ) { the_row(); ?>
                                            <li><strong><?php the_sub_field('item_title'); ?>: </strong><?php the_sub_field('item_value'); ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php if( get_field('affiliate_link') ): ?>
                                    <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID ); ?>" class="btn btn--full btn--green d-none d-lg-block" target="_blank" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID); ?>><?php echo poka_get_translation('Play now'); ?><span class="poka-icon"><i class="icon-poka icon-poka-solid-arrow-right"></i></span></a>
                                    <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile'); ?>" class="btn btn--full btn--green hidden-lg-up" target="_blank" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID , 'mobile'); ?>><?php echo poka_get_translation('Play now'); ?><span class="poka-icon"><i class="icon-poka icon-poka-solid-arrow-right"></i></span></a>
                                <?php endif; ?>
                                <?php echo poka_terms_text_return( get_the_ID() ); ?>
                            </div>
                        </div>
                        <?php the_content(); ?>

                        <div class="review-bottom-group review-bottom-group--dif">
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    <?php the_post_thumbnail('aff-thumb'); ?>
                                </div>
                                <div class="col-lg-5 col-md-12">
                                    <h4><?php the_field('bonus_promo_title'); ?></h4>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <?php if( get_field('affiliate_link') ): ?>
                                        <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID ); ?>" class="btn btn--full btn--green d-none d-lg-block" target="_blank" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID); ?>><?php echo poka_get_translation('Play now'); ?><span class="poka-icon"><i class="icon-poka icon-poka-solid-arrow-right"></i></span></a>
                                        <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile'); ?>" class="btn btn--full btn--green hidden-lg-up" target="_blank" rel="nofollow" <?php echo poka_link_onclick(get_field('affiliate_link')->ID , 'mobile'); ?>><?php echo poka_get_translation('Play now'); ?><span class="poka-icon"><i class="icon-poka icon-poka-solid-arrow-right"></i></span></a>
                                    <?php endif; ?>
                                    <?php echo poka_terms_text_return( get_the_ID() ); ?>
                                </div>
                            </div>
                        </div>

                        <div id="comments-section">
                            <?php
                            if( get_field('allow_users_to_comment_in_reviews','options') ){
                                if ( comments_open() || get_comments_number() ) {
                                    comments_template();
                                }
                            } elseif( get_field('allow_user_rating_in_reviews','options') ) {
                                poka_login_register();
                            }
                            ?>
                        </div>
                        <!-- /#comments-section -->

                    </div>
                    <!-- /.single-post -->
                </div>
                <!-- /.col9 col-sm-12 -->
                <?php get_sidebar(); ?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
</main>
<!-- /#main -->
