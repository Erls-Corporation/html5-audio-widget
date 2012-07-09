<?php

/**
 * Create discography custom post type.
 */

add_action( 'init', 'pid_discography_init' );

function pid_discography_init()  {
  $labels = array(
	'name'               => __( 'Albums',                   'framework' ),
	'singular_name'      => __( 'Album',                    'framework' ),
	'add_new'            => __( 'Add Album',                'framework' ),
	'add_new_item'       => __( 'Add Album',                'framework' ),
	'edit_item'          => __( 'Edit Album',               'framework' ),
	'new_item'           => __( 'New Album',                'framework' ),
	'view_item'          => __( 'View Album',               'framework' ),
	'search_items'       => __( 'Search Albums',            'framework' ),
	'not_found'          => __( 'No Albums found',          'framework' ),
	'not_found_in_trash' => __( 'No Albums found in Trash', 'framework' ), 
	'parent_item_colon'  => __( '',                         'framework' ),
	'menu_name'          => __( 'Discography',              'framework' )
  );
  
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true, 
    'show_in_menu'       => true, 
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'album' ),
    'capability_type'    => 'post',
    'has_archive'        => 'discography', 
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'thumbnail', 'editor' ),
    'menu_position'      => 5
  );
  
  register_post_type( 'discography', $args );
  
}

/**
 * Changes the title placeholder text when you create a new album.
 */
add_filter( 'enter_title_here', 'pid_discography_change_default_title' );

function pid_discography_change_default_title( $title ){
	$screen = get_current_screen();
 
	if ( 'discography' == $screen->post_type ) {
		$title = __( 'Enter Album Title', 'framework' );
	}
 
	return $title;
}


/**
 * Add custom columns.
 */

add_filter( 'manage_edit-discography_columns', 'pid_discography_edit_columns' );
 
function pid_discography_edit_columns( $columns ){
	$columns = array(
		'cb'        => '<input type="checkbox" />',
		'artwork'   => __( '', 'framework' ),
		'title'     => __( 'Title', 'framework' ),
		'date'      => __( 'Date', 'framework' )
	);

	return $columns;
}