<?php
// =============================================================================
// Various Shortcodes
// =============================================================================

/**
** Button
**/
if( ! function_exists( 'btn_sc' ) ){
    function btn_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "href" => ''
        ), $atts));

        return '<a class="btn btn--blue" href="'.$href.'">'.$content.'</a>';
    }
}
add_shortcode("btn", "btn_sc");
/**********************************************************************/

/**
** Box text
**/
if( ! function_exists( 'box_text_sc' ) ){
    function box_text_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "icon" => ''
        ), $atts));
        if( $icon != "" ){
            $classes = "box-text box-text--icon";
        } else {
            $classes = "box-text";
        }
        return '<div class="'.$classes.'" data-icon="'.$icon.'">'.do_shortcode($content).'</div>';
    }
}
add_shortcode("box_text", "box_text_sc");
/**********************************************************************/

/**
** Latest news
**/
if( ! function_exists( 'latest_news' ) ){
    function latest_news($atts, $content = null) {
        extract(shortcode_atts(array(
            "num" => 6,
            "cat" => "",
            "descr_excerpt" => "false",
            "descr_length" => 15,
            "read_more_text" => esc_html__('read all news','poka'),
            "read_more_show" => "true",
            "ajax_load_more" => "false"
        ), $atts));

        $output = '<div class="news-list">';
        $output .= '<div class="row row-md">';
        $index = 0;



        $query_string = array(
            'cat' => $cat,
            'posts_per_page' => $num
        );

        $news_query = new WP_query();
        $news_query->query( $query_string );
        if ($news_query->have_posts()) : while ($news_query->have_posts()) : $news_query->the_post();

        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'post-sm' );
        $img = "";

        $embeds = poka_get_embeds(strip_shortcodes(get_the_content()));

        if( $thumb ){
            $img = '<a href="'.get_permalink().'"><img src="'.$thumb['0'].'" alt="'.get_the_title().'"/></a>';
        } elseif( isset($embeds[0]) ) {
            $img = $embeds[0];
        }

        if( $descr_excerpt == "true" ){
            $descr = wp_trim_words(get_the_excerpt(),(int) $descr_length);
        } else {
            $descr = wp_trim_words(get_the_content(),(int) $descr_length);
        }

        $output .= '<div class="col-lg-4 col-md-6"><div class="item">
                        ' . $img . '
                        <div class="text">
                        <h4>'.get_the_title().'</h4>
                        <p>'.$descr.'</p>
                        </div>
                        <a href="'.get_permalink().'" class="btn btn--blue">'.esc_html__('read more +','poka').'</a>
                    </div></div>';


        $index++;
        endwhile; endif;
        wp_reset_query();

        $output .= '</div>';
        if ( $ajax_load_more === "true" && $news_query->found_posts > $num ) {
            $output .= '<div class="center-area latest-news-rmore-wrapper"><a href="#" class="btn btn--black btn--read-more jsNewsAjaxLoadMore" data-cat="'.$cat.'" data-offset="'.$num.'" data-descr-excerpt="'.$descr_excerpt.'" data-descr-length="'.$descr_length.'">'.$read_more_text.'<span class="spinner"></span></a></div>';
        }
        $output .= '</div>';

        if( $cat && $ajax_load_more !=="true" && $read_more_show == "true" ){
            $output .= '<div class="center-area latest-news-rmore-wrapper"><a href="'.get_category_link($cat).'" class="btn btn--black btn--read-more">'.$read_more_text.'<i class="icon-poka icon-poka-solid-arrow-right"></i></a></div>';
        }

        return $output;

    }
}
add_shortcode("latest_news", "latest_news");
/**********************************************************************/




/**
 ** Latest news
 **/
