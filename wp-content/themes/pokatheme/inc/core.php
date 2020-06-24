<?php
// =============================================================================
// Our core functions
// =============================================================================

/**
 * After theme setup
 */
if ( ! function_exists( 'poka_setup' ) ) :
    function poka_setup() {
        // Add RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        //translations
        load_theme_textdomain( 'poka', get_template_directory() . '/languages' );

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 672, 372, true );
        add_image_size( 'aff-thumb', 293, 90, true );
        add_image_size( 'post-sm', 360, 200, true );
        add_image_size( 'post-sm-square', 55, 55, true );
        add_image_size( 'screen-sm', 130, 90, true );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary'   => __( 'Primary menu', 'poka' ),
            'foot1'   => __( 'Footer menu 1', 'poka' )
        ) );

        //Add post format to posts
        add_theme_support( 'post-formats', array( 'standard', 'video' ) );

        //Users must be logged in to post comment
        update_option( 'comment_registration', 1 );

        //Remove rest link from header due to W3C validation error
        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    }
endif;
add_action( 'after_setup_theme', 'poka_setup' );
/**********************************************************************/


/**
 * Include scripts and styles
 */
function poka_scripts() {

    //set static version
    //staging / production
    $setup_type = 'production';
    if( $setup_type == "production" ){
        $static_version = apply_filters('poka_static_version', wp_get_theme(get_template())->get('Version'));
    } elseif( $setup_type == "staging" ) {
        $static_version = time();
    }

    //load our fonts
    if( get_field('font_family','options') && get_field('font_family','options') != "default" ){
        wp_enqueue_style( 'poka-fonts', get_field('font_family','options') . '&display=swap' , array( ) );
    } else if( get_field('font_family','options') != "default" ) {
        wp_enqueue_style( 'poka-fonts', 'https://fonts.googleapis.com/css?family=Rubik:300,400,400i,500,700&display=swap', array( ) );
    }
    if( get_field('font_family_secondary','options') && get_field('font_family_secondary','options') != "same" ){
        wp_enqueue_style( 'poka-fonts-secondary', get_field('font_family_secondary','options'), array( ) );
    }
    // Load our vendor stylesheet.
    if( $setup_type == "production" ){
        wp_enqueue_style( 'poka-vendor-styles', get_theme_file_uri( '/css/styles-vendor.min.css' ), array( ), $static_version );
    } else {
        wp_enqueue_style( 'poka-vendor-styles', get_theme_file_uri( '/css/styles-vendor.css' ), array( ), $static_version );
    }
    // Load our main stylesheet.
    wp_enqueue_style( 'poka-main-styles', get_theme_file_uri( '/css/styles.css' ), array( 'poka-vendor-styles' ), filemtime( get_template_directory().'/css/styles.css' ) );

    //Load our scripts
    if( $setup_type == "production" ){
        wp_enqueue_script( 'poka-scripts-all', get_theme_file_uri( '/js/scripts.all.min.js' ), array( 'jquery' ), $static_version, true );

        $localize_ajax_var = 'poka-scripts-all';
        $localize_poka_string = 'poka-scripts-all';

    } else {
        wp_enqueue_script( 'poka-plugins', get_theme_file_uri( '/js/plugins.js' ), array( 'jquery' ), $static_version, true );
        wp_enqueue_script( 'poka-main', get_theme_file_uri( '/js/main.js' ), array( 'jquery', 'poka-plugins' ), $static_version, true );

        $localize_ajax_var = 'poka-main';
        $localize_poka_string = 'poka-plugins';
    }

    //for ajax vars
    wp_localize_script($localize_ajax_var, 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce'),
        'msg_error' => poka_printmsg('rating_error',true),
        'msg_success' => poka_printmsg('rating_success',true),
        'rating_icons' => poka_return_rating_icons(),
    ));

    wp_localize_script($localize_poka_string, 'poka_strings', array(
        'search' => __('Search','poka')
    ));

    //if the classic editor is active remove unused styles from frontend
    if( ! gutenberg_is_active() ){
        wp_dequeue_style( 'wp-block-library' );
    }


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'poka_scripts' );
/**********************************************************************/

/**
 * Move jQuery to the footer.
 */
if( ! function_exists('poka_move_jquery_bottom') ) {
    function poka_move_jquery_bottom() {

        if( is_admin() ) {
            return;
        }

        wp_scripts()->add_data( 'jquery', 'group', 1 );
        wp_scripts()->add_data( 'jquery-core', 'group', 1 );
        wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
    }
}
add_action( 'wp_enqueue_scripts', 'poka_move_jquery_bottom' );
/**********************************************************************/

