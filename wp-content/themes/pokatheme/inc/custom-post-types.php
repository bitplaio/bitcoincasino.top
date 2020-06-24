<?php
// =============================================================================
// Custom Post Types
// =============================================================================


/**
 * Custom post type(Affiliate links)
 */
function poka_taxonomies(){

    $labels = array(
        'name' => _x('Affiliate links', 'post type general name', 'poka'),
        'singular_name' => _x('link', 'post type singular name', 'poka'),
        'add_new' => _x('Add new link', 'member', 'poka'),
        'add_new_item' => __('Add new link', 'poka'),
        'edit_item' => __('Edit', 'poka'),
        'new_item' => __('New link', 'poka'),
        'view_item' => __('View', 'poka'),
        'search_items' => __('Search link', 'poka'),
        'not_found' =>  __('No links found!', 'poka'),
        'not_found_in_trash' => __('No links in the trash!', 'poka'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title'),
        'exclude_from_search' => true,
        'menu_icon' => 'dashicons-admin-links'
    );
    register_post_type('affiliate_links',$args);

    //if user slug is available
    if( get_field('review_post_type_slug','options') ){
        //first remove whitespaces
        $review_slug = preg_replace('/\s+/', '', get_field('review_post_type_slug','options'));
    } else {
        $review_slug = 'review';
    }

    // Registers the Affiliates post type and taxonomy
    register_post_type( 'affiliates',
        array(
            'labels' => array(
                'name' => __( 'Reviews', 'poka' ),
                'singular_name' => __( 'Affiliate', 'poka' ),
                'add_new' => __( 'Add New Review', 'poka' ),
                'add_new_item' => __( 'Add New Review', 'poka' ),
                'edit_item' => __( 'Edit Review', 'poka' ),
                'new_item' => __( 'Add New Review', 'poka' ),
                'view_item' => __( 'View Review', 'poka' ),
                'search_items' => __( 'Search Review', 'poka' ),
                'not_found' => __( 'No reviews found', 'poka' ),
                'not_found_in_trash' => __( 'No reviews found in trash', 'poka' )
            ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'comments', 'thumbnail' ),
            'capability_type' => 'post',
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array("slug" => $review_slug, "with_front" => true), // Permalinks format
            'menu_position' => 5,
            'menu_icon' => 'dashicons-admin-site',
            'has_archive' => true
        )
    );

    // Add new Taxonomy for the Affiliates and make it hierarchical (like categories)
    $labels = array(
        'name' => _x( 'Categories', 'taxonomy general name', 'poka' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name', 'poka' ),
        'search_items' =>  __( 'Search Categories', 'poka' ),
        'all_items' => __( 'All Categories', 'poka' ),
        'parent_item' => __( 'Parent Category', 'poka' ),
        'parent_item_colon' => __( 'Parent Category:', 'poka' ),
        'edit_item' => __( 'Edit Category', 'poka' ),
        'update_item' => __( 'Update Category', 'poka' ),
        'add_new_item' => __( 'Add New Category', 'poka' ),
        'new_item_name' => __( 'New Category Name', 'poka' ),
    );
    register_taxonomy('lists',array('affiliates'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array( 'slug' => 'list' )
        )
    );

    //Custom post type(Games)
    // Deactivate for now, we'll see in the future
    /*$labels = array(
        'name' => _x('Games', 'post type general name'),
        'singular_name' => _x('Game', 'post type singular name'),
        'add_new' => _x('Add new game', 'member'),
        'add_new_item' => __('Add new game'),
        'edit_item' => __('Edit'),
        'new_item' => __('New game'),
        'view_item' => __('View'),
        'search_items' => __('Search game'),
        'not_found' =>  __('No games found!'),
        'not_found_in_trash' => __('No games in the trash!'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug'=>'games'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail','editor','custom-fields','excerpt'),
        'menu_icon' => 'dashicons-universal-access'
    );
    register_post_type('games',$args);

    $labels = array(
        'name' => _x( 'Category', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search category' ),
        'all_items' => __( 'All categories' ),
        'parent_item' => __( 'Parent category' ),
        'parent_item_colon' => __( 'Parent category' ),
        'edit_item' => __( 'Edit category' ),
        'update_item' => __( 'Update category' ),
        'add_new_item' => __( 'Add new category' ),
        'new_item_name' => __( 'Category name' ),
    );

    register_taxonomy( 'games_tax', array( 'games' ), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'type' ),
    ));*/

    //Custom post type(Slideshow)
    $labels = array(
        'name' => _x('Sliders', 'post type general name', 'poka'),
        'singular_name' => _x('Slider', 'post type singular name', 'poka'),
        'add_new' => _x('Add new slider', 'member', 'poka'),
        'add_new_item' => __('Add new slider', 'poka'),
        'edit_item' => __('Edit', 'poka'),
        'new_item' => __('New slider', 'poka'),
        'view_item' => __('View', 'poka'),
        'search_items' => __('Search sliders', 'poka'),
        'not_found' =>  __('No sliders found!', 'poka'),
        'not_found_in_trash' => __('No sliders in the trash!', 'poka'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug'=>'slider'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title'),
        'exclude_from_search' => true,
        'menu_icon' => 'dashicons-admin-customizer'
    );
    register_post_type('slider',$args);
}

add_action( 'init', 'poka_taxonomies', 0 );
/**********************************************************************/


/**
 * Affiliate links custom column
 */
add_filter( 'manage_edit-affiliate_links_columns', 'poka_edit_affiliate_links_columns' ) ;

function poka_edit_affiliate_links_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Affiliate title', 'poka' ),
		'aff_link' => __( 'Affiliate redirect link', 'poka' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_affiliate_links_posts_custom_column', 'poka_manage_affiliate_links_columns', 10, 2 );

function poka_manage_affiliate_links_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'aff_link' column. */
		case 'aff_link' :

            $link = poka_affiliate_url_return( $post_id );

			/* If empty, output a default message. */
			if ( !get_field('affiliate_key',$post_id) )
				echo __( 'Not set...' );

			else
				echo $link;

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
/**********************************************************************/
