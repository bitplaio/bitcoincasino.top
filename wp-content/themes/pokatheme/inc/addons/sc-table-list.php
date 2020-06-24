<?php
// =============================================================================
// Table List Shortcode
// =============================================================================
if( ! function_exists( 'tablelist' ) ){
    function tablelist($atts, $content = null) {
        extract(shortcode_atts(array(
            "num" => '10',
            "cat" => '',
            "sort" => '',
            "big_table" => 'false',
            "logo_aff_link" => 'false',
            "reviews" => '',
            "logo_color_box" => 'false',
            "show_table_sorting" => 'false',
            "css_class" => ''
        ), $atts));

        if( $big_table == "true" ) {
            $big_table = true;
        } else {
            $big_table = false;
        }

        if( $logo_aff_link == "true" ) {
            $logo_aff_link = true;
        } else {
            $logo_aff_link = false;
        }

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


        $html='';

        if($big_table == true) {
            $class = " table-big";
        } else {
            $class = "";
        }

        if( $css_class != '' ){
            $class = $class . ' ' . $css_class;
        }

        $html .= '<div class="table-s1'. $class .'">';

        if( $show_table_sorting != "false" ){
            $html .= poka_get_table_sorting_html( $sort );
        }

        $table_query = new WP_query();
        $table_query->query( $query_string );

        $count = 1;
        if ($table_query->have_posts()) : while ($table_query->have_posts()) : $table_query->the_post();

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'aff-thumb' );

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

            $html .= '<div class="item clearfix"'.$sortAttr.'>';
            $html .=   '<div class="c1"><div class="table"><div class="table-cell">';
            $html .=   '<div class="count">'.$count.'.</div>';
            $html .=   '</div></div></div>';
            $html .=   '<div class="c2"><div class="table"><div class="table-cell">';

            if( $big_table === false && $logo_color_box != "false" ){
                $logo_bg = ( get_field('logo_background_color') ) ? ' style="background-color:'.get_field('logo_background_color').'"' : "";
            } else {
                $logo_bg = "";
            }

            if( $logo_aff_link === false || !get_field('affiliate_link') ){
                $html .=   '	<a href="'.get_permalink().'"'.(($logo_color_box != "false" && $big_table === false) ? 'class="logo-boxed"' : "").''. $logo_bg .'><img src="'.$thumb[0].'" alt="'. get_the_title() .'" /></a>';
            } else {

                $html .=   '	<a href="'.poka_affiliate_url_return( get_field('affiliate_link')->ID ).'" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link')->ID).' class="d-none d-lg-block'.(($logo_color_box != "false" && $big_table === false) ? ' logo-boxed' : "").'"'. $logo_bg .'><img src="'.$thumb[0].'" alt="'. get_the_title() .'" /></a>';
                $html .=   '	<a href="'.poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile').'" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link')->ID , 'mobile').' class="hidden-lg-up'.(($logo_color_box != "false" && $big_table === false) ? ' logo-boxed' : "").'"'. $logo_bg .'><img src="'.$thumb[0].'" alt="'. get_the_title() .'" /></a>';
            }
            $html .=   '</div></div></div>';
            $html .=   '<div class="c3"><div class="table"><div class="table-cell">';
            $html .=   poka_affiliates_ratings(get_the_ID());
            if($big_table == true) {
                $html .=   '<a href="'.get_permalink().'" class="review-link">'.esc_html__('Read review','poka').'</a>';
            }
            $html .=   '</div></div></div>';
            $html .=   '<div class="c4"><div class="table"><div class="table-cell"><i class="icon-poka icon-poka-arrow-right"></i>';
            $html .=   '<h4>'.get_field('bonus_promo_title').'</h4>';
            $html .=   '<p>'.get_field('affiliate_small_info').'</p>';
            if($big_table == true) {
                $html .=   '<i class="icon-poka icon-poka-arrow-right icon-right"></i>';
            }
            $html .=   '</div></div></div>';
            $html .=   '<div class="c5"><div class="table"><div class="table-cell">';
            if($big_table == false) {
                if( get_field('affiliate_link') ) {
                    $col_class = "col-6 col-lg-12";
                } else {
                    $col_class = "col-12";
                }
                $html .=   '<div class="row row-sm"><div class="'.$col_class.'"><a href="'.get_permalink().'" class="btn btn--blue btn--full">'.poka_get_translation('Review').'</a></div><div class="'.$col_class.'">';
            }
            if( get_field('affiliate_link') ) {
                $html .=   '<a href="'.poka_affiliate_url_return( get_field('affiliate_link')->ID ).'" class="btn btn--green btn--full d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link')->ID).'>'.poka_get_translation('Play now').'</a>';
                $html .=   '<a href="'.poka_affiliate_url_return( get_field('affiliate_link')->ID , 'mobile' ).'" class="btn btn--green btn--full hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link')->ID , 'mobile').'>'.poka_get_translation('Play now').'</a>';
            }

            $html .=   poka_terms_text_return( get_the_ID() );
            if($big_table == false) {
                $html .=  '</div></div>';
            }
            $html .=   '</div></div></div>';
            $html .=  '</div>';


        $count++;
        endwhile; endif;
        wp_reset_query();

        $html .= '</div>';

        return $html;
    }
    add_shortcode('table_list', 'tablelist');
    add_shortcode('table-list', 'tablelist');
}

?>
