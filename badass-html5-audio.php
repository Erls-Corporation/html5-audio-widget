<?php 
/*
Plugin Name: HTML5 Audio Widget
Description: Badass HTML5 Audio player with Flash fallback, widgetized.
Version: 0.1
Author: pdxids, andrewsfreeman
Author URI: http://wordpressplugins.pdxids.com
License: GPL2
*/

// Setup our constants
define( 'PID_DIR',       dirname(__FILE__) );
define( 'PID_URL',       plugins_url('',__FILE__) );

//include the custom post type and meta-boxes
include_once PID_DIR . '/includes/discography.php'; 
include_once PID_DIR . '/includes/theme-metabox.php';

//post thumbnails, jquery and styles
add_theme_support( 'post-thumbnails' );
add_action ('wp_enqueue_scripts','pid_jquery');

function pid_jquery(){
 	wp_enqueue_script('jquery');
 	wp_enqueue_script('jplayer', PID_URL . '/js/jplayer/js/jquery.jplayer.min.js' , array('jquery') );
 	wp_enqueue_script('playlist-scripts', PID_URL . '/js/script.js' , array('jquery') );
 	wp_register_style('html5-audio', PID_URL . '/html5.css');
 	wp_enqueue_style('html5-audio');
}
 
/**
 * This function actually displays the audio player. Used in the widget class follows.
 */
  