if( ! function_exists( 'latest_news_sidebar' ) ){
    function latest_news_sidebar($atts, $content = null) {
        extract(shortcode_atts(array(
            "num" => 4,
            "cat" => ""
        ), $atts));

        $output = '<div class="news-list-sidebar clearfix">';
        $output .= '<div class="news-sidebar-group clearfix">';

        $query_string = array(
            'cat' => $cat,
            'posts_per_page' => $num
        );

        $news_query = new WP_query();
        $news_query->query( $query_string );
        if ($news_query->have_posts()) : while ($news_query->have_posts()) : $news_query->the_post();

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'post-sm-square' );

            if( $thumb ){
                $img = '<img src="'.$thumb['0'].'" alt="'.get_the_title().'"/>';
            } else {
                $img = '';
            }

            $output .= '<div class="item clearfix">
                        ' . $img . '
                        <div class="text">
                        <h4>'.get_the_title().'</h4>
                        <a href="'.get_permalink().'" class="read-more">'.esc_html__('read more','poka').'</a>
                        </div>
                    </div>';

        endwhile; endif;
        wp_reset_query();

        if( $cat ){
            $output .= '<div class="center-area"><a href="'.get_category_link($cat).'" class="btn btn--blue">'.esc_html__('read all','poka').'</a></div>';
        }
        $output .= "</div></div>";
        return $output;

    }
}
add_shortcode("latest_news_sidebar", "latest_news_sidebar");
/**********************************************************************/

/**
 ** casino guides
 **/
if( ! function_exists( 'news_boxes_sc' ) ){
    function news_boxes_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "cat" => ""
        ), $atts));

        $output = '<div class="casino-guides clearfix">';
        $output .='<div class="row">';

        $query_string = array(
            'cat' => $cat,
            'posts_per_page' => 1
        );

        $news_query = new WP_query();
        $news_query->query( $query_string );
        if ($news_query->have_posts()) : while ($news_query->have_posts()) : $news_query->the_post();

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'post-thumbnail' );

            $output .= '<div class="col-lg-5 col-xs-12"><div class="casino-guide-box casino-guide-box--first" style="background: url('.$thumb['0'].')no-repeat center center; background-size:cover;">';
            if ( has_post_format( 'video' ) ) :
                $output .='<div class="label-guide label-guide--video"><i class="icon-poka icon-poka-play"></i>'.esc_html__('video','poka').'</div>';
            else:
                $output .='<div class="label-guide label-guide--article"><i class="icon-poka icon-poka-list"></i>'.esc_html__('article','poka').'</div>';
            endif;
            $output .= '<a href="'.get_permalink().'" class="item">
                        <div class="text">
                        <h4>'.wp_trim_words(get_the_title(),10).'</h4>
                        <p>'.wp_trim_words(get_the_excerpt(),15).'</p>
                        <span class="btn">'.esc_html__('read more','poka').'<i class="icon-poka icon-poka-plus"></i></span>
                        </div>
                    </a></div></div>';


        endwhile; endif;
        wp_reset_query();

        $output .='<div class="col-lg-7 col-xs-12"><div class="row">';
        $query_string2 = array(
            'cat' => $cat,
            'posts_per_page' => 4,
            'offset' =>'1'
        );

        $news_query2 = new WP_query();
        $news_query2->query( $query_string2 );
        if ($news_query2->have_posts()) : while ($news_query2->have_posts()) : $news_query2->the_post();

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'post-sm' );

            $output .= '<div class="col-md-6 col-sm-12"><div class="casino-guide-box" style="background: url('.$thumb['0'].')no-repeat center center; background-size:cover;">';
            if ( has_post_format( 'video' ) ) :
                $output .='<div class="label-guide label-guide--video"><i class="icon-poka icon-poka-play"></i>'.esc_html__('video','poka').'</div>';
            else:
                $output .='<div class="label-guide label-guide--article"><i class="icon-poka icon-poka-list"></i>'.esc_html__('article','poka').'</div>';
            endif;
            $output .= '<a href="'.get_permalink().'"  class="item">
                        <div class="text">
                        <h4>'.wp_trim_words(get_the_title(),6).'</h4>
                        </div>
                    </a></div></div>';


        endwhile; endif;
        wp_reset_query();

        $output .= "</div></div></div></div>";
        return $output;

    }
}
add_shortcode("news_boxes", "news_boxes_sc");
/**********************************************************************/


