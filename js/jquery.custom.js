
jQuery.noConflict();
jQuery(document).ready(function($) {

/*-------------------------------------------------------------*/
//					to top link script
/*------------------------------------------------------------*/
		jQuery.fn.topLink = function(settings) {
				settings = jQuery.extend({
				min: 1,
				fadeSpeed: 200
				},
				settings );
				return this.each(function() {
					// listen for scroll
					var el = $(this);
					el.hide(); // in case the user forgot
					jQuery(window).scroll(function() {
					if($(window).scrollTop() >= settings.min) {
					el.fadeIn(settings.fadeSpeed);
					} else {
					el.fadeOut(settings.fadeSpeed);
					}
				});
			});
			};

/*-------------------------------------------------------------*/
//					usage w/ smoothscroll
/*------------------------------------------------------------*/
			jQuery(document).ready(function() {
			// set the link
				jQuery('#top-link').topLink({
				min: 400,
				fadeSpeed: 500
				});

				// smoothscroll
				jQuery('#top-link').click(function(e) {
				e.preventDefault();
				jQuery.scrollTo(0,300);
				});
			});




/*-------------------------------------------------------------*/
//				Tooltip
/*------------------------------------------------------------*/

			jQuery(".hastip").tipTip({defaultPosition: "top"});



/*-------------------------------------------------------------*/
//				PrettyPhoto
/*------------------------------------------------------------*/

			jQuery("a[rel^='prettyPhoto']").prettyPhoto({
						theme: 'light_rounded',
						counter_separator_label: ' of ',
						social_tools: '<div class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div><div class="facebook"><iframe src="//www.facebook.com/plugins/like.php?locale=en_US&href={location_href}&layout=button_count&show_faces=true&width=500&action=like&font&colorscheme=light&height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div><div class="google_plus"><div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300"></div><script type="text/javascript">(function(){ var po = document.createElement("script"); po.type = "text/javascript"; po.async = true; po.src = "https://apis.google.com/js/plusone.js"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s); })();</script></div></div>'
					});


/*-------------------------------------------------------------*/
//				Image Hover
/*------------------------------------------------------------*/

					jQuery(".ad img, .portfolio-large img").hover(

						function() {

							jQuery(this).animate({"opacity": ".8"}, "fast");

							},

						function() {

							jQuery(this).animate({"opacity": "1"}, "fast");

					});


/*-------------------------------------------------------------*/
//				Tabs
/*------------------------------------------------------------*/

					jQuery( function( ) {
						jQuery( "ul.tabs" ).tabs( "div.panes > div" );
					} );



/*-------------------------------------------------------------*/
//				Toggle
/*------------------------------------------------------------*/

						jQuery(".toggle-container").hide();



						jQuery(".trigger").toggle(function(){

							jQuery(this).addClass("active");

							}, function () {

							jQuery(this).removeClass("active");

						});

						jQuery(".trigger").click(function(){

							jQuery(this).next(".toggle-container").slideToggle();

						});



						jQuery('.trigger a').hover(function() {

						jQuery(this).stop(true,false).animate({color: '#666'},50);

							}, function () {

							jQuery(this).stop(true,false).animate({color: '#888'},150);

					});

/*-------------------------------------------------------------*/
//				Accordion
/*------------------------------------------------------------*/

					jQuery('.accordion').hide();



					jQuery('.trigger-button').click(function() {

						jQuery(".trigger-button").removeClass("active")

						jQuery('.accordion').slideUp('normal');

						if(jQuery(this).next().is(':hidden') == true) {

							jQuery(this).next().slideDown('normal');

							jQuery(this).addClass("active");

						 }

					 });



					 jQuery('.trigger-button').hover(function() {

						jQuery(this).stop(true,false).animate({color: '#666'},50);

							}, function () {

							jQuery(this).stop(true,false).animate({color: '#888'},150);

					});

/*-------------------------------------------------------------*/
//				Window Scroll
/*------------------------------------------------------------*/

	// var has_class = jQuery('body').hasClass('zp-landing');

	// if( !has_class ){
	// 	var menu_orig_pos = jQuery('.nav-primary').position().top;
	// 	var secondary_nav = jQuery('.nav-secondary');


	// 	jQuery(window).scroll(function() {
	// 			scrolltop = jQuery(window).scrollTop();
	// 			var menuPosition = jQuery('.nav-primary').position().top;



	// 	if(jQuery( document ).width() > 1024){
	// 			// if( scrolltop > menuPosition ) {
	// 			// 	jQuery('.nav-primary').removeClass('zp_show');
	// 			// 	jQuery('.nav-primary').addClass('zp_hide');

	// 			// 	jQuery('.nav-secondary').removeClass('zp_hide');
	// 			// 	jQuery('.nav-secondary').addClass('zp_show');

	// 			// }
	// 			// if( scrolltop < menu_orig_pos ) {
	// 			// 	jQuery('.nav-primary').removeClass('zp_hide');
	// 			// 	jQuery('.nav-primary').addClass('zp_show');

	// 			// 	jQuery('.nav-secondary').removeClass('zp_show');
	// 			// 	jQuery('.nav-secondary').addClass('zp_hide');

	// 			// }
	// 		}
	// 	});
	// }

/*-------------------------------------------------------------*/
//				Element Animation
/*------------------------------------------------------------*/
	//return jQuery.waypoints('viewportHeight') - jQuery(this).height() + 100;

	jQuery(' .portfolio_shortcode, .zp-grid-wrapper').waypoint(function() {
			jQuery(this).addClass('zp_start_animation');
	}, {
		offset:'100%'
	});

	// Animation to service box
	jQuery('.special-services-box').waypoint(function() {
		var children = jQuery(".special-services-box");
		var index = 0;

		function addClassToNextChild() {
			if (index == children.length) return;
			children.eq(index++).addClass("zp_start_animation");
			window.setTimeout(addClassToNextChild, 500);
		}
		addClassToNextChild();
	}, {
		offset:'100%'
	});

	// Animation to team box
	jQuery('.team').waypoint(function() {
		var children = jQuery(".team");
		var index = 0;

		function addClassToNextChild() {
			if (index == children.length) return;
			children.eq(index++).addClass("zp_start_animation");
			window.setTimeout(addClassToNextChild, 500);
		}
		addClassToNextChild();
	}, {
		offset:'100%'
	});

	//// Animation to Columns
	jQuery('.columns').waypoint(function() {
		var children = jQuery(".columns");
		var index = 0;

		function addClassToNextChild() {
			if (index == children.length) return;
			children.eq(index++).addClass("zp_start_animation");
			window.setTimeout(addClassToNextChild, 500);
		}
		addClassToNextChild();
	}, {
		offset:'100%'
	});




});


/*-------------------------------------------------------------*/
//			Set sidebar height
/*------------------------------------------------------------*/
jQuery(window).load(function(){

		var site_height = jQuery('.site-container').height();
		var side_height = jQuery('.sidebar').height();

		if( site_height > side_height){
				jQuery('.sidebar').css({"height":"100%"});
		}else{
			jQuery('.sidebar').css({"height":"auto"});
		}


});

/*-------------------------------------------------------------*/
//			Flexslider Caption Animation
/*------------------------------------------------------------*/

function zp_sliderCaptionAnimate(slider) {
 	var $currentSlide = jQuery('.homeslider .slides li').not('.clone').eq(slider.animatingTo),
	    $otherSlides = jQuery('.homeslider .slides li').not($currentSlide);

	$otherSlides.find('h3').animate({'margin-top': 0, 'opacity': 0}, 1000);
	$otherSlides.find('.excerpt').animate({'left': '-680px', 'opacity': 0}, 1000);
	$currentSlide.find('h3').animate({'margin-top': '20%', 'opacity': 1}, 1000);
	$currentSlide.find('.excerpt').animate({'left': 0, 'opacity': 1}, 1000);
}