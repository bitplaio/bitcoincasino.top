<?php
// =============================================================================
// Ratings code
// =============================================================================

if( ! function_exists( 'poka_return_rating_icons' ) ){
    function poka_return_rating_icons(){

        $rating_icons = array(
            'full_star'  => '<span class="star full-star"><i class="icon-poka icon-poka-full-star"></i></span>',
            'half_star'  => '<span class="star"><i class="icon-poka icon-poka-half-star"></i></span>',
            'empty_star' => '<span class="star"><i class="icon-poka icon-poka-empty-star"></i></span>',
        );

        return apply_filters('poka_rating_icons_array', $rating_icons);

    }
}

if( ! function_exists( 'poka_save_review_act' ) ){
    function poka_save_review_act( $post_id, $post, $update ) {

        $slug = 'affiliates';

        // If this isn't a 'review' post, don't update it.
        if ( $slug != $post->post_type || get_post_meta($post_id,'affiliate_rating',true) == null ) {
            return;
        }

        if( get_post_meta($post_id, "rating_override", true) ){
            update_post_meta($post_id, "_votes_avg", get_post_meta($post_id, "affiliate_rating", true));
        } else {
            $stars = get_post_meta($post_id,'affiliate_rating',true);
            $meta_count = get_post_meta($post_id, "_votes_count", true);
            if( !$meta_count ) $meta_count = 0;
            $meta_count++;
            $meta_users = get_post_meta($post_id, "_users_voted");
            $users_voted = ( isset($meta_users[0]) ) ? $meta_users[0] : null;
            if( $users_voted ){
                foreach ($users_voted as &$value) {
                    $sum += $value;
                }
            } else {
                $sum = 0;
            }
            $stars = round(($stars+$sum)/$meta_count,1);

            update_post_meta($post_id, "_votes_avg", $stars);
        }

    }
}
add_action( 'save_post', 'poka_save_review_act', 10, 3 );

/**
 * Echo widgets
 */
if( ! function_exists( 'poka_affiliates_ratings' ) ){
    function poka_affiliates_ratings($post_id) {
        $output = NULL;
        $output = "<div class='rating'>";

        $rating_icons = poka_return_rating_icons();

        $half_icon = apply_filters('poka_ratings_half_icon', true);

        $count = 0;
        $stars = get_post_meta($post_id, "_votes_avg", true);
        if(!$stars || !get_field('allow_user_rating_in_reviews','options') ) {
            $stars = get_field('affiliate_rating',$post_id);
        }

        $rest = 5-$stars;
        while($count < floor($stars)) {
            $output .= $rating_icons['full_star'];
            $count++;
        }
        if( $rest > 0 ){
            $count = 0;
            while($count < $rest) {

                $dec = $stars-floor($stars);

                if( $half_icon ){

                    if( $dec < 0.7 && $dec > 0.3 && is_float($rest) && $count == 0 ){
                        $output .= $rating_icons['half_star'];
                    } else if( $dec >= 0.7 && is_float($rest) && $count == 0 ) {
                        $output .= $rating_icons['full_star'];
                    } else {
                        $output .= $rating_icons['empty_star'];
                    }

                } else {

                    if( $dec >= 0.6 && is_float($rest) && $count == 0 ){
                        $output .= $rating_icons['full_star'];
                    } else {
                        $output .= $rating_icons['empty_star'];
                    }

                }

                $count++;
            }
        }
        $output .= "</div>";
        return $output;
    }
}

if( ! function_exists( 'poka_get_ratings_total_num' ) ){
    function poka_get_ratings_total_num($post_id) {

        $ratings_num = get_field('ratings_number_base',$post_id);
        if( !$ratings_num ) $ratings_num = 18;
        $meta_count = get_post_meta($post_id, "_votes_count", true);
        if( !$meta_count ) $meta_count = 0;
        $total_num = $ratings_num + $meta_count;

        return $total_num;

    }
}



if( ! function_exists( 'poka_affiliates_user_ratings' ) ){
    function poka_affiliates_user_ratings($post_id) {
        $output = NULL;
        global $post;

        $rating_icons = poka_return_rating_icons();
        $half_icon = apply_filters('poka_ratings_half_icon', true);

        $count = 0;
        $stars = get_post_meta($post_id, "_votes_avg", true);
        $rest = 5-$stars;

        if ( is_user_logged_in() || get_field('allow_unregistered_user_rating_in_reviews' , 'options') ) {
            $logged = "yes";
        } else {
            $logged = "no";
        }

        $output = "<div class='rating rating-user' data-stars='".$stars."' data-post-id='".$post->ID."' data-log='".$logged."'>";

        while($count < floor($stars)) {
            $output .= $rating_icons['full_star'];
            $count++;
        }
        if( $rest > 0 ){
            $count = 0;
            while($count < $rest) {

                $dec = $stars-floor($stars);

                if( $half_icon ){

                    if( $dec < 0.7 && $dec > 0.3 && is_float($rest) && $count == 0 ){
                        $output .= $rating_icons['half_star'];
                    } else if( $dec >= 0.7 && is_float($rest) && $count == 0 ) {
                        $output .= $rating_icons['full_star'];
                    } else {
                        $output .= $rating_icons['empty_star'];
                    }

                } else {

                    if( $dec >= 0.6 && is_float($rest) && $count == 0 ){
                        $output .= $rating_icons['full_star'];
                    } else {
                        $output .= $rating_icons['empty_star'];
                    }

                }

                $count++;
            }
        }
        $output .= "</div>";

        $total_num = poka_get_ratings_total_num( $post_id );

        $output .= "<div class='rating-counter'><span>".$total_num."</span> ".__('ratings','poka')."</div>";
        $output .= "<div class='rating-msg'></div>";

        return $output;
    }
}
/**********************************************************************/