/**
** Ups and Downs in Single Affiliate
**/
if( ! function_exists( 'upsdowns_sc' ) ){
    function upsdowns_sc($atts, $content = null) {

        extract(shortcode_atts(array(
            "id" => get_the_ID()
        ), $atts));

        $output = NULL;
        $output .= '<div class="ups-downs"><h5>'.esc_html__('Pros / Cons','poka').'</h5><div class="row"><div class="col-md-6 col-sm-12"><div class="icon green"><i class="icon-poka icon-poka-arrow-up"></i></div><ul>';
        while ( have_rows('pros', $id) ) { the_row();
            $output .= '<li>'.get_sub_field('item').'</li>';
        }
        $output .= '</ul></div><div class="col-md-6 col-sm-12"><div class="icon red"><i class="icon-poka icon-poka-arrow-down"></i></div><ul>';
        while ( have_rows('cons', $id) ) { the_row();
            $output .= '<li>'.get_sub_field('item').'</li>';
        }
        $output .= '</ul></div></div></div>';
        return $output;

    }
}
add_shortcode("upsdowns", "upsdowns_sc");
/**********************************************************************/

/**
** Slider
**/
if( ! function_exists( 'poka_slider_sc' ) ){
    function poka_slider_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "title" => ""
        ), $atts));

        $page = get_page_by_title( $title, '', 'slider' );

        $output = NULL;

        if( $page ){
            $output .= '<div class="slideshow cycle-slideshow" data-cycle-swipe=true data-cycle-fx="fade" data-timeout="'.get_field('slider_timeout',$page->ID).'" data-cycle-slides="> div.slide" data-cycle-pause-on-hover="true" data-cycle-log="false" data-cycle-auto-height="calc">';

            while ( have_rows('slider_images',$page->ID) ) { the_row();

                $classes = "";

                if( get_sub_field('text_position',$page->ID) == "Right" ){
                    $classes .= "text-right";
                }
                if( get_sub_field('text_background',$page->ID) ){
                    $classes .= " text-bg";
                }

               $output .= '<div class="slide" style="background-image:url('.get_sub_field('image',$page->ID).'); background-repeat:no-repeat; background-position: '.get_sub_field('image_horizontal_alignment',$page->ID).' '.get_sub_field('image_vertical_alignment',$page->ID).';">
                            <img src="'.get_sub_field('image',$page->ID).'" alt="Slider image"/>
                            <div class="table">
                                <div class="table-cell">
                                    <div class="text '.$classes.'">'.get_sub_field('slide_text',$page->ID).'</div>
                                </div>
                            </div>
                            <!-- /.text -->
                        </div>';

            }

            $output .= '<div class="cycle-pager"></div>
                        <a href="" class="cycle-prev"><i class="icon-poka icon-poka-arrow-left"></i></a>
                        <a href="" class="cycle-next"><i class="icon-poka icon-poka-arrow-right"></i></a>
                    </div>
                    <!-- /.slideshow -->';
        }
        return $output;

    }
}
add_shortcode("poka_slider", "poka_slider_sc");
/**********************************************************************/


/**
 ** Slider screnshots
 **/