/**
 * Create a nicely formatted and more specific title element text for output
 */
function poka_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'poka' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'poka_wp_title', 10, 2 );
/**********************************************************************/


// Display User IP
function get_the_user_ip() {
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


/**
 * Remove width/height attrs
 */
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
add_filter('wp_get_attachment_link', 'remove_width_attribute', 10, 1);

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}
/**********************************************************************/


//ACF integration
// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path( $path ) {

    // update path
    $path = get_template_directory() . '/inc/acf/';

    // return
    return $path;

}

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir( $dir ) {

    // update path
    $dir = get_template_directory_uri() . '/inc/acf/';

    // return
    return $dir;

}

// 3. Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_false');

// Dont show updates
add_filter('acf/settings/show_updates', '__return_false');

// 4. Include ACF
include_once( get_template_directory() . '/inc/acf/acf.php' );

/**
 * Options
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> __('Theme General Settings','poka'),
		'menu_title'	=> __('Theme Settings','poka'),
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Visual Settings','poka'),
		'menu_title'	=> __('Visual Settings','poka'),
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Translations','poka'),
		'menu_title'	=> __('Translations','poka'),
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Recommended Plugins','poka'),
		'menu_title'	=> __('Recommended Plugins','poka'),
		'parent_slug'	=> 'theme-general-settings',
	));
}
/**********************************************************************/


/**
 * Remove Empty p tags before shortcodes
 */
function poka_shortcode_empty_paragraph_fix( $content ) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );

    $content = strtr( $content, $array );

    return $content;
}
add_filter( 'widget_text_content', 'poka_shortcode_empty_paragraph_fix' );
add_filter( 'the_content', 'poka_shortcode_empty_paragraph_fix' );
/**********************************************************************/

/**
 * Get menu title
 */
function get_menu_title_by_location( $location ) {
    if( empty($location) ) return false;

    $locations = get_nav_menu_locations();
    if( ! isset( $locations[$location] ) ) return false;

    $menu_obj = get_term( $locations[$location], 'nav_menu' );

    return $menu_obj->name;
}
/**********************************************************************/

/**
 * Register Sidebars
 */
if( ! function_exists( 'poka_widgets_init' ) ){
    function poka_widgets_init() {

        // Primary Widget area
        register_sidebar( array(
            'name' => 'Primary Widget Area',
            'id' => 'primary-widget-area',
            'description' => 'The primary widget area',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ) );

        // Primary Widget area
        register_sidebar( array(
            'name' => 'Footer Widget Area Top',
            'id' => 'footer-widget-area-top',
            'description' => 'Footer widget area',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ) );

        // Primary Widget area
        register_sidebar( array(
            'name' => 'Footer Widget Area Bottom',
            'id' => 'footer-widget-area-bottom',
            'description' => 'Footer widget area',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ) );

        unregister_widget('WP_Widget_Search');
    }
    add_action( 'widgets_init', 'poka_widgets_init' );
}

//count widgets
function widget_count( $widget_area_id ) {
    $widget_areas = wp_get_sidebars_widgets();

    if( empty( $widget_areas[$widget_area_id] ) ) {
        return false;
    } else {
        return count( $widget_areas[$widget_area_id] );
    }
}

//Enable shortcodes in text widget
add_filter('widget_text', 'do_shortcode');

/**********************************************************************/


/**
 * Redirect
 */
if( ! function_exists( 'gamblingtheme_redirect' ) ){
    function gamblingtheme_redirect() {
        global $wpdb;

        $request = $_SERVER['REQUEST_URI'];
        if (!isset($_SERVER['REQUEST_URI'])) {
            $request = substr($_SERVER['PHP_SELF'], 1);
            if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
        }

        $urlparts = explode("/", $request);

        $folder = get_field('affiliate_redirect_link_folder','options');
        if( ! $folder ) {
            $folder = "go";
        }

        if ( $urlparts[sizeof($urlparts)-2] === $folder ) {

            $is_mobile = false;
            $casino_param = explode('?',$urlparts[sizeof($urlparts)-1]);
            $casino_name = $casino_param[0];

            if( $casino_param[sizeof($casino_param)-1] === '$mobile') {
                $is_mobile = true;
            }


            $querystr = "SELECT wposts.* FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_value = '".$casino_name."' AND wpostmeta.meta_key = 'affiliate_key' AND wposts.post_type = 'affiliate_links' AND wposts.post_status = 'publish'";
            $pageposts = $wpdb->get_results($querystr, OBJECT);


            if ($pageposts) {
                global $post;

                foreach ($pageposts as $post):
                    setup_postdata($post);

                    if( $is_mobile && get_field("affiliate_link_mobile" , $post->ID) ) {
                        $siteurl = get_field("affiliate_link_mobile" , $post->ID);
                    } else {
                        $siteurl = get_field("affiliate_link",$post->ID);
                    }



                    if ( $siteurl ) {
                        header("X-Robots-Tag: noindex, nofollow", true);
                        wp_redirect($siteurl, 301);
                        exit;
                    }

                    break;
                endforeach;
            }

        }

    }
    add_action('init', 'gamblingtheme_redirect');
}
/**********************************************************************/


