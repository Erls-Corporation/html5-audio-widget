<?php 
// Get MediaAccess global variable
global $wpalchemy_media_access; 
?>

<div id="c7s-album-info" class="c7s-metabox">

	<div class="metabox-tabs-div">
	  
	  <ul class="metabox-tabs" id="metabox-tabs">
	  	<li class="active tab1"><a class="active" href="javascript:void(null);"><?php echo __( 'General', 'framework' ); ?></a></li>
	  	<li class="tab2"><a href="javascript:void(null);"><?php echo __( 'Tracks', 'framework' ); ?></a></li>
	  </ul>
	  
	  <div class="tab1">
	  	<h4 class="heading"><?php echo __( 'General', 'framework' ); ?></h4>
	  	
	  	<table>
	  		<tr>
	  			<td>
	  				<table>
	  					<tbody>
	  						<tr>
	  						  <td>
										<label><?php echo __( 'Artist Name' , 'framework' ); ?></label><br />
										<?php $mb->the_field( 'artist_name' ); ?>
										<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	  						  </td>
	  						  <td>
										<label><?php echo __( 'Album Name' , 'framework' ); ?></label><br />
										<?php $mb->the_field( 'album_name' ); ?>
										<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	  						  </td>
	  						</tr>
	  					</tbody>
	  				</table>
	  			</td>
	  		</tr>
	  	</table>
	  </div><!-- .tabs1 -->
	 
	  <div class="tab2">
	  	<h4 class="heading"><?php echo __( 'Tracks', 'framework' ); ?></h4>

	  	<?php $track_count = 0; ?>
			<?php while( $mb->have_fields_and_multi( 'tracks' ) ) : ?>
				<?php $mb->the_group_open(); ?>
				
				<?php 
				$track_count++;
				if ( $track_count < 10 )
				  $track_count = "0$track_count"; ?>
				 
	  		<table class="form-table">
	  			<tbody>
						<tr>
						  <td class="w33">
						    <label><span class="track-count"><?php echo esc_html( $track_count )  ?>.</span> <?php echo __( 'Track Name' , 'framework' ); ?></label><br />
						    <?php $mb->the_field( 'track_name' ); ?>
						    <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
						  </td>
							<td class="w33">
								<label><?php echo __( 'Track File URL <span>(MP3)</span>' , 'framework' ); ?></label><br />
				  			<?php $mb->the_field( 'track_file' ); ?>
				  			<?php $wpalchemy_media_access->setGroupName( 'n' . $mb->get_the_index() )->setInsertButtonLabel( 'Insert MP3 File' ); ?>
				  			<?php echo $wpalchemy_media_access->getField( array( 'name' => $mb->get_the_name(), 'value' => $mb->get_the_value() ) ); ?>
							</td>
							<td class="w33" style="padding-top: 13px;">
								<br />
								<?php echo $wpalchemy_media_access->getButton( array( 'label' => 'Attach MP3', 'class' => 'left media-access-button' ) ); ?>
								<input style="margin-left: 5px; border: none" type="button" class="dodelete deletion right" value="<?php echo __( 'Remove Track', 'framework' ); ?>" />
							</td>
						</tr>
						<tr>
						<td class="w33">
						<label>iTunes link</label>
						<?php $mb->the_field( 'itunes' ); ?>
						    <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
						</td>
						<td class='w33'>
						<label>CdBaby link</label>
						<?php $mb->the_field( 'cdbaby' ); ?>
						    <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
						</td>
						</tr>
	  			</tbody>
	  		</table>
				<?php $mb->the_group_close(); ?>
			<?php endwhile; ?>
			<table>
				<tfoot>
					<tr>
						<td style="padding-top: 5px;">
							<p class="sort-warning left"><?php _e( 'The order has been changed.', 'framework' ) ?> <em><?php _e( 'Don\'t forget to save and update!', 'framework' ) ?></em></p>
							<input style="margin: 0 8px" type="button" class="docopy-tracks button right" value="<?php echo __( 'Add Track', 'framework' ); ?>" />
						</td>
					</tr>
				</tfoot>
			</table>

	  </div><!-- .tab2 -->
	
	</div><!-- .metabox-tabs-div -->

</div> <!-- wpalchemy-metabox -->

<style type="text/css">
/* Group Styles */
.wpa_loop .wpa_group {
  cursor: move;
  overflow: hidden;
  border-bottom: 1px dotted #E3E3E3;
  background: url(<?php echo PID_URL; ?>/images/corner.png) no-repeat;
}
.wpa_loop .wpa_group:nth-child(odd) {
  background-color: #fff;
}
.wpa_loop .wpa_group:hover {
  background-color: #eaf2fb;
}
.wpa_loop .slide-highlight {
  height: 70px;
  border: 3px dashed #E3E3E3;
  background: #f5f5f5;
}
</style>

<script type="text/javascript">
//<![CDATA[
	
	jQuery(function($)
	{
		$("#wpa_loop-tracks").sortable({
			placeholder: 'slide-highlight',
			change: function() {
				$('.sort-warning').fadeIn('slow');
			}
		});
		
		$('.lyric-box').hide();
		$('.add-lyrics').click( function() {
		  $(this).closest('tr').next().find('.lyric-box').toggle('fast');
		});
	})
	
//]]>
</script>