if( ! function_exists( 'poka_screenshots_carousel_sc' ) ){
    function poka_screenshots_carousel_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "title" => __('Screenshots','poka')
        ), $atts));

        $output = NULL;
        $output .='<div class="slider-carousel-group">';
        $output .='<h5>' .$title. '</h5>';

        if( function_exists('is_amp_endpoint') && is_amp_endpoint() ) {
            $output .= '<amp-carousel height="200" layout="fixed-height" type="carousel">';
            while ( have_rows('affiliate_thumbnails') ) { the_row();
                $att_id = get_sub_field('image');
                $image_alt = ( get_post_meta($att_id, '_wp_attachment_image_alt', TRUE) ? get_post_meta($att_id, '_wp_attachment_image_alt', TRUE) : "Screenshot" );
                $aff_image_full = wp_get_attachment_image_src($att_id,'post-sm');
                $output .=' <amp-img src="'.$aff_image_full[0].'" width="360" height="200" alt="'.$image_alt.'"></amp-img>';
            }
            $output .= '</amp-carousel>';
        } else {
            $output .='<div class="owl-carousel carousel-screenshot">';
            while ( have_rows('affiliate_thumbnails') ) { the_row();
                $att_id = get_sub_field('image');
                $aff_image_full = wp_get_attachment_image_src($att_id,'full');
                $image_alt = ( get_post_meta($att_id, '_wp_attachment_image_alt', TRUE) ? get_post_meta($att_id, '_wp_attachment_image_alt', TRUE) : "Screenshot" );
                $aff_image = wp_get_attachment_image_src( $att_id, 'screen-sm' );
                $output .='<div class="item">
                    <a href="'.$aff_image_full[0].'" class="lightbox"><img src=" '. $aff_image[0] .' " alt="'.$image_alt.'"/></a>
                </div>';
            }
            $output .= '</div>';
        }

        $output .= '</div>';

        return $output;

    }
}
add_shortcode("screenshots_carousel", "poka_screenshots_carousel_sc");

//legacy issue
add_shortcode("poka_slider_carousel", "poka_screenshots_carousel_sc");


/**
** Cols
**/

//Two cols
function poka_col_onehalf_sc($atts, $content = null) {

    $output = '<div class="row"><div class="col-lg-6">' . do_shortcode($content) . '</div>';
    return str_replace("\r\n", '', $output);

}
add_shortcode("two-cols-first", "poka_col_onehalf_sc");

function poka_col_lasthalf_sc($atts, $content = null) {

    $output = '<div class="col-lg-6">' . do_shortcode($content) . '</div></div>';
    return str_replace("\r\n", '', $output);

}
add_shortcode("two-cols-last", "poka_col_lasthalf_sc");


//Three cols
function poka_col_onethird_sc($atts, $content = null) {

    $output = '<div class="row"><div class="col-lg-4">' . do_shortcode($content) . '</div>';
    return str_replace("\r\n", '', $output);

}
add_shortcode("three-cols-first", "poka_col_onethird_sc");

function poka_col_secondthird_sc($atts, $content = null) {

    $output = '<div class="col-lg-4">' . do_shortcode($content) . '</div>';
    return str_replace("\r\n", '', $output);

}
add_shortcode("three-cols-middle", "poka_col_secondthird_sc");

function poka_col_lastthird_sc($atts, $content = null) {

    $output = '<div class="col-lg-4">' . do_shortcode($content) . '</div></div>';
    return str_replace("\r\n", '', $output);

}
add_shortcode("three-cols-last", "poka_col_lastthird_sc");

//Four cols
function poka_col_onefourth_sc($atts, $content = null) {

    $output = '<div class="row"><div class="col-lg-3">' . do_shortcode($content) . '</div>';
    return str_replace("\r\n", '', $output);

}
add_shortcode("four-cols-first", "poka_col_onefourth_sc");

function poka_col_middlefourth_sc($atts, $content = null) {

    $output = '<div class="col-lg-3">' . do_shortcode($content) . '</div>';
    return str_replace("\r\n", '', $output);

}
add_shortcode("four-cols-middle", "poka_col_middlefourth_sc");

function poka_col_lastfourth_sc($atts, $content = null) {

    $output = '<div class="col-lg-3">' . do_shortcode($content) . '</div></div>';
    return str_replace("\r\n", '', $output);

}
add_shortcode("four-cols-last", "poka_col_lastfourth_sc");
/**********************************************************************/