/**
 * Actions
 */
if( ! function_exists( 'poka_before_content' ) ){
    function poka_before_content( ) {
    ?>
        <?php if( ! get_field('hide_breadcrumbs','options') ): ?>
        <div class="fullwidth text-area breadcrumbs-wrapper">
            <div class="container">
                <?php poka_breadcrumbs(); ?>
            </div>
            <!-- /.container -->
        </div>
        <!-- /.fullwidth -->
        <?php endif; ?>

        <?php if( get_field('banner_fullwidth_top','options') && ((get_field('hide_banner_top_override') != true && is_page()) || (get_field('hide_banner_top_posts','options') != true && is_singular( 'post' )) || (get_field('hide_banner_top_reviews','options') != true && is_singular( 'affiliates' )) || (get_field('hide_banner_top_cat','options') != true && is_category()) || (get_field('hide_banner_top_tax','options') != true && is_tax( 'lists' ))) ): ?>
            <div class="banner-wrapper banner-wrapper--top">
                <div class="container">
                    <?php
                        $fielddata = get_field('banner_fullwidth_top','options');
                        echo apply_filters('the_content', $fielddata);
                    ?>
                </div>
                <!-- /.container -->
            </div>
            <!-- /.banner-wrapper -->
        <?php endif; ?>

    <?php
    }
    add_action( 'poka_before_main', 'poka_before_content', 5, 0 );
}

if( ! function_exists( 'poka_fullwidth_content' ) ){
    function poka_fullwidth_content( ) {
    ?>
        <?php
        if( have_rows('full_width_sections') && !is_search() ):
            $counter = 1;
            while ( have_rows('full_width_sections') ) { the_row();
                $options = "";
                if( get_sub_field('padding_topbottom') ){
                    $options .= 'padding:'.get_sub_field('padding_topbottom').'px 0; ';
                }
                if( get_sub_field('margin_top') ){
                    $options .= 'margin-top:'.get_sub_field('margin_top').'px; ';
                }
                if( get_sub_field('margin_bottom') ){
                    $options .= 'margin-bottom:'.get_sub_field('margin_bottom').'px; ';
                }
                if( get_sub_field('background_color') ){
                    $options .= 'background-color:'.get_sub_field('background_color').'; ';
                }
                if( get_sub_field('background_image') ){
                    $options .= 'background-image:url('.get_sub_field('background_image').'); ';
                }
                if( get_sub_field('background_position') ){
                    $options .= 'background-position:'.get_sub_field('background_position').'; ';
                }
                if( get_sub_field('background_size') ){
                    $options .= 'background-size:'.get_sub_field('background_size').'; ';
                }
                if( get_sub_field('background_repeat') ){
                    $options .= 'background-repeat:'.get_sub_field('background_repeat').'; ';
                }
                if( get_sub_field('text_color') ){
                    $options .= 'color:'.get_sub_field('text_color').'; ';
                }
            ?>
                <div class="section<?php echo ' section--' . $counter; if($counter == 1) echo ' section--first'; ?>" style="<?php echo $options; ?>">
                    <div class="container">
                        <div class="text-area" <?php if($counter == 1) echo 'style="background-color:'.get_sub_field('background_color').'"'; ?>>
                            <?php //Why? no other way for proper formatting... ?>
                            <?php echo apply_filters('the_content', get_sub_field('section_content', false, false)); ?>
                        </div>
                        <!-- /.text-area -->
                    </div>
                    <!-- /.container -->
                </div>
                <!-- /.section -->
            <?php
                $counter++;
            }

        endif; ?>
    <?php
    }
    add_action( 'poka_before_main', 'poka_fullwidth_content', 10, 0 );
}

