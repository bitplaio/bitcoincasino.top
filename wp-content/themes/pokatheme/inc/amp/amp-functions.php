<?php
if( get_field('enable_amp_support','options') ){

    include_once( dirname( __FILE__ ) . '/amp-styles.php' );

    /**
     * Add Custom post type support
     *
     * @return void
     */
    function poka_amp_add_review_cpt() {
        if( defined('AMP_QUERY_VAR') ) {
            add_rewrite_endpoint( AMP_QUERY_VAR, EP_PERMALINK | EP_PAGES );
            add_post_type_support( 'affiliates', AMP_QUERY_VAR );
            add_post_type_support( 'page', AMP_QUERY_VAR );
        }
    }
    add_action( 'init', 'poka_amp_add_review_cpt', 11 );

    /**
     * Add custom post types new templates
     *
     * @param [type] $template
     * @param [type] $template_type
     * @param [type] $post
     * @return void
     */
    function poka_amp_set_custom_template( $template, $template_type, $post ) {
        if ( 'single' === $template_type && 'post' === $post->post_type ) {
            $template = get_theme_file_path( 'inc/amp/templates/amp-single.php' );
        }
        if ( 'single' === $template_type && 'affiliates' === $post->post_type ) {
            $template = get_theme_file_path( 'inc/amp/templates/amp-single-affiliates.php' );
        }
        if ( 'page' === $template_type && 'page' === $post->post_type ) {
            $template = get_theme_file_path( 'inc/amp/templates/amp-page.php' );
        }
        return $template;
    }
    add_filter( 'amp_post_template_file', 'poka_amp_set_custom_template', 10, 3 );

    /**
     * Add our AMP components
     *
     * @param [type] $data
     * @return void
     */
    function poka_amp_component_scripts( $data ) {
        $data['amp_component_scripts']['amp-sidebar'] = 'https://cdn.ampproject.org/v0/amp-sidebar-0.1.js';
        $data['amp_component_scripts']['amp-carousel'] = 'https://cdn.ampproject.org/v0/amp-carousel-0.1.js';
        return $data;
    }
    add_action('amp_post_template_data', 'poka_amp_component_scripts');


    /**
     * Change Structured data for reviews
     *
     * @param [type] $metadata
     * @return void
     */
    function poka_change_review_metadata( $metadata ){

        if( is_singular('affiliates') ){

            $rating = "";

            if( get_field('allow_user_rating_in_reviews','options') ){
                $stars = get_post_meta(get_the_ID(), "_votes_avg", true);
                if( $stars && !get_field('rating_override') ){
                    $rating = $stars;
                } else {
                    $rating = get_field('affiliate_rating');
                }
            } else {
                $rating = get_field('affiliate_rating');
            }

            $metadata = array(
                '@context'  => 'http://schema.org',
                '@type'  => 'Review',
                'itemReviewed' => array(
                    '@type' => 'Thing',
                    'name'  => get_the_title(),
                ),
                'author' => array(
                    '@type' => 'Organization',
                    'name'  => get_bloginfo( 'name' ),
                    'url'  => home_url(),
                ),
                'reviewRating' => array(
                    '@type' => 'Rating',
                    'ratingValue'  => $rating,
                    'bestRating'  => "5",
                    'worstRating'  => "1",
                ),
                'datePublished'  => get_the_time('c'),
                'reviewBody'  => get_field('affiliate_small_info'),
            );

        }

        return $metadata;
    }
    add_filter( 'amp_schemaorg_metadata', 'poka_change_review_metadata' );


}