/**
** Single affiliate
**/
if( ! function_exists( 'poka_single_affiliate_sc' ) ){
    function poka_single_affiliate_sc($atts) {
        extract(shortcode_atts(array(
            "title" => "",
            "size"  => "small",
            "id"    => "",
        ), $atts));

        if( $id != "" ){
            $post = get_post($id);
        }else{
            $post = get_page_by_title( $title, '', 'affiliates' );
        }


        if( $post ){

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'aff-thumb' );

            if( get_field('affiliate_link' , $post->ID) ) {
                $btn_aff = '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID ).'" class="btn btn--green btn--full d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID).'>'.poka_get_translation('Play now').'</a>';
                $btn_aff .= '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID , 'mobile' ).'" class="btn btn--green btn--full hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID , 'mobile').'>'.poka_get_translation('Play now').'</a>';
            } else {
                $btn_aff = '';
            }
            $rating = poka_affiliates_ratings($post->ID);

            $terms_text = poka_terms_text_return( $post->ID );

            $output = NULL;

            if( get_field('affiliate_small_info',$post->ID) ){
                $aff_text = mb_strimwidth(get_field('affiliate_small_info',$post->ID), 0, 125, '...');
            } else {
                $aff_text = "";
            }

            if ( $size == "big" ){

                $output .= '<div class="aff-single-widget-big"><div class="row"><div class="col-lg-5"><img src="' . $thumb[0] . '" alt="'.$title.'"/>'.$rating.'</div><div class="col-lg-7"><h4>'.get_field('bonus_promo_title',$post->ID).'</h4><div class="item-descr"><p>' . $aff_text . '</p></div></div></div><div class="row"><div class="col-lg-5"><a href="' . get_permalink($post->ID) . '" class="btn btn--blue btn--full">'.poka_get_translation('Review').'</a></div><div class="col-lg-7">' . $btn_aff . $terms_text . '</div></div></div>';

            } else {

                $output .= '<div class="aff-single-widget"><div class="img"><img src="' . $thumb[0] . '" alt="'.$title.'"/></div><div class="ratings-wrapper">'.$rating.'</div><div class="item-bonus">' . $aff_text . '</div><div class="item-btns"><div class="row row-sm"><div class="col-lg-6"><a href="' . get_permalink($post->ID) . '" class="btn btn--blue btn--full">'.poka_get_translation('Review').'</a></div><div class="col-lg-6">' . $btn_aff . '</div></div>'. $terms_text .'</div></div>';

            }

            return str_replace("\r\n", '', $output);

        }

    }
}
add_shortcode("single_affiliate", "poka_single_affiliate_sc");
/**********************************************************************/

/**
** Single affiliate XL
**/
if( ! function_exists( 'poka_single_affiliate_xl_sc' ) ){
    function poka_single_affiliate_xl_sc($atts) {
        extract(shortcode_atts(array(
            "title" => "",
            "id"    => ""
        ), $atts));

        if( $id != "" ){
            $post = get_post($id);
        }else{
            $post = get_page_by_title( $title, '', 'affiliates' );
        }

        $terms_text = poka_terms_text_return( $post->ID );

        if( $post ){

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'aff-thumb' );

            if( get_field('affiliate_link' , $post->ID) ) {
                $btn_aff = '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID ).'" class="btn btn--green btn--full d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID).'>'.poka_get_translation('Play now').'</a>';
                $btn_aff .= '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID , 'mobile' ).'" class="btn btn--green btn--full hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID , 'mobile').'>'.poka_get_translation('Play now').'</a>';
            } else {
                $btn_aff = '';
            }
            $rating = poka_affiliates_ratings($post->ID);

            $output = NULL;

            $output .= '<div class="aff-single-widget-xl"><div class="row">';
            $output .= '<div class="col-lg-4 widget-img"><img src="' . $thumb[0] . '" alt="'.$title.'"/>'.$rating.'</div>';
            $output .= '<div class="col-lg-8"><div class="widget-text"><i class="icon-right icon-poka icon-poka-arrow-right"></i><h4>'.get_field('bonus_promo_title',$post->ID).'</h4><div class="item-descr"><p>' . get_field('affiliate_small_info',$post->ID) . '</p></div>';
            $output .= '<div class="row row-sm">';
            if( $btn_aff ){
                $output .= '<div class="col-6"><a href="' . get_permalink($post->ID) . '" class="btn btn--blue btn--full">'.poka_get_translation('Review').'</a></div><div class="col-6">' . $btn_aff . $terms_text . '</div>';
            } else {
                $output .= '<div class="col-lg-6"><a href="' . get_permalink($post->ID) . '" class="btn btn--blue btn--full">'.poka_get_translation('Review'). '</a>'.$terms_text .'</div>';
            }
            $output .= '</div></div></div></div></div>';


            return str_replace("\r\n", '', $output);

        }

    }
}
add_shortcode("single_affiliate_xl", "poka_single_affiliate_xl_sc");
/**********************************************************************/

