<?php
/**
 * This loop deteremines which album and tracks should be shown in the audio player (jPlayer).
 * 
 * The albums are posts of the custom post type Discography. The album and track info
 * is set via custom metaboxes using WPAlchemey metabox class. 
 *
 * First we set the query argument for the loop. To do this, we get the desired album ID
 * set in the Theme Options. Then get that album info and track count. Loop throught the
 * available tracks and create and entry for the jPlayer javascript playlist.
 *
 * @package    WordPress
 * @subpackage Groupie
 * @since      1.0
 *
 */
 

/**
 * Creat New Query
 * 
 */
global $album_info_mb; // get album metabox global variable
$album_info_mb->the_meta(); 

if ( has_post_thumbnail() ) {
	$artwork_image_source = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
	$artwork_image_source = $artwork_image_source[0];
};
	
$artist_name = $album_info_mb->get_the_value( 'artist_name' );
$album_name = $album_info_mb->get_the_value( 'album_name' );

$track_count = 0;
$track_total = 0
//$track_total = count( $album_info_mb->get_the_value( 'tracks' ) );  ?>


<?php
/*
 * Count tracks. Tracks must have title and file source
 * Use this dertermine if a comma should be added after the js entry bracket
 *
 */
while ( $album_info_mb->have_fields_and_multi( 'tracks' ) ) : 
	if ( $album_info_mb->get_the_value( 'track_name' ) && $album_info_mb->get_the_value( 'track_file' ) ) : // Track must have title and file 
		$track_total++;
	endif;
endwhile; // end tracks check loop  ?>


<?php 
/*
 * Loop through tracks and create entry to be used in JS. Tracks must have title and file source
 *
 */
while ( $album_info_mb->have_fields_and_multi( 'tracks' ) ) : ?>
	
	<?php  if ( $album_info_mb->get_the_value( 'track_name' ) && $album_info_mb->get_the_value( 'track_file' ) ) : // Track must have title and file ?>
		
		<?php $track_count++; ?>
		
		{
			artwork: "<?php echo esc_url( $artwork_image_source ); ?>",
			name: "<?php $album_info_mb->the_value( 'track_name' ) ?>",
			artist: "<?php echo $artist_name ?>",
			album: "<?php apply_filters( 'limit_string', addslashes( $album_name ), 30, true, false  ); ?>",
			mp3:"<?php esc_url( $album_info_mb->the_value( 'track_file' ) ) ?>",
			itunes: "<?php esc_url ( $album_info_mb->the_value ( 'itunes' ) ) ?>",
			cdbaby: "<?php esc_url ( $album_info_mb->the_value( 'cdbaby' ) ) ?>"
		}<?php if ( $track_count < $track_total ) echo ','; // Add comma after bracket for all posts except the last one ?>
	
	<?php endif; // end track title and source check ?>
	
<?php endwhile; // end have_fields_and_multi( 'tracks' ) ?>