if( ! function_exists( 'poka_banner_footer' ) ){
    function poka_banner_footer( ) {
        if( get_field('banner_fullwidth_bottom','options') && ((get_field('hide_banner_bottom_override') != true && is_page()) || (get_field('hide_banner_bottom_posts','options') != true && is_singular( 'post' )) || (get_field('hide_banner_bottom_reviews','options') != true && is_singular( 'affiliates' )) || (get_field('hide_banner_bottom_cat','options') != true && is_category()) || (get_field('hide_banner_bottom_tax','options') != true && is_tax( 'lists' ))) ):
    ?>
        <div class="banner-wrapper banner-wrapper--bottom">
            <div class="container">
                <?php
                    $fielddata = get_field('banner_fullwidth_bottom','options');
                    echo apply_filters('the_content', $fielddata);
                ?>
            </div>
            <!-- /.container -->
        </div>
        <!-- /.banner-wrapper -->
    <?php
        endif;
    }
    add_action( 'poka_after_main', 'poka_banner_footer', 4, 0 );
}

if( ! function_exists( 'poka_social_share' ) ){
    function poka_social_share() {
        global $post;
        $permalink = get_permalink($post->ID);
        $title = get_the_title();
    ?>
        <ul class="social">
            <li><span><?php _e( 'Share:', 'poka' ); ?></span></li>
            <li><a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" data-width="520" data-height="350" alt="Share on Facebook" rel="nofollow"><i class="icon-poka icon-poka-facebook-simple"></i></a></li>
            <li><a href="http://twitter.com/share?text='<?php echo $title; ?>'&amp;url=<?php echo $permalink; ?>" data-width="520" data-height="350" alt="Share on Twitter" rel="nofollow"><i class="icon-poka icon-poka-twitter-simple"></i></a></li>
            <li><a href="mailto:?subject=<?php _e( 'I wanted you to see this site', 'poka' ); ?>&amp;body=<?php _e( 'Check out this site:', 'poka' ); ?> <?php echo $permalink; ?>." data-width="520" data-height="350" class="email-link" alt="Share by email" rel="nofollow"><i class="icon-poka icon-poka-envelope"></i></a></li>
        </ul>
        <?php
    }
}

/**
 * Echo social links
 */
if( ! function_exists( 'poka_social_links' ) ){
    function poka_social_links() {
        ?>
        <ul class="top-bar-socials">
            <?php if(get_field('youtube_link','options')): ?><li><a href="<?php the_field('youtube_link','options'); ?>" target="_blank" rel="nofollow"><i class="icon-poka icon-poka-youtube"></i></a></li><?php endif; ?>
            <?php if(get_field('facebook_link','options')): ?><li><a href="<?php the_field('facebook_link','options'); ?>" target="_blank" rel="nofollow"><i class="icon-poka icon-poka-facebook"></i></a></li><?php endif; ?>
            <?php if(get_field('twitter_link','options')): ?><li><a href="<?php the_field('twitter_link','options'); ?>" target="_blank" rel="nofollow"><i class="icon-poka icon-poka-twitter"></i></a></li><?php endif; ?>
            <?php if(get_field('instagram_link','options')): ?><li><a href="<?php the_field('instagram_link','options'); ?>" target="_blank" rel="nofollow"><i class="icon-poka icon-poka-instagram"></i></a></li><?php endif; ?>
        </ul>
        <!-- /.top-bar-socials -->
        <?php
    }
}
/**********************************************************************/


/**
 * Admin notices
 */
if( ! function_exists( 'poka_after_theme_activated' ) ){
    function poka_after_theme_activated() {
        function poka_admin_notice(){
            global $pagenow;

            echo '<div class="notice updated poka-plugins-notice is-dismissible"><p>You have successfully activated <strong>Poka Theme v3</strong>!</p><p>We recommend the following plugins:</p><p>SEO plugin: <a href="' . esc_url( home_url() ) . '/wp-admin/plugin-install.php?tab=search&type=term&s=Yoast+SEO">Yoast SEO</a></p><p>Forms plugin: <a href="' . esc_url( home_url() ) . '/wp-admin/plugin-install.php?tab=search&type=term&s=Contact+form+7">Contact Form 7 </a></p></div>';
        }
        add_action('admin_notices', 'poka_admin_notice');

        //recompile our SCSS
        poka_recompile_scss_files(true);
    }
    add_action('after_switch_theme', 'poka_after_theme_activated');
}
/**********************************************************************/