/**
** Single affiliate
**/
if( ! function_exists( 'poka_single_affiliate_spins_sc' ) ){
    function poka_single_affiliate_spins_sc($atts) {
        extract(shortcode_atts(array(
            "title" => "",
            "id"    => ""
        ), $atts));

        if( $id != "" ){
            $post = get_post($id);
        }else{
            $post = get_page_by_title( $title, '', 'affiliates' );
        }

        $terms_text = poka_terms_text_return( $post->ID );

        if( $post ){
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'aff-thumb' );

            if( get_field('affiliate_link' , $post->ID) ) {
                $btn_aff = '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID ).'" class="btn btn--full btn--green d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID).'>'.poka_get_translation('Play now').'</a>';
                $btn_aff .= '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID , 'mobile').'" class="btn btn--full btn--green hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID , 'mobile').'>'.poka_get_translation('Play now').'</a>';
            } else {
                $btn_aff = '';
            }
            $rating = poka_affiliates_ratings($post->ID);

            $output = NULL;

            $output .= '<div class="aff-widget-spins">
                            <div class="thumb">
                                <img src="'.$thumb[0].'" alt="'.$title.'">
                            </div>
                            <!-- /.thumb -->
                            <p>'.get_field('free_spins_promo',$post->ID).'</p>
                            '.$rating.'
                            '.$btn_aff.$terms_text.'
                        </div>
                        <!-- /.aff-widget-spins -->';

            return str_replace("\r\n", '', $output);
        }

    }
}
add_shortcode("single_affiliate_freespins", "poka_single_affiliate_spins_sc");
/**********************************************************************/

/* fix for stray p tags */
add_filter("the_content", "the_content_filter");
function the_content_filter($content) {
	// array of custom shortcodes requiring the fix
	$block = join("|",array("two-cols-first","two-cols-last","three-cols-first","three-cols-middle","three-cols-last"));
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
	return $rep;
}

/**
** Affiliate link button
**/
if( ! function_exists( 'affiliate_link_sc' ) ){
    function affiliate_link_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "id" => ""
        ), $atts));

        if( $id == "" ){
            $postID = get_the_ID();
            $id = get_field('affiliate_link', $postID)->ID;
        }

        $output = '<a href="'.poka_affiliate_url_return( $id ).'" class="btn btn--green d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick($id).'>'.esc_html__($content,'poka').'</a>';
        $output .= '<a href="'.poka_affiliate_url_return( $id , 'mobile' ).'" class="btn btn--green hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick($id , 'mobile').'>'.esc_html__($content,'poka').'</a>';
        return $output;

    }
}
add_shortcode("affiliate_link", "affiliate_link_sc");
/**********************************************************************/

/**
 * Social links
 */
if( ! function_exists( 'poka_social_links_sc' ) ){
    function poka_social_links_sc($atts, $content = null) {

        $output = '<ul class="social-list">';
        if(get_field('youtube_link','options')):
            $output .= '<li><a href="'.get_field('youtube_link','options').'" target="_blank" rel="nofollow"><i class="icon-poka icon-poka-youtube"></i></a></li>';
        endif;
        if(get_field('facebook_link','options')):
            $output .= '<li><a href="'.get_field('facebook_link','options').'" target="_blank" rel="nofollow"><i class="icon-poka icon-poka-facebook"></i></a></li>';
        endif;
        if(get_field('twitter_link','options')):
            $output .= '<li><a href="'.get_field('twitter_link','options').'" target="_blank" rel="nofollow"><i class="icon-poka icon-poka-twitter"></i></a></li>';
        endif;
        if(get_field('instagram_link','options')):
            $output .= '<li><a href="'.get_field('instagram_link','options').'" target="_blank" rel="nofollow"><i class="icon-poka icon-poka-instagram"></i></a></li>';
        endif;
        $output .= '</ul>';
        return $output;
    }
}
add_shortcode("social_links", "poka_social_links_sc");
/**********************************************************************/

