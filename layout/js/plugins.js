(function($){

	"use strict";

/* ==========================================================================
   When document is ready, do
   ========================================================================== */
   
	$(document).ready(function(){

		// sticky header
		// http://imakewebthings.com/jquery-waypoints/shortcuts/sticky-elements/	
	
		var stickyHeader = false;
		
		if ($('body').hasClass('ewf-sticky-header')){
			stickyHeader = true;
		}
		
		if((typeof $.fn.waypoint != 'undefined') && stickyHeader && ($(window).width() > 1024)){ 
		
			$('#header').waypoint('sticky', {
			  wrapper: '<div class="sticky-wrapper" />',
			  stuckClass: 'stuck'
			});

		}
		
		// simplePlaceholder - polyfill for mimicking the HTML5 placeholder attribute using jQuery
		// https://github.com/marcgg/Simple-Placeholder/blob/master/README.md
		
		if(typeof $.fn.simplePlaceholder != 'undefined'){
			
			$('input[placeholder], textarea[placeholder]').simplePlaceholder();
		
		}
		
		// Fitvids - fluid width video embeds
		// https://github.com/davatron5000/FitVids.js/blob/master/README.md
		
		if(typeof $.fn.fitVids != 'undefined'){
			
			$('.fitvids').fitVids();
		
		}
		
		// Superfish - enhance pure CSS drop-down menus
		// http://users.tpg.com.au/j_birch/plugins/superfish/options/
		
		if(typeof $.fn.superfish != 'undefined'){
			
			$('#menu').superfish({
				delay: 100,
				animation: {opacity:'show',height:'show'},
				speed: 100,
				cssArrows: false
			});
			
		}
		
		// bxSlider - responsive slider
		// http://bxslider.com/options
		
		if(typeof $.fn.bxSlider != 'undefined'){
			
			$('.testimonial-slider .slides').bxSlider({
				 mode: 'horizontal',
				 speed: 500,
				 slideMargin: 0,
				 infiniteLoop: true,
				 hideControlOnEnd: false,
				 adaptiveHeight: false,
				 adaptiveHeightSpeed: 500,
				 video: false,
				 pager: true,
				 pagerType: 'full' ,
				 controls: false,
				 auto: true,
				 pause: 4000,
				 autoHover: true,
				 useCSS: false
			});
			
		}
				
		// Magnific PopUp - responsive lightbox
		// http://dimsemenov.com/plugins/magnific-popup/documentation.html
		
		if(typeof $.fn.magnificPopup != 'undefined'){
		
			$('.magnificPopup').magnificPopup({
				disableOn: 400,
				closeOnContentClick: true,
				type: 'image'
			});
			
			$('.magnificPopup-gallery').magnificPopup({
				disableOn: 400,
				type: 'image',
				gallery: {
					enabled: true
				}
			});
			
			$('.magnificPopup-video').magnificPopup({
				type: 'iframe'
			});
		
		}
		
		// gMap -  embed Google Maps into your website; uses Google Maps v3
		// http://labs.mario.ec/jquery-gmap/
		
		if(typeof $.fn.gMap != 'undefined'){
		
			$(".google-map").each(function() {
				
				var $t = $(this);
				
				var mapZoom = parseInt($t.attr("data-zoom"));
				var mapAddress = $t.attr("data-address");
				var mapCaption = $t.attr("data-caption");
				
				$t.gMap({
					maptype: 'ROADMAP',
					scrollwheel: false,
					zoom: mapZoom,
					markers: [{
							address: mapAddress,
							html: mapCaption,
							popup: false
						}
					]
				});
		
			});
			
		}
		
		//

	});
	
/* ==========================================================================
   When the window is scrolled, do
   ========================================================================== */
   	
	$(window).scroll(function () {
							   
		
		
	});

})(window.jQuery);

// non jQuery plugins below