/**
 * Get Embeds from content
 */
if( ! function_exists( 'poka_get_embeds' ) ){
    function poka_get_embeds($content) {
        $content = do_shortcode( apply_filters( 'the_content', $content ) );
        $embeds = get_media_embedded_in_content( $content );
        return $embeds;
    }
}
/**********************************************************************/


/**
 * Get Redirect path
 */
if( ! function_exists( 'poka_redirect_folder' ) ){
    function poka_redirect_folder() {
        if( ! get_field('affiliate_redirect_link_folder','options') ) {
            $folder = "go";
        } else {
            $folder = get_field('affiliate_redirect_link_folder','options');
        }
        return $folder;
    }
}
/**********************************************************************/

/**
 * set Onclick event if set for affiliate buttons
 */
if( ! function_exists( 'poka_link_onclick' ) ){
    function poka_link_onclick( $linkID , $link_type = 'desktop' ) {

        $output = apply_filters('poka_add_attr_aff_link', "");
        if( get_field('affiliate_onclick_mobile',$linkID) && $link_type === 'mobile' ) {
            $output .= "onclick='".get_field("affiliate_onclick_mobile",$linkID)."'";
        }
        else if( get_field('affiliate_onclick',$linkID) ) {
            $output .= "onclick='".get_field("affiliate_onclick",$linkID)."'";
        }

        return $output;
    }
}
/**********************************************************************/

/**
 * Convert HEX to RGBa
 */
if( ! function_exists( 'hex2rgba' ) ){
    function hex2rgba($color, $opacity = false) {

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
              return $default;

        //Sanitize $color if "#" is provided
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }

            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                    return $default;
            }

            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);

            //Check if opacity is set(rgba or rgb)
            if($opacity){
                if(abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
                $output = 'rgb('.implode(",",$rgb).')';
            }

            //Return rgb(a) color string
            return $output;
    }
}
/**********************************************************************/

/**
 * Comments
 */
function poka_custom_phrase( $array ){
	$array['must_log_in'] = sprintf( __( '<p class="must-log-in">You must <strong>login</strong> in order to comment or rate a review.</p>','poka' ) );
    if( get_field('allow_unregistered_user_rating_in_reviews' , 'options') ) {
        $array['must_log_in'] = sprintf( __( '<p class="must-log-in">You must <strong>login</strong> in order to comment a review.</p>','poka' ) );
    }
    return $array;
}
add_filter( 'comment_form_defaults', 'poka_custom_phrase' );
/**********************************************************************/

/**
 * Login / register forms
 */
if( ! function_exists( 'poka_login_register' ) ){
    function poka_login_register() {
        if ( !is_user_logged_in() ) {
            if( get_field('allow_users_to_comment_in_reviews' , 'options') || !get_field('allow_unregistered_user_rating_in_reviews' , 'options')) {
            ?>
            <div class="login-register">
                <div class="row">
                    <div class="col-sm-6">
                        <h4><?php esc_html_e('Login','poka'); ?></h4>
                        <?php
                            $args = array(
                                'redirect' => get_permalink()
                            );
                            wp_login_form( $args );
                        ?>
                    </div>
                    <!-- /.col6 col-sm-12 -->
                    <div class="col-sm-6">
                        <h4><?php esc_html_e('Register','poka'); ?></h4>
                        <?php echo do_shortcode('[poka_registration]'); ?>
                    </div>
                    <!-- /.col6 col-sm-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.login-register -->
            <?php
            }
        }
    }
}
/**********************************************************************/

/**
 * Handle all additional body classes
 */
