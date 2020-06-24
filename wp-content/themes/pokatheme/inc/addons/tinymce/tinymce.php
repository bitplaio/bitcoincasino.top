<?php
// =============================================================================
// Ticnymce extra functionallity
// =============================================================================
function poka_add_my_tc_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page', 'games', 'affiliates' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "poka_add_tinymce_plugin");
        add_filter('mce_buttons', 'poka_register_my_tc_button');
    }
}
add_action('admin_head', 'poka_add_my_tc_button');

function poka_add_tinymce_plugin($plugin_array) {
    $static_version = apply_filters('poka_static_version', wp_get_theme(get_template())->get('Version'));
    if( function_exists( 'get_theme_file_path' ) ){
        $plugin_array['poka_tc_button'] = get_theme_file_uri('inc/addons/tinymce/js/shortocodes-button.js?ver='.$static_version);
    } else {
        $plugin_array['poka_tc_button'] = get_template_directory_uri() . '/inc/addons/tinymce/js/shortocodes-button.js?ver='.$static_version;
    }

    return $plugin_array;
}

function poka_register_my_tc_button($buttons) {
   array_push($buttons, "poka_tc_button");
   return $buttons;
}

function poka_tc_css() {
    $static_version = apply_filters('poka_static_version', wp_get_theme(get_template())->get('Version'));
    wp_enqueue_style('poka-tc', get_template_directory_uri() . '/inc/addons/tinymce/css/tinymce-custom-styles.css', '', $static_version);
}

add_action('admin_enqueue_scripts', 'poka_tc_css');
