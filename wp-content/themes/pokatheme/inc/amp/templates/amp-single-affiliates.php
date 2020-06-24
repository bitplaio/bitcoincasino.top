<?php
//use of include in order for $this to work in sub templates
include( get_theme_file_path( 'inc/amp/templates/amp-header.php' ) );
?>
    <article class="amp-single-review">
        <div class="amp-review-top">
            <div class="container">
                <?php
                list( $featured_img, $featured_scripts, $featured_styles ) = AMP_Content_Sanitizer::sanitize(
                get_the_post_thumbnail(get_the_ID(), 'aff-thumb'),
                array( 'AMP_Img_Sanitizer' => array() ),
                array(
                    'content_max_width' => $this->get( 'content_max_width' ),
                )
                );
                echo $featured_img;
                ?>
                <div class="clearfix ratings-wrapper">
                    <?php
                        echo poka_affiliates_ratings(get_the_ID());
                    ?>
                </div>
                <?php if( get_field('affiliate_link') ) : ?>
                    <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID ); ?>" class="btn btn--full btn--green d-none d-lg-block" target="_blank" rel="nofollow"><?php echo poka_get_translation('Play now'); ?><span class="poka-icon"><i class="icon-poka icon-poka-solid-arrow-right"></i></span></a>
                    <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID ,'mobile' ); ?>" class="btn btn--full btn--green hidden-lg-up" target="_blank" rel="nofollow"><?php echo poka_get_translation('Play now'); ?><span class="poka-icon"><i class="icon-poka icon-poka-solid-arrow-right"></i></span></a>
                <?php endif; ?>
                <?php echo poka_terms_text_return( get_the_ID(), 'amp' ); ?>
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
                    <?php if( get_field('affiliate_small_info') ): ?>
                        <div class="item">
                            <h5><?php _e('Description','poka'); ?></h5>
                            <p><?php the_field('affiliate_small_info'); ?></p>
                        </div>
                        <!-- /.item -->
                    <?php endif; ?>
                </div>
                <div class="review-overview">
                    <h5><?php _e('Overview','poka'); ?></h5>
                    <div class="review-info">
                        <ul>
                            <?php while ( have_rows('affiliate_info_list') ) { the_row(); ?>
                                <li><strong><?php the_sub_field('item_title'); ?>: </strong><?php the_sub_field('item_value'); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.container -->
        </div>
        <!-- /.amp-review-top -->
        <div class="amp-main-content">
            <div class="container">
                <h1><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>
                <?php echo $this->get( 'post_amp_content' ); ?>
            </div>
            <!-- /.container -->
        </div>
        <!-- /.amp-main-content -->

        <div class="amp-review-bottom">
            <div class="container">
                <?php echo $featured_img; ?>
                <h4><?php the_field('bonus_promo_title'); ?></h4>
                <?php if( get_field('affiliate_link') ) : ?>
                    <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID ); ?>" class="btn btn--full btn--green d-none d-lg-block" target="_blank" rel="nofollow"><?php echo poka_get_translation('Play now'); ?><span class="poka-icon"><i class="icon-poka icon-poka-solid-arrow-right"></i></span></a>
                    <a href="<?php echo poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile' ); ?>" class="btn btn--full btn--green hidden-lg-up" target="_blank" rel="nofollow"><?php echo poka_get_translation('Play now'); ?><span class="poka-icon"><i class="icon-poka icon-poka-solid-arrow-right"></i></span></a>
                <?php endif; ?>
                <?php echo poka_terms_text_return( get_the_ID(), 'amp' ); ?>
            </div>
            <!-- /.container -->
        </div>

    </article>
    <!-- /.amp-single-review -->

<?php include( get_theme_file_path( 'inc/amp/templates/amp-footer.php' ) ); ?>