if( ! function_exists( 'poka_custom_class' ) ){
    function poka_custom_class( $classes ) {

        // Add custom class
        if( get_field('header_style','options') ){
            $classes[] = 'body-header-'.get_field('header_style','options');
        } else {
            $classes[] = 'body-header-style1';
        }

        if( !get_field('hide_breadcrumbs','options') ){
            $classes[] = 'body-show-breadcrumbs';
        }

        if( is_singular( 'affiliates' ) ){
            if( get_field('review_style_override') ){
                if( get_field('review_style_override') == 'style1' ){
                    $classes[] = 'body-single-affiliates-s1';
                } elseif( get_field('review_style_override') == 'style2' ){
                    $classes[] = 'body-single-affiliates-s2';
                } else {
                    $classes[] = 'body-single-affiliates-s3';
                }
            } else {
                if( get_field('review_style','options') == 'style1' ){
                    $classes[] = 'body-single-affiliates-s1';
                } elseif( get_field('review_style','options') == 'style2' ){
                    $classes[] = 'body-single-affiliates-s2';
                } else {
                    $classes[] = 'body-single-affiliates-s3';
                }
            }
        }

        $full_width_sections = get_field('full_width_sections');

        if( $full_width_sections ){
            $classes[] = 'body-fullscreen-sections';
        }

        if( $full_width_sections ){
            $full_width_sections_0 = $full_width_sections[0];
            if( $full_width_sections_0['background_color'] || $full_width_sections_0['background_image'] ){
                $classes[] = 'body-fullscreen-first-section-colored';
            }

        }

        if( get_field( 'sidebar_to_the_left','options' ) ) {
            $classes[] = "body-sidebar-left";
        }


        return $classes;
    }
    add_action( 'body_class', 'poka_custom_class');
}
/**********************************************************************/

/**
 * Dynamic styling
 */
use ScssPhp\ScssPhp\Compiler;
if( ! function_exists( 'poka_recompile_scss_files' ) ){
    function poka_recompile_scss_files($force_exec = false) {

        if( function_exists('get_current_screen') ) {
            $screen = get_current_screen();
        } else {
            $screen = null;
        }

        if( ($screen == null && $force_exec === true) || strpos($screen->id, "acf-options-visual-settings") == true ){

            $scss = new Compiler();
            $scss->setImportPaths(get_template_directory().'/scss/');
            $scss->setFormatter('ScssPhp\ScssPhp\Formatter\Compressed');

            $newVars = [];
            if( get_field('main_font_color','options') ){
                $newVars['main-font-color'] = get_field('main_font_color','options');
            }
            if( get_field('font_family','options') ){
                $font_family_obj = get_field_object('font_family','options');
                if( get_field('font_family','options') != "default" ){
                    $newVars['font-family-primary'] = '"'.$font_family_obj['choices'][ get_field('font_family','options') ].'"';
                } else {
                    $newVars['font-family-primary'] = 'inherit';
                }
            }
            if( get_field('font_family_secondary','options') ){
                if( get_field('font_family_secondary','options') == "same" ){
                    $newVars['font-family-secondary'] = 'inherit';
                } else {
                    $font_family_obj = get_field_object('font_family_secondary','options');
                    $newVars['font-family-secondary'] = '"'.$font_family_obj['choices'][ get_field('font_family_secondary','options') ].'"';
                }
            }
            if( get_field('site_background_color','options') ){
                $newVars['body-background-color'] = get_field('site_background_color','options');
            }
            if( get_field('elements_radius','options') != "" ){
                $newVars['radius'] = get_field('elements_radius','options').'px';
            }
            if( get_field('color_red','options') ){
                $newVars['red'] = get_field('color_red','options');
            }
            if( get_field('color_blue','options') ){
                $newVars['blue'] = get_field('color_blue','options');
            }
            if( get_field('color_green','options') ){
                $newVars['green'] = get_field('color_green','options');
            }
            if( get_field('color_black','options') ){
                $newVars['black'] = get_field('color_black','options');
            }
            if( get_field('color_black_medium','options') ){
                $newVars['black-medium'] = get_field('color_black_medium','options');
            }
            if( get_field('color_black_light','options') ){
                $newVars['black-light'] = get_field('color_black_light','options');
            }
            if( get_field('color_grey','options') ){
                $newVars['grey'] = get_field('color_grey','options');
            }
            if( get_field('logo_width','options') ){
                $newVars['logo_width'] = get_field('logo_width','options').'px';
            }
            if( get_field('logo_width_mobile','options') ){
                $newVars['logo_width_mobile'] = get_field('logo_width_mobile','options').'px';
            }

            if( get_field('base_font_size' , 'options') ) {
                $newVars['font-size-root'] = get_field('base_font_size' , 'options').'px';
            }

            $newVars = apply_filters('poka_set_default_acf_values', $newVars);

            $scss->setVariables($newVars);
            $css = $scss->compile('@import "styles.scss";');
            file_put_contents(get_template_directory().'/css/styles.css',$css);
        }
    }
    add_action('acf/save_post', 'poka_recompile_scss_files', 20);
}

/**********************************************************************/

/**
 * Enable shortcodes for cat and tax descriptions
 */