function pid_display_player( $album = '' ) {

$audio_player_album = get_the_title( $album );
$audio_player_album_id = $album;

$artwork_image_source = PID_URL . '/images/default-album-artwork.png';
							

?>
	<div class="pid-media-player">
	  	
	  	<div class="artwork"><img src="<?php echo $artwork_image_source; ?>" alt="album artwork" /></div>
	  	
	  	<div id="jquery_jplayer_<?php echo $audio_player_album ?>" class="jp-jplayer"></div>
	  	
	  	<div class="jp-audio">
	  		
	  		<div class="jp-type-playlist">
	  			
	  			<div id="jp_interface_<?php echo $audio_player_album ?>" class="jp-interface">
	  				<div class="jp-controls-wrap">
	  					<ul class="jp-controls">
	  						<li><a href="#" class="jp-play" tabindex="1">Play</a></li>
	  						<li><a href="#" class="jp-pause" tabindex="1">Pause</a></li>
	  						<li><a href="#" class="jp-previous" tabindex="1">Previous</a></li>
	  						<li><a href="#" class="jp-next" tabindex="1">Next</a></li>
	  					</ul><!-- .jp-controls -->
	  				</div><!-- .jp-controls-wrap -->
	  				
	  				<ul class="track-info">
	  					<li class="track-name"></li>
	  					<li class="artist-name"></li>
	  					<li class="purchase">
	  						<a href="" title="Purchase on CDBaby" class="artist-cdbaby">CDBaby</a>
	  						<a href="" title="Purchase on iTunes" class="artist-itunes">iTunes</a>
	  					</li>	  					
	  				</ul><!-- .track-info  -->
	  				
	  				<div class="jp-progress-wrap">
	  					<div class="jp-progress">
	  						<div class="jp-seek-bar">
	  							<div class="jp-play-bar"></div>
	  						</div><!-- .jp-seek-bar -->
	  					</div><!-- .jp-progress -->
	  				</div><!-- .jp-progress-wrap -->
	  				
	  				<div class="jp-current-time"></div>
	  				
	  				
	  			</div><!-- jp-interface -->
	  			  	  			
	  				<h4 class="jp-playlist-trigger"><a href="#" class="tooltip" title="Show Playlist">Playlist</a></h4>

	  				<div class="jp-playlist-wrap">
	  					<div id="jp_playlist_<?php echo $audio_player_album ?>" class="jp-playlist">
	  						<ul>
	  							<li></li>
	  						</ul>
	  					</div><!-- .jp-playlist -->
	  				</div><!-- .jp-playlist-wrap -->
	  			  	  		
	  		</div><!-- .jp-type-playlist -->
	  	
	  	</div><!-- .jp-audio -->
	  	
	  	<div class="clearfix"></div>
	  	
	  	<script type="text/javascript">
	  	//<![CDATA[
	  	jQuery(document).ready(function($) {
	  	
	  		var Playlist = function(instance, playlist, options) {
	  			var self = this;
	  	
	  			this.instance = instance; // String: To associate specific HTML with this playlist
	  			this.playlist = playlist; // Array of Objects: The playlist
	  			this.options = options; // Object: The jPlayer constructor options for this playlist
	  	
	  			this.current = 0;
	  	
	  			this.cssId = {
	  				jPlayer: "jquery_jplayer_",
	  				interface: "jp_interface_",
	  				playlist: "jp_playlist_"
	  			};
	  			this.cssSelector = {};
	  	
	  			$.each(this.cssId, function(entity, id) {
	  				self.cssSelector[entity] = "#" + id + self.instance;
	  			});
	  	
	  			if(!this.options.cssSelectorAncestor) {
	  				this.options.cssSelectorAncestor = this.cssSelector.interface;
	  			}
	  	
	  			$(this.cssSelector.jPlayer).jPlayer(this.options);
	  	
	  			$(this.cssSelector.interface + " .jp-previous").click(function() {
	  				self.playlistPrev();
	  				$(this).blur();
	  				return false;
	  			});
	  	
	  			$(this.cssSelector.interface + " .jp-next").click(function() {
	  				self.playlistNext();
	  				$(this).blur();
	  				return false;
	  			});
	  		};
	  	
	  		Playlist.prototype = {
	  			displayPlaylist: function() {
	  				var self = this;
	  				$(this.cssSelector.playlist + " ul").empty();
	  				for (i=0; i < this.playlist.length; i++) {
	  					var listItem = (i === this.playlist.length-1) ? "<li class='jp-playlist-last'>" : "<li>";
	  					listItem += "<a href='#' id='" + this.cssId.playlist + this.instance + "_item_" + i +"' tabindex='1'>"+ this.playlist[i].name +"</a>";
	  	
	  					// Create links to free media
	  					if(this.playlist[i].free) {
	  						var first = true;
	  						listItem += "<div class='jp-free-media'>( ";
	  						$.each(this.playlist[i], function(property,value) {
	  							if($.jPlayer.prototype.format[property]) { // Check property is a media format.
	  								if(first) {
	  									first = false;
	  								} else {
	  									listItem += " | ";
	  								}
	  								listItem += "<a id='" + self.cssId.playlist + self.instance + "_item_" + i + "_" + property + "' href='" + value + "' tabindex='1'>" + property + "</a>";
	  							}
	  						});
	  						listItem += " )</span>";
	  					}
	  	
	  					listItem += "</li>";
	  	
	  					// Associate playlist items with their media
	  					$(this.cssSelector.playlist + " ul").append(listItem);
	  					$(this.cssSelector.playlist + "_item_" + i).data("index", i).click(function() {
	  						var index = $(this).data("index");
	  						if(self.current !== index) {
	  							self.playlistChange(index);
	  						} else {
	  							$(self.cssSelector.jPlayer).jPlayer("play");
	  						}
	  						$(this).blur();
	  						return false;
	  					});
	  	
	  					// Disable free media links to force access via right click
	  					if(this.playlist[i].free) {
	  						$.each(this.playlist[i], function(property,value) {
	  							if($.jPlayer.prototype.format[property]) { // Check property is a media format.
	  								$(self.cssSelector.playlist + "_item_" + i + "_" + property).data("index", i).click(function() {
	  									var index = $(this).data("index");
	  									$(self.cssSelector.playlist + "_item_" + index).click();
	  									$(this).blur();
	  									return false;
	  								});
	  							}
	  						});
	  					}
	  				}
	  			},
	  			playlistInit: function(autoplay) {
	  				// Add img element to artwork container to then provide src through playlistConfig
	  				//$(".PID-media-player .artwork").append("<img />");
	  				
	  				if(autoplay) {
	  					this.playlistChange(this.current);
	  				} else {
	  					this.playlistConfig(this.current);
	  				}
	  			},
	  			playlistConfig: function(index) {
	  				$(this.cssSelector.playlist + "_item_" + this.current).removeClass("jp-playlist-current").parent().removeClass("jp-playlist-current");
	  				$(this.cssSelector.playlist + "_item_" + index).addClass("jp-playlist-current").parent().addClass("jp-playlist-current");
	  				this.current = index;
	  				$('.artwork img').attr('src', this.playlist[this.current].artwork);
	  				$('.track-name').text(this.playlist[this.current].name);
	  				$('.artist-name').text(this.playlist[this.current].artist);
	  				$('.artist-itunes').attr('href',this.playlist[this.current].itunes);
	  				$('.artist-cdbaby').attr('href',this.playlist[this.current].cdbaby);
	  				$(this.cssSelector.jPlayer).jPlayer("setMedia", this.playlist[this.current]);
	  			},
	  			playlistChange: function(index) {
	  				this.playlistConfig(index);
	  				$(this.cssSelector.jPlayer).jPlayer("play");
	  			},
	  			playlistNext: function() {
	  				var index = (this.current + 1 < this.playlist.length) ? this.current + 1 : 0;
	  				this.playlistChange(index);
	  			},
	  			playlistPrev: function() {
	  				var index = (this.current - 1 >= 0) ? this.current - 1 : this.playlist.length - 1;
	  				this.playlistChange(index);
	  			}
	  		};
	  		
	  		var audioPlaylist = new Playlist("<?php echo $audio_player_album ?>", [
	  			
	  			<?php
	  			/*
		  			 * jPlayer Playlist
		  			 *
		  			 */

	  			/* Create New Query */
	  			$albums_args = array (
	  			  'p' => $audio_player_album_id,
	  			  'posts_per_page' => 1,
	  			  'post_type' => 'discography'
	  			);
	  			$albums_query = new WP_Query( $albums_args );
	  			
	  			/**
	  			 * The Loop
	  			 * 
	  			 */
	  			if ( $albums_query->have_posts() ) : while ( $albums_query->have_posts() ) : $albums_query->the_post(); ?>
	  			 
	  				<?php include (dirname(__FILE__).'/includes/jplayer-playlist.php'); ?>
	  			
	  			<?php endwhile; // end $albums_query ?>
	  			
	  			<?php else : ?>
	  				
	  			 	{
	  			 	  artwork: "<?php echo esc_url( $artwork_image_source ); ?>",
	  			 	  name: "<?php echo 'No album setup' ?>",
	  			 	  artist: "",
	  			 	  album: "",
	  			 	  mp3:""
	  			 	}
	  			
	  			<?php endif; wp_reset_query(); // reset query ?>
	  			
	  		], {
	  			ready: function() {
	  				audioPlaylist.displayPlaylist();
	  				audioPlaylist.playlistInit(false); // Parameter is a boolean for autoplay.
	  			},
	  			ended: function() {
	  				audioPlaylist.playlistNext();
	  			},
	  			play: function() {
	  				$(this).jPlayer("pauseOthers");
	  			},
	  			swfPath: "<?php echo PID_URL ?>/js/jplayer/js",
	  			solution: "flash, html", // Flash with an HTML5 fallback.
	  			supplied: "mp3" 			
	  		});
	  		
	  	});
	  	//]]>
	  	</script>
	  	
	  </div>

<?php }


