<?php


add_action( 'add_meta_boxes', 'c7s_metabox_init' );

function c7s_metabox_init() {
	// Register
	wp_register_script( 'metabox',        PID_URL . '/includes/metabox/MetaBox.js',		'jquery', '1.0',	true );
	wp_register_style(  'metabox',        PID_URL . '/includes/metabox/MetaBox.css' );
	
	// Enqueue
	wp_enqueue_script( 'metabox' );
	wp_enqueue_style( 'metabox' );
	wp_enqueue_style( 'metabox-custom' );
}

include_once PID_DIR . '/includes/metabox/MetaBox.php';


include_once PID_DIR . '/includes/metabox/MediaAccess.php';

/* Define a media access object */
$wpalchemy_media_access = new WPAlchemy_MediaAccess();

$album_info_mb = new WPAlchemy_MetaBox( array(
  'id'       => '_album_info_mb',
  'title'    => 'Album Info',
  'types'    => array( 'discography' ),
  'template' => PID_DIR . '/includes/metabox/metabox-album-info.php'
));