add_filter( 'term_description', 'do_shortcode' );
add_filter( 'category_description', 'do_shortcode' );
/**********************************************************************/


/**
 * Ajax Search with autocomplete
 */
if( ! function_exists( 'poka_autocomplete_suggestions' ) ){
    function poka_autocomplete_suggestions(){
        // Check for nonce security
        $nonce = $_POST['nonce'];

        if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die ( 'Busted!');

        $the_featured_slot = new WP_Query( array(
            'post_type'  			=>  'affiliates',
            'posts_per_page' 	=> -1
        ));

        $suggestions=array();

        if ( $the_featured_slot->have_posts() ){
                while ( $the_featured_slot->have_posts() ) {
                    $the_featured_slot->the_post();

                    $suggestion = array();

                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'aff-thumb' );
                    $btn_aff = poka_affiliate_url_return( get_field('affiliate_link', get_the_ID())->ID );

                    $suggestion['label'] = esc_html(get_the_title());
                    $suggestion['link'] = get_permalink();
                    $suggestion['image'] = $thumb[0];
                    $suggestion['promo_title'] = get_field('bonus_promo_title',get_the_ID());
                    $suggestion['afflink'] = $btn_aff;
                    $suggestion['playnowtext'] = poka_get_translation('Play now');
                    $suggestion['reviewtext'] = poka_get_translation('Review');

                    $suggestions[]= $suggestion;

                }
        }

         // JSON encode and echo
        $response = $_GET["callback"] . "(" . json_encode($suggestions) . ")";
        echo $response;

        // Don't forget to exit!
        exit;
    }
    add_action( 'wp_ajax_poka_autocompletesearch', 'poka_autocomplete_suggestions' );
    add_action( 'wp_ajax_nopriv_poka_autocompletesearch', 'poka_autocomplete_suggestions' );
}
/**********************************************************************/

/**
 * Ajax News Load More
 */
if( ! function_exists( 'poka_ajax_load_more_news' ) ) {
    function poka_ajax_load_more_news(){
        $cat            = $_POST['cat'];
        $offset         = $_POST['offset'];
        $descr_excerpt  = $_POST['descr_excerpt'];
        $descr_length   = $_POST['descr_length'];

        $query_string = array(
            'cat' => $cat,
            'posts_per_page' => 6,
            'offset'    => $offset
        );

        $output = '';

        $news_query = new WP_query();
        $news_query->query( $query_string );

        if ($news_query->have_posts()) : while ($news_query->have_posts()) : $news_query->the_post();

        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'post-sm' );
        $img = "";

        $embeds = poka_get_embeds(get_the_content());

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

        if( $news_query->found_posts > ((int)$offset + 6) ) {
            $new_offset = (int)$offset + 6;
        } else {
            $new_offset = '';
        }

        $response               = array();
        $response['html']       = $output;
        $response['cat']        = $cat;
        $response['new_offset'] = $new_offset;


        echo json_encode($response);

        exit;
    }
    add_action( 'wp_ajax_poka_ajax_load_more_news', 'poka_ajax_load_more_news' );
    add_action( 'wp_ajax_nopriv_poka_ajax_load_more_news', 'poka_ajax_load_more_news' );
}

/**
 * Output translations fixed or not
 */
if( ! function_exists( 'poka_get_translation' ) ){
    function poka_get_translation($text){

        switch ($text) {
            case 'Play now':
                if( get_field('play_now_button_text','options') ){
                    $output = get_field('play_now_button_text','options');
                } else {
                    $output = esc_html__('Play now','poka');
                }
                break;
            case 'Play!':
                if( get_field('play_button_text','options') ){
                    $output = get_field('play_button_text','options');
                } else {
                    $output = esc_html__('Play!','poka');
                }
                break;
            case 'Review':
                if( get_field('review_button_text','options') ){
                    $output = get_field('review_button_text','options');
                } else {
                    $output = esc_html__('Review','poka');
                }
                break;
            default:
                $output = "";
        }

        return $output;
    }
}
/**********************************************************************/


/**
 * This is for WP < 4.7 compatibility
 */
if( !function_exists('get_theme_file_uri') ){
    function get_theme_file_uri( $file = '' ) {
      $file = ltrim( $file, '/' );

      if ( empty( $file ) ) {
          $url = get_stylesheet_directory_uri();
      } elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
          $url = get_stylesheet_directory_uri() . '/' . $file;
      } else {
          $url = get_template_directory_uri() . '/' . $file;
      }

      return apply_filters( 'theme_file_uri', $url, $file );
    }
}
/**********************************************************************/


