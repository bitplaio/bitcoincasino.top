<?php
// =============================================================================
// Demo Import with plugin 'One Click Demo Import'
// =============================================================================
function poka_ocdi_import_files() {
    return array(
    array(
        'import_file_name'           => 'PokaTheme Demo Import',
        'import_file_url'            => 'https://demos.pokatheme.com/demo-content/pokatheme/demo-content.xml',
        'import_widget_file_url'     => 'https://demos.pokatheme.com/demo-content/pokatheme/demo-widgets.wie',
        'import_preview_image_url'   => 'https://demos.pokatheme.com/demo-content/pokatheme/demo.png',
        'preview_url'                => 'https://demos.pokatheme.com/pokatheme/',
    )
    );
}
add_filter( 'pt-ocdi/import_files', 'poka_ocdi_import_files' );
/**********************************************************************/


/**
 * First remove the current widgets
 * Hooks for One Click Demo Import and Widgets Importer/Exporter
 *
 * @return void
 */
function poka_ocdi_before_widgets_import() {

	update_option( 'sidebars_widgets', array() );

}
add_action( 'pt-ocdi/before_widgets_import', 'poka_ocdi_before_widgets_import' );
add_action( 'wie_before_import', 'poka_ocdi_before_widgets_import' );
/**********************************************************************/


/**
 * After demo content import
 */
function poka_import_end() {
    $page_check = get_page_by_title('Homepage');

    //if page is imported
    if( $page_check ){
        // set this page as homepage
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_check->ID);
    }

    //Set permalink structure to post name (Mainly for affiliate redirects)
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure( '/%postname%/' );
    $wp_rewrite->flush_rules();

    poka_recompile_scss_files(true);

    //Make Main Menu our Primary menu
    $menu = wp_get_nav_menu_object("Main menu");
    if( $menu ){
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu->term_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
};
add_action( 'import_end', 'poka_import_end', 10, 0 );