add_action('wp_ajax_nopriv_poka_rating', 'poka_ratings');
add_action('wp_ajax_poka_rating', 'poka_ratings');

if( ! function_exists( 'poka_hasAlreadyVoted' ) ){
    function poka_hasAlreadyVoted($post_id , $method="registered"){

        // Retrieve post votes IPs
        $meta_users = get_post_meta($post_id, "_users_voted");
        $users_voted = ( isset($meta_users[0]) ) ? $meta_users[0] : null;

        if(!is_array($users_voted))
            $users_voted = array();

        if( $method === 'registered' ) {
            $current_user = wp_get_current_user();
            $username =  $current_user->user_login;
            $user_key = $username;
        } else {
            $user_ip  = poka_get_ip();
            $user_key = $user_ip;
        }


        // If user has already voted
        if(in_array($user_key, array_keys($users_voted)))
        {
            return true;
        }

        return false;
    }
}

if( ! function_exists( 'poka_ratings' ) ){
    function poka_ratings() {
        // Check for nonce security
        $nonce = $_POST['nonce'];

        if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die ( 'Busted!');

        if ( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            $username =  $current_user->user_login;

            if(isset($_POST['review_rating'])) {

                $post_id = $_POST['post_id'];

                // Get voters'IPs for the current post
                $meta_users = get_post_meta($post_id, "_users_voted");
                $users_voted = ( isset($meta_users[0]) ) ? $meta_users[0] : null;

                if(!is_array($users_voted))
                    $users_voted = array();

                // Get votes count for the current post
                $meta_count = get_post_meta($post_id, "_votes_count", true);
                if( !$meta_count ) $meta_count = 0;


                // Use has already voted ?
                if(!poka_hasAlreadyVoted($post_id))
                {
                    $users_voted[$username] = $_POST['user_rating'];

                    $meta_count++;

                    // Save IP and increase votes count
                    update_post_meta($post_id, "_users_voted", $users_voted);
                    update_post_meta($post_id, "_votes_count", $meta_count);

                    //avg stars
                    if( !get_field('rating_override',$post_id) ){
                        $stars = get_field('affiliate_rating',$post_id);
                        $meta_count++;
                        foreach ($users_voted as &$value) {
                            $sum += $value;
                        }
                        $stars = round(($stars+$sum)/$meta_count,1);

                        update_post_meta($post_id, "_votes_avg", $stars);
                    }

                    // Display count
                    echo $meta_count;
                }
                else
                    echo "already";
            }
        } else if ( get_field('allow_unregistered_user_rating_in_reviews' , 'options') ) {
            $user_ip = poka_get_ip();

            if(isset($_POST['review_rating'])) {

                $post_id = $_POST['post_id'];

                // Get voters'IPs for the current post
                $meta_users = get_post_meta($post_id, "_users_voted");
                $users_voted = ( isset($meta_users[0]) ) ? $meta_users[0] : null;

                if(!is_array($users_voted))
                    $users_voted = array();

                // Get votes count for the current post
                $meta_count = get_post_meta($post_id, "_votes_count", true);
                if( !$meta_count ) $meta_count = 0;


                // Use has already voted ?
                if(!poka_hasAlreadyVoted($post_id , 'unregistered'))
                {
                    $users_voted[$user_ip] = $_POST['user_rating'];

                    $meta_count++;

                    // Save IP and increase votes count
                    update_post_meta($post_id, "_users_voted", $users_voted);
                    update_post_meta($post_id, "_votes_count", $meta_count);

                    //avg stars
                    if( !get_field('rating_override',$post_id) ){
                        $stars = get_field('affiliate_rating',$post_id);
                        $meta_count++;
                        foreach ($users_voted as &$value) {
                            $sum += $value;
                        }
                        $stars = round(($stars+$sum)/$meta_count,1);

                        update_post_meta($post_id, "_votes_avg", $stars);
                    }

                    // Display count
                    echo $meta_count;
                }
                else
                    echo "already";
            }
        }else {
            echo 'login';
        }
        exit;
    }
}

function poka_get_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return apply_filters( 'wpb_get_ip', $ip );
}