/**
 * Add JSON-LD structured data to the footer
 */
if( ! function_exists( 'poka_add_structured_data' ) ){
    function poka_add_structured_data() {

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

        ?>
            <script type="application/ld+json">
            {
            "@context": "http://schema.org/",
            "@type": "Review",
            "itemReviewed": {
                "@type": "Organization",
                "name": "<?php the_title(); ?>"
            },
            "author": {
                "@type": "Organization",
                "name": "<?php echo get_bloginfo( 'name' ); ?>",
                "url": "<?php echo home_url(); ?>"
            },
            "reviewRating": {
                "@type": "Rating",
                "ratingValue": "<?php echo $rating; ?>",
                "bestRating": "5",
                "worstRating": "1"
            },
            "datePublished" : "<?php the_time('c'); ?>",
            "reviewBody" : "<?php the_field('affiliate_small_info'); ?>"
            }
            </script>
        <?php
        }

    }
}
add_action('wp_footer', 'poka_add_structured_data');
/**********************************************************************/


/**
 * Function that returns the affiliate URL
 */
if( ! function_exists( 'poka_affiliate_url_return' ) ){
    function poka_affiliate_url_return( $aff_link_id = null , $link_type = "desktop" ) {

        $folder = poka_redirect_folder();

        if( $aff_link_id !== null ){
            $aff_key = get_field( 'affiliate_key', $aff_link_id );
            if( $link_type === "mobile" ){
                $mobile_param = '?$mobile';
            } else {
                $mobile_param = '';
            }
        } else {
            return false;
        }

        return get_site_url() . '/' . $folder . '/' . $aff_key.$mobile_param;

    }
}
/**********************************************************************/

/**
 * Function echoing terms and conditions text
 */
if( ! function_exists( 'poka_terms_text_return' ) ){
    function poka_terms_text_return( $review_id, $type = 'normal' ) {

        $terms_text = "";

        if( get_field( 'terms_conditions_functionality', 'options' ) && get_field( 'terms_conditions_text', $review_id ) ){

            if( $type === "amp" ){

                $terms_text .= '<div class="terms-wrapper">'. get_field( 'terms_conditions_text', $review_id ) .'</div>';

            } else {

                $terms_text .= '<div class="terms-wrapper">';

                if( get_field('terms_conditions_tooltip','options') ){

                    $terms_text .= '<div class="tooltip-el">';
                    $terms_text .= get_field( 'terms_text_under_button', 'options' );
                    $terms_text .= '</div>';
                    $terms_text .= '<div class="tooltip-text">'. get_field( 'terms_conditions_text', $review_id ) .'</div>';

                } else {

                    $terms_text .= '<div class="tooltip-el tooltip-disabled">';
                    $terms_text .= get_field( 'terms_conditions_text', $review_id );
                    $terms_text .= '</div>';

                }

                $terms_text .= '</div>';

            }

        }



        return $terms_text;

    }
}
/**********************************************************************/


/**
 * Check if Block Editor is active.
 * Must only be used after plugins_loaded action is fired.
 *
 * @return bool
 */
function gutenberg_is_active() {
    // Gutenberg plugin is installed and activated.
    $gutenberg = ! ( false === has_filter( 'replace_editor', 'gutenberg_init' ) );

    // Block editor since 5.0.
    $block_editor = version_compare( $GLOBALS['wp_version'], '5.0-beta', '>' );

    if ( ! $gutenberg && ! $block_editor ) {
        return false;
    }

    if ( is_classic_editor_plugin_active() ) {
        $editor_option       = get_option( 'classic-editor-replace' );
        $block_editor_active = array( 'no-replace', 'block' );

        return in_array( $editor_option, $block_editor_active, true );
    }

    return true;
}

/**
 * Check if Classic Editor plugin is active.
 *
 * @return bool
 */
function is_classic_editor_plugin_active() {
    if ( ! function_exists( 'is_plugin_active' ) ) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
        return true;
    }

    return false;
}
/**********************************************************************/

/**
 * Check if page is built with elementor.
 *
 * @return bool
 */
function poka_is_elementor_page(){
    global $post;
    $is_elementor = 0;

    if( is_plugin_active( 'elementor/elementor.php' ) ) {
        $is_elementor = \Elementor\Plugin::$instance->db->is_built_with_elementor($post->ID);
    }
    return $is_elementor;
}
/**********************************************************************/
