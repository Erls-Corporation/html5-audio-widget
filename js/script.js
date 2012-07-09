//jQuery.noConflict();

/*
 * Superfish v1.4.8 - jQuery menu widget
 * Copyright (c) 2008 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 * CHANGELOG: http://users.tpg.com.au/j_birch/plugins/superfish/changelog.txt
 */

(function($) {
	
	/* Tooltip
	 * powered by jQuery (http://www.jquery.com)
	 * 
	 * written by Alen Grakalic (http://cssglobe.com)
	 * 
	 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
	 -------------------------------------------------------*/
	this.tooltip = function(){	

			xTooltipOffset = 25;
			yTooltipOffset = 5;		

		$("a.tooltip").hover(function(e){											  
			this.t = this.title;
			this.title = "";									  
			$("body").append("<p id='tooltip'>"+ this.t +"</p>");
			$("#tooltip")
				.css("top",(e.pageY - xTooltipOffset) + "px")
				.css("left",(e.pageX + yTooltipOffset) + "px")
				.fadeIn("fast");		
	    },
		function(){
			this.title = this.t;		
			$("#tooltip").remove();
	    });	
		$("a.tooltip").mousemove(function(e){
			$("#tooltip")
				.css("top",(e.pageY - xTooltipOffset) + "px")
				.css("left",(e.pageX + yTooltipOffset) + "px");
		});			
	};
	

	
})(window.jQuery);




jQuery(document).ready(function($) {

	/* jPlayer Playlist - Reveal/Hide
	 -------------------------------------------------------*/
	$(".jp-playlist-trigger").click(function() {
	  $(this).toggleClass("active").next().slideToggle('fast');
	  return false;
	});
	
	
	/* Discography Audio Plugin Toggle
	 -------------------------------------------------------*/
	//Hide (Collapse) the toggle containers on load
	$(".album-track .audioplayer_container").hide(); 
	
	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$(".album-track .track-title").click(function() {
	  $(this).toggleClass("active").next().slideToggle('fast').next().play();
	  return false; //Prevent the browser jump to the link anchor
	});
	



});
