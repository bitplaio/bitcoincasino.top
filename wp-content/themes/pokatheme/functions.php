<?php
// =============================================================================
// Framework includes
// =============================================================================

// Define default functions/plugins folder
$functions_path = get_template_directory() . '/inc/';
$admin_path = get_template_directory() . '/inc/admin/';
$plugins_path = get_template_directory() . '/inc/addons/';

// Load Error Messages
require_once ($functions_path . 'messages.php');

// Load SCSS compiler.
require_once ($functions_path . 'scssphp/scss.inc.php');

// Load Seperate Functions
require_once ($functions_path . 'core.php'); // Load Core functions.
require_once ($functions_path . 'security.php'); // Load Security functions.

// Ratings addon
require_once ($plugins_path . 'ratings.php');

// Load Widgets
if( function_exists( 'get_theme_file_path' ) ){
    require_once get_theme_file_path( 'inc/addons/wg-affiliate-listing.php' );
} else {
    require_once ($plugins_path . 'wg-affiliate-listing.php');
}

// Load Shortcodes
require_once ($plugins_path . 'sc-table-list.php');
require_once ($plugins_path . 'sc-table-list-v2.php');
require_once ($plugins_path . 'sc-various.php');

// Load Custom Post Types
if( function_exists( 'get_theme_file_path' ) ){
    require_once get_theme_file_path( 'inc/custom-post-types.php' );
} else {
    require_once ($functions_path . 'custom-post-types.php');
}

// Load Breadcrumbs
require_once ($plugins_path . 'breadcrumbs.php');

// Load Metaboxes
if( function_exists( 'get_theme_file_path' ) ){
    require_once get_theme_file_path( 'inc/acf-metaboxes.php' );
} else {
    require_once ($functions_path . 'acf-metaboxes.php');
}

// TinyMCE extra buttons
require_once ($plugins_path . 'tinymce/tinymce.php');

// Custom registration form
if( function_exists( 'get_theme_file_path' ) ){
    require_once get_theme_file_path( 'inc/addons/sc-register-form.php' );
} else {
    require_once ($plugins_path . 'sc-register-form.php');
}

// Load AMP functions
require_once ($functions_path . 'amp/amp-functions.php');

// Load Demo functions
if( function_exists( 'get_theme_file_path' ) ){
    require_once get_theme_file_path( 'inc/import-content.php' );
} else {
    require_once ($functions_path . 'import-content.php');
}

