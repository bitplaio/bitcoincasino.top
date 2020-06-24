<?php
// =============================================================================
// Table List Shortcode
// =============================================================================
if( ! function_exists( 'tablelist_v2_sc' ) ){
    function tablelist_v2_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "num" => '10',
            "cat" => '',
            "sort" => 'date',
            "logo_aff_link" => "false",
            "reviews" => '',
            "show_counter" => 'true',
            "show_freespins" => 'false',
            "show_rating" => 'true',
            "show_table_sorting" => 'false',
            "css_class" => ''
        ), $atts));

        $query_string = array(
            'post_type' => 'affiliates',
            'lists' => $cat,
            'posts_per_page' => $num
        );

        if( $reviews != '' ){
            $arrayReviews = explode(',', $reviews);
            $query_string['post__in'] = $arrayReviews;
            $query_string['orderby'] = "post__in";
            $query_string['posts_per_page'] = "-1";
        } else {
            if($sort == "rating") {
                if( get_field('allow_user_rating_in_reviews','options') ){
                    $query_string['meta_key'] = "_votes_avg";
                } else {
                    $query_string['meta_key'] = "affiliate_rating";
                }
                $query_string['orderby'] = "meta_value_num";
                $query_string['order'] = "DESC";

            } elseif($sort == "title") {
                $query_string['orderby'] = "title";
                $query_string['order'] = "ASC";

            } elseif($sort == "date") {
                $query_string['orderby'] = "date";
                $query_string['order'] = "DESC";
            }
        }

        if( $css_class != "" ){
            $css_class .= " " . $css_class;
        }

        if( $show_counter != "true" ){
            $css_class .= ' table-s2--hide-counter';
        }

        if( $show_rating != "true" ){
            $css_class .= ' table-s2--hide-rating';
        }

        $html = '<div class="table-s2'. $css_class .'">';

        if( $show_table_sorting != "false" ){
            $html .= poka_get_table_sorting_html( $sort );
        }

        $table_query = new WP_query();
        $table_query->query( $query_string );

        $count = 1;
        if ($table_query->have_posts()) :
            while ($table_query->have_posts()) :
                $table_query->the_post();

                //get ratings number
                if( get_field('allow_user_rating_in_reviews','options') ){
                    $rating_num = get_post_meta(get_the_ID(), "_votes_avg", true);
                } else {
                    $rating_num = get_post_meta(get_the_ID(), "affiliate_rating", true);
                }

                if( $show_table_sorting != "false" ){
                    $sortAttr = ' data-sort-name="'.get_the_title().'" data-sort-rating="'.$rating_num.'" data-sort-date="'.get_the_date('c').'"';
                } else {
                    $sortAttr = "";
                }

                $html .= '<div class="item"'.$sortAttr.'><div class="item-row">';

                //Column logo
                $html .= '<div class="col-logo">';
                $html .= '  <div class="rank-num">'.$count.'</div>';

                $logo_bg = ( get_field('logo_background_color') ) ? ' style="background-color:'.get_field('logo_background_color').'"' : "";
                $html .= '  <div class="logo-box"'. $logo_bg .'>';

                if( $logo_aff_link !== "true" || !get_field('affiliate_link') ){
                    $html .=   '<a href="'.get_permalink().'">'.get_the_post_thumbnail( get_the_ID(), 'aff-thumb' ).'</a>';
                } else {
                    $html .=   '<a href="'.poka_affiliate_url_return( get_field('affiliate_link')->ID ).'" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link')->ID).' class="d-none d-lg-block">'.get_the_post_thumbnail( get_the_ID(), 'aff-thumb' ).'</a>';
                    $html .=   '<a href="'.poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile').'" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link')->ID , 'mobile').' class="hidden-lg-up">'.get_the_post_thumbnail( get_the_ID(), 'aff-thumb' ).'</a>';
                }

                $html .= '  </div><!-- /.logo-box -->';
                $html .= '</div><!-- /.col-logo -->';

                //Column rating
                if( $show_rating == "true" ){

                    $html .= '<div class="col-rating">';
                    $html .=    poka_affiliates_ratings( get_the_ID() );
                    if( get_field('allow_user_rating_in_reviews','options') ){
                        $html .= '<div class="item-ratings-num">';
                        $html .=     poka_get_ratings_total_num( get_the_ID() ) . ' ' . __('ratings','poka');
                        $html .= '</div>';
                    }
                    $html .= '  <a href="'.get_permalink().'" class="btn-read-more">'.poka_get_translation('Review').'</a>';
                    $html .= '</div><!-- /.col-rating -->';

                }

                //Column bonus
                $html .= '<div class="col-bonus">';

                if( $show_freespins != "false" ){
                    $html .= '  <h5>'.get_field('free_spins_promo').'</h5>';
                } else {
                    $html .= '  <h5>'.get_field('bonus_promo_title').'</h5>';
                }

                $html .=    poka_terms_text_return( get_the_ID() );
                $html .= '</div><!-- /.col-bonus -->';

                //Column pros
                $html .= '<div class="col-features">';
                if( get_field('pros') ){
                    $html .= '<ul>';
                    $count_pros = 1;
                    while ( have_rows('pros') ) { the_row();
                        if( $count_pros < 4 ){
                            $html .= '<li>'.get_sub_field('item').'</li>';
                        }
                        $count_pros++;
                    }
                    $html .= '</ul>';
                }
                $html .= '</div><!-- /.col-features -->';

                //Column buttons
                $html .= '<div class="col-btn">';
                    if( get_field('affiliate_link') ) {
                        $html .= '<a href="'.poka_affiliate_url_return( get_field('affiliate_link')->ID ).'" class="btn btn--green btn--full d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link')->ID).'><span class="btn-p1">'.poka_get_translation('Play now').'</span><span class="btn-p2">'.__('Go to','poka') . ' ' . get_the_title() . '</span></a>';
                        $html .= '<a href="'.poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile' ).'" class="btn btn--green btn--full hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link')->ID , 'mobile').'><span class="btn-p1">'.poka_get_translation('Play now').'</span><span class="btn-p2">'.__('Go to','poka') . ' ' . get_the_title() . '</span></a>';
                    }
                $html .= '</div><!-- /.col-btn -->';

                //end of item
                $html .= '</div></div>';

                $count++;
            endwhile;
        endif;
        wp_reset_query();

        $html .= '</div>';

        return $html;
    }
    add_shortcode('table_list_v2', 'tablelist_v2_sc');
}
?>