/**
** Carousel shortcode
**/
if( ! function_exists( 'affiliates_carousel_sc' ) ){
    function affiliates_carousel_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "posts" => ''
        ), $atts));

        $output = '<div class="carousel owl-carousel">';

        $posts = explode("|", $posts);
        foreach($posts as $post_title) {

            $post = get_page_by_title( $post_title, '', 'affiliates' );
            if( $post ){

                $terms_text = poka_terms_text_return( $post->ID );
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'aff-thumb' );
                $rating = poka_affiliates_ratings($post->ID);

                if( get_field('affiliate_link' , $post->ID) ) {
                    $btn_aff = '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID ).'" class="btn btn--full btn--green d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID).'>'.poka_get_translation('Play now').'</a>';
                    $btn_aff .= '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', $post->ID)->ID , 'mobile' ).'" class="btn btn--full btn--green hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', $post->ID)->ID , 'mobile').'>'.poka_get_translation('Play now').'</a>';
                } else {
                    $btn_aff = '';
                }
                $output .= '<div class="aff-single-widget"><div class="img"><img src="' . $thumb[0] . '" alt="'.$post_title.'"/></div><div class="ratings-wrapper">'.$rating.'</div><div class="item-bonus">' . get_field('affiliate_small_info',$post->ID) . '</div><div class="item-btns"><div class="row row-sm">';
                if( $btn_aff ) {
                    $output .= '<div class="col-lg-6"><a href="' . get_permalink($post->ID) . '" class="btn btn--blue btn--full">'.poka_get_translation('Review').'</a></div><div class="col-lg-6">' . $btn_aff . '</div></div>'.$terms_text.'</div></div>';
                } else {
                    $output .= '<div class="col-lg-12"><a href="' . get_permalink($post->ID) . '" class="btn btn--blue btn--full">'.poka_get_translation('Review').'</a></div></div>'.$terms_text.'</div></div>';
                }

            }
        }


        $output .= '</div>';

        return $output;
    }
}
add_shortcode("affiliates_carousel", "affiliates_carousel_sc");
/**********************************************************************/