add_action( 'widgets_init', 'pid_register_widgets' );

 //register our widget
function pid_register_widgets() {
    register_widget( 'pid_widget_html5' );
}

class pid_widget_html5 extends WP_Widget {

    //process the new widget
    function pid_widget_html5() {
        $widget_ops = array( 
			'classname' => 'widget_pid_widget_html5_widget_class', 
			'description' => 'Displays the HTML5 audio player as a widget.' 
			); 
        $this->WP_Widget( 'pid_widget_html5', 'Badass HTML5 Audio', $widget_ops );
    }
 
     //build the widget settings form
    function form( $instance ) {
        $defaults = array( 'album' => '0' );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $album = $instance['album'];
        ?>
            <p>Play which album?:
			<?php 
			$args = array(
				'sort_order'   => 'ASC',
				'sort_column'  => 'post_title',
				'selected'     => $album,
				'hierarchical' => 0,
				'echo'         => 1,
				'name'         => $this->get_field_name('album'),
				'post_type'    => 'discography',
				);
			wp_dropdown_pages( $args );
			?>
            </p>
        <?php
    }
 
    //save the widget settings
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['album'] = $new_instance['album'];
        return $instance;
    }
 
    //display the widget
    function widget( $args, $instance ) {
        extract( $args );
 
        echo $before_widget;
        $title = apply_filters( 'widget_title', $instance['title'] );
        $album = empty( $instance['album'] ) ? 'default' : $instance['album'];
 
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };

        pid_display_player ( $album );

        echo $after_widget;
    }
}

function pid_html5_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'id' => '0',
	), $atts ) );

	return pid_display_player( $id );
}
add_shortcode( 'html5-audio', 'pid_html5_shortcode' );