/**
** Affiliates list shortcode
**/
if( ! function_exists( 'affiliates_list_sc' ) ){
    function affiliates_list_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "num" => '9',
            "cat" => '',
            "sort" => '',
            "columns" => '3',
            "reviews" => ''
        ), $atts));

        $output = '<div class="taxonomy-list-dif"><div class="row">';

        $query_string = array(
            'post_type' => 'affiliates',
            'lists' => $cat,
            'posts_per_page' => $num
        );

        if( $reviews != '' ){
            $arrayReviews = explode(',', $reviews);
            $query_string['post__in'] = $arrayReviews;
            $query_string['orderby'] = "post__in";
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
                $query_string['order'] = "ASC";
            }
        }

        $list_query = new WP_query();
        $list_query->query( $query_string );
        if ($list_query->have_posts()) : while ($list_query->have_posts()) : $list_query->the_post();

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'aff-thumb' );
            $rating = poka_affiliates_ratings(get_the_ID());

            $terms_text = poka_terms_text_return( get_the_ID() );

            if( get_field('affiliate_link') ) {
                $btn_aff = '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', get_the_ID())->ID ).'" class="btn btn--full btn--green d-none d-lg-block" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', get_the_ID())->ID).'>'.poka_get_translation('Play now').'</a>';
                $btn_aff .= '<a href="'.poka_affiliate_url_return( get_field('affiliate_link', get_the_ID())->ID , 'mobile').'" class="btn btn--full btn--green hidden-lg-up" target="_blank" rel="nofollow" '.poka_link_onclick(get_field('affiliate_link', get_the_ID())->ID , 'mobile').'>'.poka_get_translation('Play now').'</a>';
            } else {
                $btn_aff = '';
            }
            if( $columns == '2' ){
                $output .= '<div class="col-md-6">';
            } else {
                $output .= '<div class="col-lg-4 col-md-6">';
            }
            $output .= '<div class="aff-single-widget"><div class="img"><img src="' . $thumb[0] . '" alt="'.get_the_title().'"/></div><div class="ratings-wrapper">'.$rating.'</div><div class="item-bonus">' . get_field('affiliate_small_info',get_the_ID()) . '</div><div class="item-btns"><div class="row row-sm">';
            if( $btn_aff ) {
                $output .= '<div class="col-lg-6"><a href="' . get_permalink(get_the_ID()) . '" class="btn btn--blue btn--full">'.poka_get_translation('Review').'</a></div><div class="col-lg-6">' . $btn_aff . '</div></div>'.$terms_text.'</div></div>';
            } else {
                $output .= '<div class="col-lg-12"><a href="' . get_permalink(get_the_ID()) . '" class="btn btn--blue btn--full">'.poka_get_translation('Review').'</a></div></div>'.$terms_text.'</div></div>';
            }

            $output .= '</div>';

        endwhile; endif;
        wp_reset_query();
        $output .= '</div></div>';

        return $output;
    }
}
add_shortcode("affiliates_list", "affiliates_list_sc");
/**********************************************************************/

/**
** Affiliates list shortcode
**/
if( ! function_exists( 'search_affiliates_ajax_sc' ) ){
    function search_affiliates_ajax_sc($atts, $content = null) {
        extract(shortcode_atts(array(
            "placeholder" => esc_html__('Search reviews','poka')
        ), $atts));

        $output = '<form class="search-form-ajax" action="'.home_url( '/' ).'">';
        $output .= '    <input type="search" name="s" class="search-form-ajax-input" placeholder="'.$placeholder.'">';
        $output .= '    <button type="submit"><i class="icon-poka icon-poka-search"></i></button>';
        $output .= '    <input type="hidden" name="post_type" value="affiliates">';
        $output .= '</form>';

        wp_enqueue_script('jquery-ui-autocomplete');

        return $output;
    }
}
add_shortcode("search_affiliates_ajax", "search_affiliates_ajax_sc");
/**********************************************************************/

/**
 * Get table shortcode sorting html
 */
if( ! function_exists( 'poka_get_table_sorting_html' ) ){
    function poka_get_table_sorting_html( $sort ){
        $html = '<div class="table-header">';
        $html .= '<span class="sorting-title">'. __('sort by:','poka') .'</span>';
        $html .= '<ul class="sorting-items">';
        $html .= '<li class="'.(($sort == 'date') ? "active " : "").'btn-sort btn-sort-date"><a href="#"><i class="icon-poka icon-poka-calendar"></i>'. __('Date','poka') .'</a></li>';
        $html .= '<li class="'.(($sort == 'title') ? "active " : "").'btn-sort btn-sort-name"><a href="#"><i class="icon-poka icon-poka-alphabetical"></i>'. __('Name','poka') .'</a></li>';
        $html .= '<li class="'.(($sort == 'rating') ? "active " : "").'btn-sort btn-sort-rating"><a href="#"><i class="icon-poka icon-poka-full-star"></i>'. __('Rating','poka') .'</a></li>';
        $html .= '</ul>';
        $html .= '<ul class="sorting-order">';
        $html .= '<li class="'.(($sort != 'rating') ? "active " : "").'btn-order-asc btn-order"><a href="#">'. __('Asc','poka') .'</a></li>';
        $html .= '<li class="'.(($sort == 'rating') ? "active " : "").'btn-order-desc btn-order"><a href="#">'. __('Desc','poka') .'</a></li>';
        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }
}
/**********************************************************************/
