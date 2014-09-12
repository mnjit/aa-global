// JavaScript Document

window.dtStorage = {};

dtStorage.isRetina	= (window.devicePixelRatio >= 2);
dtStorage.isMobile	= (/(Android|BlackBerry|iPhone|iPod|iPad|Palm|Symbian)/.test(navigator.userAgent));
dtStorage.isAndroid	= (/(Android)/.test(navigator.userAgent));
dtStorage.isiOS		= (/(iPhone|iPod|iPad)/.test(navigator.userAgent));
dtStorage.isiPhone	= (/(iPhone|iPod)/.test(navigator.userAgent));
dtStorage.isiPad	= (/(iPad)/.test(navigator.userAgent));
dtStorage.resizeCounter = 0;
dtStorage.theWidth	= 0;

window.notResponsive = 0;
jQuery(document).ready(function($){
	jQuery(".dt-slider-container").appendTo('#slide, #fs-slideshow');
});

jQuery(document).ready(function($){
	if( $('#footer > .foot-cont').hasClass('dt-hide-in-mobile') )
		$('.line-footer').addClass('dt-no-bg');
	
	if( !$('#footer > .foot-cont').length )
		$('.line-footer').addClass('dt-no-bg-atall');
});

//----------------------------------------------------------------------------------------------------------------

//misc
jQuery(document).ready( function($) {
	//scroll to top on click
	$("#nav-above").find('a').live( 'click', function () {
		if( jQuery(this).hasClass('no-act') )
			return true;
		
		if( jQuery(this).parent().hasClass('act') )
			return true;

		$("html"+( ! $.browser.opera ? ",body" : "")).animate({scrollTop: $(".gallery").offset().top}, 500);
	});

	$('#footer').find('.widget').each( function(){
		$(this).wrap("<div class='one-fourth'></div>");
	});
	//make wrap for blockquote
	$("blockquote").wrap('<div class="blockquote-bg"><div class="quote-l"><div class="quote-r"></div></div></div>').parent(".blockquote-bg");
	$('.right-top li, .goto-post span, .comment-meta .ico-link').append('<div class="dot"></div>');

	if($('#header').siblings('.byOne').length){
		$('#header').addClass('for-byOne');
	}
	else{
		$('#header').removeClass('for-byOne');
	};

	//make wrap for images
	$('img.alignleft, .wp-caption img').each(function () {
		$(this).wrap('<div class="img-frame left"></div>');
	});
	$('a.alignleft').each(function () {
		$(this).addClass('img-frame left');
	});

	$('img.alignright').wrap('<div class="img-frame right"></div>');
	$('img.aligncenter').wrap('<div class="img-frame center"></div>');
	$('img.alignnone').wrap('<div class="img-frame none"></div>');

	$('.widget').each(function(){
		$(this).find('.post:first').addClass('first');
	});

	$('.videos').each(function(){
		var video_w = $(this).children().attr('width');
		$(this).css({
			width: video_w
		});
	});

	if($('.boxed').length){
		$('#wrap').addClass('wrp-boxe');
	}
	else{
		$('#wrap').removeClass('wrp-boxe');
	};

	if($.browser.msie && $.browser.version < 9){
		$('.reviews-t').removeClass('p-r');
	}
	else {
		$('.reviews-t').addClass('p-r');
	};

	$('#nav li div ul li a').each(function(){
		var par = $(this).parent();
		$(this).find('.a-inner').detach().appendTo(par);
	});

	if (!dtStorage.isMobile) {
		// Search box animation
		$("#top-bg .i-search").on("click", function() {
			$(this).parent().css("width", "90px");
		});
		$("#top-bg .i-search").on("blur", function() {
			$(this).parent().css("width", "50px");
		});
	};

});
//----------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function($){
	
	//Nivo Slider homepage
	$("#slider").each(function(){

		var $this				= $(this),
			autoslideOn			= $(this).attr("data-autoslide_on") || 0,
			autoslideInterval	= $(this).attr("data-autoslide") || 7000;
		
		if(autoslideOn == "0") {
			autoslideOn = false;
		} else if (autoslideOn == "1") {
			autoslideOn = true;
		};

		$(this).nivoSlider({
			autoslide: autoslideOn,
			pauseTime: autoslideInterval,
			effect: 'boxRandom',
			animSpeed: 700,
			boxCols: 6,
			directionNav: false,
			controlNav: true,
			prevText: '',
			nextText: '',
			customNav: true,
			customNavPrev: '.big-slider .nivo-prevNav',
			customNavNext: '.big-slider .nivo-nextNav',
			beforeChange: function(){
				
				$('.grid').delay(100).fadeTo(500, 0.8).delay(200).fadeTo(700, 0);
			},
			afterChange: function(){}
			
		});
		$('.nivoSlider').append('<div class="grid"></div>');
	});
	//**********************************************************************************************************************************************************************************
	//Nivo Slider widgets
	$(".widget_slider").each(function(){
		var prev_slide = $(this).parents(".widget").find(".navig-small .SliderNamePrev"),
			next_slide = $(this).parents(".widget").find(".navig-small .SliderNameNext");

		var $this				= $(this),
			autoslideOn			= $(this).attr("data-autoslide_on") || 0,
			autoslideInterval	= $(this).attr("data-autoslide") || 7000;
		
		if(autoslideOn == "0") {
			autoslideOn = false;
		} else if (autoslideOn == "1") {
			autoslideOn = true;
		};

		$(this).nivoSlider({
			autoslide: autoslideOn,
			pauseTime: autoslideInterval,
			slices: 4,
			boxCols: 4,
			directionNav: false,
			controlNav: false,
			prevText: '',
			nextText: '',
			customNav: true,
			customNavPrev_w: prev_slide,
			customNavNext_w: next_slide
		});
		$('.widget_slider').append('<div class="mask-t"></div>');
	});
	//****************************************************************************************************************
	
	$(".widget_slider2").each(function(){
		var prev_slide = $(this).parents(".widget").find(".navig-small .SliderNamePrev2"),
			next_slide = $(this).parents(".widget").find(".navig-small .SliderNameNext2");
		var $this				= $(this),
			autoslideOn			= $(this).attr("data-autoslide_on") || 0,
			autoslideInterval	= $(this).attr("data-autoslide") || 7000;
		
		if(autoslideOn == "0") {
			autoslideOn = false;
		} else if (autoslideOn == "1") {
			autoslideOn = true;
		};

		$(this).nivoSlider({
			autoslide: autoslideOn,
			pauseTime: autoslideInterval,
			slices: 4,
			boxCols: 4,
			directionNav: false,
			controlNav: false,
			prevText: '',
			nextText: '',
			customNav: true,
			customNavPrev_w: prev_slide,
			customNavNext_w: next_slide
		});
	});
	//***********************************************************************************************************************
	//Nivo Slider shortcodes
	$(".slider-short").each(function(){
		var prev_slide = $(this).parents(".widget").find(".navig-small .SliderNamePrev"),
			next_slide = $(this).parents(".widget").find(".navig-small .SliderNameNext");	
		var $this				= $(this),
			autoslideOn			= $(this).attr("data-autoslide_on") || 0,
			autoslideInterval	= $(this).attr("data-autoslide") || 7000;
		
		if(autoslideOn == "0") {
			autoslideOn = false;
		} else if (autoslideOn == "1") {
			autoslideOn = true;
		};

		$(this).nivoSlider({
			autoslide: autoslideOn,
			pauseTime: autoslideInterval,
			effect: 'boxRandom',
			animSpeed: 700,
			boxCols: 6,
			directionNav: false,
			controlNav: false,
			prevText: '',
			nextText: '',
			customNav: true,
			customNavPrev: '.shortcode-slide .nivo-prevNav',
			customNavNext: '.shortcode-slide .nivo-nextNav',
			beforeChange: function(){
				$('.grid').delay(100).fadeTo(500, 0.8).delay(200).fadeTo(700, 0);
			},
			afterChange: function(){
			}
		});
	});
	//*****************************************************************************************************************************
	$("#container").find('.slider-short').each(function(){
	
		var prev_slide = $(this).parents(".slider-shprtcode").find(".navig-nivo .nivo-prevNav"),
			next_slide = $(this).parents(".slider-shprtcode").find(".navig-nivo .nivo-nextNav");	
			
		var $this				= $(this),
			autoslideOn			= $(this).attr("data-autoslide_on") || 0,
			autoslideInterval	= $(this).attr("data-autoslide") || 7000;
		
		if(autoslideOn == "0") {
			autoslideOn = false;
		} else if (autoslideOn == "1") {
			autoslideOn = true;
		};

		$(this).nivoSlider({
			autoslide: autoslideOn,
			pauseTime: autoslideInterval,
			effect: 'boxRandom',
			animSpeed: 700,
			boxCols: 6,
			directionNav: false,
			controlNav: false,
			prevText: '',
			nextText: '',
			customNav: true,
			customNavPrev: '.shortcode-slide .nivo-prevNav',
			customNavNext: '.shortcode-slide .nivo-nextNav',
			beforeChange: function(){
				$('.grid').delay(100).fadeTo(500, 0.8).delay(200).fadeTo(700, 0);
			},
			afterChange: function(){
			}
		});
	});
	//*************************************************************************************************************************************

	//Drop down menu
	/*$('#nav li, #nav li a').find('> span').append('<span class="one-t"></span><span class="two-t"></span><span class="three-t"></span>')*/
	
	var $topLogo = /*(dtStorage.isRetina) ? $(".dt-top-retina-logo") : $("#dt-top-logo")*/ $('.logo img');
	
	var	logoHeight	= $topLogo.outerHeight(),
		logoWidth	= $topLogo.outerWidth();

	window.deviceAgent = navigator.userAgent.toLowerCase();
	window.agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
	window.ua = navigator.userAgent.toLowerCase();
	window.isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
	
	$('#nav > li > a').css({
		'lineHeight' : logoHeight + 20 - 3 +'px'
	});

	$("#nav").find('li').each(function () {
		if($(this).children('a').hasClass('act')){
			$(this).addClass('act');
		}
		else{
			$(this).removeClass('act');
		}

		if($(this).children('div').length <= 0) return;

		var menuTimeoutShow = false,
			menuTimeoutHide = false;

		$(this).hover(function() {
			var $this = $(this);
			$this.addClass("is-hovered");
			clearTimeout(menuTimeoutShow);
			clearTimeout(menuTimeoutHide);
			menuTimeoutShow = setTimeout(function() {
				if($this.hasClass("is-hovered")){
					$this.children('div').stop(true, true).fadeIn(400, function(){});
				}
			}, 200);
		}, 
		function() {
			var $this = $(this);
			$this.removeClass("is-hovered");
			clearTimeout(menuTimeoutShow);
			clearTimeout(menuTimeoutHide);
			menuTimeoutHide = setTimeout(function() {
				if(!$this.hasClass("is-hovered")){
					$this.children('div').stop(true, true).fadeOut(300);
				}
			}, 200);
		});

	});
	$("#nav").find('> li').each(function () {
		var $this = $(this);
		var nav_right     = $("#header").innerWidth() - ( ($this.offset().left -$("#header").offset().left) - $this.width());
		
		if(nav_right < 220 ){
			$(this).addClass('nav-left');			
		}else if(nav_right < 242){
			$(this).addClass('nav-div-left');
		}else{
			$(this).removeClass('nav-left').removeClass('nav-div-left');
		};
	});
	//**************************************************************************************************************************************
	//ios menu click	
	
	window.isiPhone = function (){
		return (
			(navigator.platform.indexOf("iPhone") != -1) ||
			(navigator.platform.indexOf("iPod") != -1)
		);
	};
	$('#nav li').each(function(){
		if ($(this).find("div").length > 0) {
			$(this).addClass('children');
		}
		else{
			$(this).removeClass('children');
		};
	});
	
	if(isAndroid || isiPhone() || agentID) {
	
		var hasTouch = ("ontouchstart" in window);
		if (hasTouch && document.querySelectorAll) {
			var i, len, element,
				dropdowns = document.querySelectorAll("#nav > li.children > a, #nav > li.children > div > ul > li.children > a, .menu-container li.children");
		 
			function menuTouch(event) {
				var i, len, noclick = !(this.dataNoclick);
				// reset flag on all links
				for (i = 0, len = dropdowns.length; i < len; ++i) {
					dropdowns[i].dataNoclick = false;
				}		 
				// set new flag value and focus on dropdown menu
				this.dataNoclick = noclick;
				this.focus();
			};	 
			function menuClick(event) {
				// if click isn't wanted, prevent it
				if (this.dataNoclick) {
					event.preventDefault();
				}
			};	 
			for (i = 0, len = dropdowns.length; i < len; ++i) {
				element = dropdowns[i];
				element.dataNoclick = false;
				element.addEventListener("touchstart", menuTouch, false);
				element.addEventListener("click", menuClick, false);
			};
		};
	};
	
	
	//********************************************************************************************************************************

	$('.list-carousel, .reviews-t, .about, .partner-bg').css('visibility', 'visible');
	$('.list-carousel.bx').css('overflow', 'visible');
	

});

//-----------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function($){
	/*$.fn.imageLoaded = function( callback ){
		var $this = this[0];
		if (typeof $this == "undefined") { return false };
		
		var timesRun = 0;
		counter = 0
		var timer  = setInterval(function(){
			timesRun++;
			if(timesRun > 75) {
			counter++
				console.log("It apears that this image cannot be loaded!" + counter);
		    }

			if($this.complete == true || timesRun > 75) {
				clearInterval(timer);
				callback.call($this);
			}
		},200);

		return $this;
	};*/

	$.fn.imageLoaded = function(callback, jointCallback, ensureCallback){
		var len	= this.length;
		if (len > 0) {
			return this.each(function() {
				var	el		= this,
					$el		= $(el),
					blank	= "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";

				$el.on("load.dt", function(event) {
					$(this).off("load.dt");
					if (typeof callback == "function") {
						callback.call(this);
					}
					if (--len <= 0 && (typeof jointCallback == "function")){
						jointCallback.call(this);
					}
				});

				if (!el.complete || el.complete === undefined) {
					el.src = el.src;
				} else {
					$el.trigger("load.dt")
				}
			});
		} else if (ensureCallback) {
			if (typeof callback == "function") {
				jointCallback.call(this);
			}
			return this;
		}
	};

	
	window.preloadImages = function () {
		var $my_images = $('#container img, #footer img, #slide img, #slider img, #aside img').not('.ajax-loader');
		var $my_images_bg = $('.photo img, .view img, .img-frame img, #slider img, .flexslider img, .alignleft-f img')/*.not('.slider1 img')*/;
		$my_images.css({'opacity':'0','visibility':'visible'});
		$my_images_bg.css({'opacity':'0','visibility':'visible'});
		
		
		$my_images_bg.wrap('<div class="loading-image" />').css({'opacity':'0','visibility':'visible'});
	
		$my_images.each( function() {
			$(this).imageLoaded(function(){
				$(this).animate({'opacity':'1'}, 500, function(){
				});
			});
		});
		$my_images_bg.each( function() {
			$(this).imageLoaded(function(){
				$(this).animate({'opacity':'1'}, 500, function(){
					$(this).unwrap();
					jQuery('a.photo').each(function () {				  
						var i=jQuery(this).find("img");
						var i_w = i.width();
						var i_h = i.height();
						jQuery('i.fade', this).css('width', i_w);
						jQuery('i.fade', this).css('height', i_h-3);
					});
				});
			});
		});
	};
	
	window.preloadAjaxImages = function () {

// why are we calling preloading script on allmost every image on ajax load???

		var $my_images = $('.dt-ajax-content img');
		//var $my_images_bg = $('.photo img, .view img, .img-frame img, #slider img, .flexslider img, .alignleft-f img');
		$my_images.css({'opacity':'0','visibility':'visible'});
	
		//$my_images_bg.wrap('<div class="loading-image" />').css({'opacity':'0','visibility':'visible'});
		$my_images.each( function() {
			$(this).imageLoaded(function(){
				$(this).animate({'opacity':'1'}, 500, function(){
					jQuery('a.photo').each(function () {				  
						var i=jQuery(this).find("img");
						var i_w = i.width();
						var i_h = i.height();
						jQuery('i.fade', this).css('width', i_w);
						jQuery('i.fade', this).css('height', i_h-3);
					});
				});
			});
		});
	};
	
	
});

//------------------------------------------------------------------------------------------------------------------------------------
/*Carousel height*/
jQuery( function($) {
	var wrap=$('.caroufredsel_wrapper ul').find(" > img");
		var h_wrap = wrap.height();
	$(this).css('height', h_wrap); //'.caroufredsel_wrapper'
});
//------------------------------------------------------------------------------------------------------------------------------------
/*Widget find last element*/
jQuery( function($) {
	$(".widget").each(function () {
		$(this).find(".post:last-child").addClass('last');
	})
	$("#aside").find(".widget:last-child").addClass('last');
});
//------------------------------------------------------------------------------------------------------------------------------------
//Width for h1
// что это?
jQuery( function($) {
	var inner_w = $('.inner-navig').width();
	if(('.inner-navig').length){
		$('#container > h1').css({
			'maxWidth':$('#container').width() - 40 - inner_w
		})
	}
	else{
	};
});
//------------------------------------------------------------------------------------------------------------------------------------
//Width for portfolio inner info
// что это?
jQuery( function($) {	
	var anit_w = $('.slider-shortcode').width();
	if(!$('.slider-shortcode').length){
		$('.full-left').css({
			'maxWidth':100+'%'
		});	
	}
	else {
		$('.full-left').css({
			'maxWidth':960 - 40 -anit_w
		});
	};
});
//------------------------------------------------------------------------------------------------------------------------------------
/*nivo-caption width*/
jQuery( function($) {
	$(".slider-shortcode").each(function () {
		var im=$(this).find("img");
		var im_w = $(this).width();
		var im_h = im.attr("height");
		$('.nivo-caption', this).css({
			'width': im_w
		});
		$('.html-caption', this).css({
			'width': im_w -36
		}).show();
		/*$('.nivo-caption p, .html-caption p', this).css({
			'maxHeight': im_h/2 
		});	*/	
	});
	//***************************************************************************************************************************************
	$(".widget").find(' .nivoSlider').each(function () {
		var im=$(this).find("img");
		var im_w = im.attr("width")-8;
		var im_h = im.attr("height");
		$('.nivo-caption', this).css('width', im_w, 'maxHeight', im_h/3);
	});
	//***************************************************************************************************************************************
	$(".full-width .slider-shortcode, .one-fourth .slider-shortcode, .half .slider-shortcode, .one-third .slider-shortcode, .two-thirds .slider-shortcode").each(function () {
		var im = $(this).find("img");
		var im_w = im.attr("width");
		var im_h = im.attr("height");
		$('.nivo-caption', this).css({
			'width': im_w - 8,
			'maxHeight': im_h/2
		});		
	});
});
//------------------------------------------------------------------------------------------------------------------------------------

/*Slider textwidget*/
jQuery( function($) {
	if (!('.list-carousel .textwidget').length){
		return false;
	};
	
	var block_counter = 0,
		show_me = '';
	
	$('.list-carousel .textwidget').each(function() {
		var img_wid = $(this).find('img').width();
	
		var parent = $(this).parents('.list-carousel')
		var parent_old = parent.parent();
		var parent_class = parent_old.attr('class');
		if( isAndroid || isiPhone() || agentID ){
			if ($('.widget-info', this).length < 1) {
				
				$('> .textwidget-photo > a', this).not('.highslide').on('click', function(e) {
					
					window.location = this.href;
					return false;
				});

			} else {
				$('> .textwidget-photo > a', this).not('.highslide').on("click", function(e) {
					e.preventDefault();
					var $this = $(this),
						$this_par = $(this).parent(),
						w = $this_par.find("img"),
						w_w = w.width(),
						w_h = w.height();
		
					show_me = $this_par.parent().attr('class').match(/block_no\_.+?\b/);
					
					var $theWidget = $('body > .'+show_me[0]);
					
					if ($this.hasClass("is-clicked")) {
						window.location = this.href;
						return false;
					} else {
						$(".textwidget-photo > a").removeClass("is-clicked");
						$('body > .widget-info').stop(true).fadeOut(100);
						$('body > .widget-info .textwidget-photo').css('display', 'none');
						$this.addClass("is-clicked");
						$theWidget.css({ 
							top: $this_par.offset().top + w_h,
							left: $this_par.offset().left,
							width: w_w -40
						}).fadeIn(500);
						
						return false;
					};
				});	

			};	
		};
		block_counter++;
		$(this).addClass('block_no_'+block_counter);
		$('.widget-info', this).appendTo('body').addClass('block_no_'+block_counter).addClass(parent_class);
	});

	var caroufredselTimeout;

	$('.list-carousel .textwidget-photo').hover(
		function() {
			$(this).addClass("isHovered");

			$('body > .widget-info').stop(true).fadeOut(100);

			var $this = $(this),
				w = $this.find("img"),
				w_w = w.width(),
				w_h = w.height();

			show_me = $(this).parent().attr('class').match(/block_no\_.+?\b/);
			
			var $theWidget = $('body > .'+show_me[0]);
			clearTimeout(caroufredselTimeout);
			caroufredselTimeout = setTimeout(function() {
			
			
				if (!$this.hasClass("isHovered")) { 
					//alert("focus lost")
					return false;
				}

				$theWidget.find(".textwidget-photo").hide();
				$theWidget.css({ 
					top: $this.offset().top + w_h,
					left: $this.offset().left,
					width: w_w -40
					/*paddingTop: "15px"*/
				}).fadeIn(500);

			}, 500);

		}, function() {
			$(this).removeClass("isHovered");
			clearTimeout(caroufredselTimeout);
			$('body > .'+show_me[0]).fadeOut(300);
		}
	);
				
	if (!('body > .widget-info').length) {
		return false;
	} else {
		$("#bg, #wrap").on("click", function(){
			$('body > .widget-info').stop(true).fadeOut(100);
			$(".textwidget-photo > a").removeClass("is-clicked");		
		});
		$('.list-carousel').bind('touchmove',function(e){
			$('body > .widget-info').stop(true).fadeOut(100);
			$(".textwidget-photo > a").removeClass("is-clicked");	
		})

		// Cancel all click events off of paragraphs.
		$('body > .widget-info').on('touchend', function(){
			return false
		});
		$('body > .widget-info').on('touchstart', function(){
			return true
		});
	};
				
});
//------------------------------------------------------------------------------------------------------------------------------------
/*Coda slider autor*/

//Widget
jQuery( function($) {
	$(".textwidget").hover(
		function(){
			$('> .widget-info', this).stop().fadeTo(400, 1);
		}, function(){
			$('> .widget-info', this).stop().fadeTo(200, 0, function(){ $(this).hide() });
		}
	);
});
//------------------------------------------------------------------------------------------------------------------------------------
//PS fade info
jQuery( function($) {
	if (!('.ps-album').length){
		return false;
	} else {
	$(".ps-album").hover(
		function() {
			if ($.browser.msie && $.browser.version < 9)
			{
				$(".slide-desc", this).stop().show();
			} else {
				$(".slide-desc", this).stop().fadeTo(400, 1);
			}
		} , function() {
			if ($.browser.msie && $.browser.version < 9)
			{
				$(".slide-desc", this).stop().hide();
			} else {
				$(".slide-desc", this).stop().fadeTo(200, 0, function(){$(this).hide()});
			}
		});
	};
});
//------------------------------------------------------------------------------------------------------------------------------------

/*Highslide*/

hs.showCredits = 0;
		hs.padToMinWidth = true;		
		//hs.align = 'center';
		if (hs.registerOverlay) {
			// The white controlbar overlay
			hs.registerOverlay({
				thumbnailId: 'thumb3',
				overlayId: 'controlbar',
				position: 'top right',
				hideOnMouseOut: true
			});
			// The simple semitransparent close button overlay
			hs.registerOverlay({
				thumbnailId: 'thumb2',
				html: '<div class="closebutton"	onclick="return hs.close(this)" title="Close"></div>',
				position: 'top right',
				fade: 2 // fading the semi-transparent overlay looks bad in IE
			});
		}
		
		// ONLY FOR THIS EXAMPLE PAGE!
		// Initialize wrapper for rounded-white. The default wrapper (drop-shadow)
		// is initialized internally.
		if (hs.addEventListener && hs.Outline) hs.addEventListener(window, 'load', function () {
			new hs.Outline('rounded-white');
			new hs.Outline('glossy-dark');
		});
		
		// The gallery example on the front page
		var galleryOptions = {
			slideshowGroup: 'gallery',
			wrapperClassName: 'dark',
			//outlineType: 'glossy-dark',
			dimmingOpacity: 0.8,
			align: 'center',
			transitions: ['expand', 'crossfade'],
			fadeInOut: true,
			wrapperClassName: 'borderless floating-caption',
			/*marginLeft: 100,
			marginBottom: 60,*/
			captionEval: null
		};
		
		if (hs.addSlideshow){ hs.addSlideshow({
			slideshowGroup: 'gallery',
			interval: 5000,
			repeat: false,
			useControls: true,
			overlayOptions: {
				className: 'text-controls',
				position: 'bottom center',
				relativeTo: 'viewport',
				offsetY: -10
			}/*,
			thumbstrip: {
				position: 'left top',
				mode: 'vertical',
				relativeTo: 'viewport'
			}
		*/
		});}
		hs.Expander.prototype.onInit = function() {
			hs.marginBottom = (this.slideshowGroup == 'gallery') ? 60 : hs.marginBottom;
			theMobile();
		}
		
		// focus the name field
		hs.Expander.prototype.onAfterExpand = function() {
		
			if (this.a.id == 'contactAnchor') {
				var iframe = window.frames[this.iframe.name],
					doc = iframe.document;
				if (doc.getElementById("theForm")) {
					doc.getElementById("theForm").elements["name"].focus();
				}		
			}
		}	
		
		// Not Highslide related
		function frmPaypalSubmit(frm) {
			if (frm.os0.value == '') {
				alert ('Please enter your domain name');
				return false;
			}
			return true;
		}

// register hs slideshow for widget small photos and gallery shortcode
jQuery(function($){
	if ( typeof hs !== 'undefined' ) {
		$('.flickr, .gall_std.hs_me').each(function(){
			var $this = $(this),
				hsGroup = $this.attr('data-hs_group');
			
			if ( typeof hsGroup !== 'undefined' && hsGroup !== false ) {
				hs.addSlideshow({
					slideshowGroup: hsGroup,
					interval: 5000,
					repeat: false,
					useControls: true,
					overlayOptions: {
						className: 'text-controls',
						position: 'bottom center',
						relativeTo: 'viewport',
						offsetY: -10
					}
				});
			}
		});
	}
});

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Footer

jQuery( function($) {
	///
	$(window).resize(function () {
		if ($("body").hasClass("fs-enabled")) return;
		h = $(window).outerHeight() - $("#top-bg").outerHeight() - $("#header").outerHeight() - $("#slide").outerHeight() - $(".line-footer").outerHeight() - $("#footer").outerHeight()-10;
		$("#container").css('min-height', h+"px");
	});
	
});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//max width for soc icons
jQuery( function($) {
	$('.soc-ico').css({
		'max-width' : $('.top-cont').width() - $('.right-top').width() - 20 +'px'
	});

//Call BxSlider
	if ( $('.slider1').length > 0 ) {
		$('.slider1').not(".twitter").each(function(){
			var	$this = $(this),

				autoslideOn			= $(this).attr("data-autoslide_on") || 0,
				autoslideInterval	= parseInt($(this).attr("data-autoslide") || 7000);			


			if(autoslideOn == "0") {
				autoslideOn = false;
			} else if (autoslideOn == "1") {
				autoslideOn = true;
			}

			var mySlider = $this.bxSlider({
				displaySlideQty: 6,
				auto : autoslideOn,
				pause	: autoslideInterval,
				autoHover	: true,
				moveSlideQty: 1,
				onInit: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
					var $this = currentSlideHtmlObject;
					
					var $activePanel	= $(currentSlideHtmlObject).find(".panel-author").clone().hide();

					if ($activePanel.length < 1) return false;
					if ($this.parents(".reviews-t").next().hasClass("autor")) return false;

					var $bigPapa = $this.parents(".reviews-t");
					var $authorPapa = $bigPapa.find(".autor").detach();
					
					$bigPapa.after($authorPapa);
					
					$authorPapa.append($activePanel);
					$activePanel.show();

					$authorPapa = null;
					$activePanel = null;
				},
				onDestroy: function() {
					$this.parents(".reviews-t").next().find(".panel-author").remove();
				},
				onBeforeSlide: function() {
					$this.parents(".reviews-t").next().find(".panel-author").fadeOut(150, function() { $(this).remove(); });
					$this.find(".loading-image > img").each(function() {
						$(this).unwrap().animate({"opacity" : 1}, 500);
					});
				},
				onAfterSlide: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
					var $this = currentSlideHtmlObject;

					if ($this.parents(".list-carousel").hasClass("coda")) {
						$this.parents(".bx-window").css({
							height: currentSlideHtmlObject.height()
						});
					}

					var $activePanel	= $(currentSlideHtmlObject).find(".panel-author").clone().hide();
					if ($activePanel.length < 1) return false;

					var $authorPapa = $this.parents(".reviews-t").next();
						
					$authorPapa.append($activePanel);
					$activePanel.delay(180).fadeIn(230, function() { $activePanel = null; });
					
					$authorPapa = null;	
				}
				
			});
		
			$this.data("carousel", mySlider);
		
		 });
	};

	//Bx for widgets
	if ( $('.sliderBx').length > 0 ){
		$('.sliderBx').each(function(){
			 var $this = $(this),
				/*this_par_w = $this.parents('.list-carousel').width(),
				this_children_w = $this.children('li').width(),
				this_children_Length = $this.children('li.bx-child'),
				num_show = Math.round(this_par_w/this_children_w),*/
				autoslideOn			= $(this).attr("data-autoslide_on") || 0,
				autoslideInterval	= parseInt($(this).attr("data-autoslide") || 7000);			
			if(autoslideOn == "0") {
				autoslideOn = false;
			} else if (autoslideOn == "1") {
				autoslideOn = true;
			}
			var mySlider = $this.bxSlider({
				//displaySlideQty: 1,
				auto : autoslideOn,
				pause	: autoslideInterval,
				autoHover	: true,
				
				moveSlideQty: 1
				
			});
			$this.data( "carousel", mySlider );
		 });
	};
});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//do hover effect
//hover effect
jQuery( function($) {
		
	$('a.img-frame, a.alignleft, a.alignright, a.alignnone, a.photo, .alignleft-f, .gallery-item a').append('<i class="fade"></i>');

	window.doHover = function () {

		if(agentID || isAndroid || isiPhone()){
			$('i.fade').hide();
		} else {
			$('a.img-frame, a.alignleft, a.alignright, a.alignnone, a.photo, .alignleft-f, .gallery-item a').not(".no-hover").each(function() {				
			
				if(blur_effect) {

					//$(".blur-effect").remove(); // is there a memory leak? no. but this method is really slow.
					
					var $span = $('i.fade', this);

					if ($.browser.msie && $.browser.version < 9) {
						$span.hide();
					} else {
						$span.css('opacity', 0);
					}

					$(this).hover(function() {
						if ($.browser.msie && $.browser.version < 9) {
							$span.show();
						} else {

							$(".blur-effect").remove(); // this may decrease down performance: remove() is kinda slow

							var img_this = $(this).find('img');
							img_this.clone().addClass("blur-effect").prependTo(this);

							$span.stop().fadeTo(700, 1);

							$(".blur-effect", this).pixastic("blurfast", {amount:0.3});
							var blur_this = $(".blur-effect", this);
							blur_this.hide();
							//blur_this.show();
							blur_this.stop().fadeTo(700, 1);

							img_this = null;
						}
					}, function() {

						//$(".blur-effect").remove();

						if ($.browser.msie && $.browser.version < 9){
							$span.hide();
						} else {
						  $span.stop().fadeTo(700, 0);
						  $(".blur-effect", this).stop().fadeOut("slow", function() {
							  $(this).remove();
						  });
						};

					});

				} else {

					var $span = $('i.fade', this);

					if ($.browser.msie && $.browser.version < 9){
						$span.hide();
					} else {
						$span.css('opacity', 0);
					};

					$(this).hover(function() {

						if ($.browser.msie && $.browser.version < 9){
							$span.show();
						}
						else{
							$span.stop().fadeTo(700, 1);							
						};
					}, function() {
						if ($.browser.msie && $.browser.version < 9){
							$span.hide();
						} else {
							$span.stop().fadeTo(700, 0);
						};
					});
					
					  
				};

				var i = $(this).find("img");
				var i_w = i.width();
				var i_h = i.height();
				$('i.fade', this).css('width', i_w);
				$('i.fade', this).css('height', i_h-3);
				i = null;

			});
		}

	};
	
	doHover();
});

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
jQuery( function($){
	$('.one-fourth .header, .one-fourth h2, .one-third .header, .one-third h2, .half .header, .half h2, .two-thirds .header, .two-thirds h2, .full-width .header, .full-width h2').each(function(){
		var $this = $(this);
		var nex = $this.next()
		var parent = $this.parent();
		var parent_width = parent.width();
		if(nex.hasClass('reviews-t') || nex.hasClass('partner-bg')){			
			$this.addClass('max-w');
			$this.css({
				maxWidth:parent_width-40
			});
		};
	});
	//********************************************************************************************************************************************************
	//Arrow slider for window < 1030
	$(window).resize(function () {
		var window_w = $(window).width();
		if(window_w < 1030){
			$('.navig-nivo, .oneByOne1, .slider-shortcode').addClass('small');
			$('.navig-nivo.small').detach().appendTo('#slide');
			$('.navig-nivo.onebyone.small, .navig-nivo.caros.small').detach().insertAfter('#slide');
		}
		else {
			$('.navig-nivo, .oneByOne1, .slider-shortcode').removeClass('small');
			$('.navig-nivo').detach().prependTo('#slide');
			$('.navig-nivo.onebyone, .navig-nivo.caros').detach().insertBefore('#slide');
		};
	});
	//$(window).trigger("resize");

});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// new ajax scripts
  
// comments form
function move_form_to(ee)
{
	  ( function($) {
	  var e = $("#form-holder").html();
	  var tt = $("#form-holder .header").text();
	  
	  var sb =$("#form-holder .go_button").attr("title");
	  
	  var to_slide_up = ($(".comment #form-holder").length ? $("#form-holder") : $(".share_com"));
	  
	  to_slide_up.slideUp(500, function () {
		 $("#form-holder").remove();
		 
		 ee.append('<div id="form-holder">'+e+'</div>');
		 $("#form-holder .header").html(tt);
		 $("#form-holder [valed]").removeAttr('valed');
		 $("#form-holder .do-clear").attr('remove', 1);
		 
		 $(".formError").remove();
		 
		 $("#form-holder").hide();
		 
		 to_slide_up = ($(".comment #form-holder").length ? $("#form-holder") : $(".share_com"));
		 if (to_slide_up.hasClass('share_com')) $("#form-holder").show();
		 
		 to_slide_up.slideDown(500);
		 
		 if (ee.attr("id") != "form_prev_holder")
		 {
			var eid = ee.parent().attr("id");
			if (!eid)
			   eid = "";
			$("#comment_parent").val( eid.replace('comment-', '') );
		 }
		 else
		 {
			$("#comment_parent").val("0");
		 }
		 
		 //update_form_validation();
	  });

	  })(jQuery);
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
jQuery(function ($) {
   $("#comments ").on('click', '.comments', function () {
	  move_form_to( $(this).parent().parent() );
	  return false;
   });
});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready( function($) {
	$('form a.do-clear').live( 'click', function() {
		var container = $(this).parents('form.uniform');
		if( container.length ) {
			$('.i-h > input, .t-h > textarea', container ).val('');
		}

		if ($(this).attr("remove") && !$(this).parents("#form_prev_holder").length) {
			move_form_to( $("#form_prev_holder") );
			$("#form_holder .do_clear").removeAttr('remove');
		}

		return false;
	});
});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// new added
jQuery(document).ready( function($) {
	$(document).on( "click", ".go_submit, .go_button", function () {
	  var e = $(this).parents("form");

	  if( !e.attr("valed") && e.hasClass('ajaxing') ) {
		e.validationEngine({
			ajaxSubmit: true,
			ajaxSubmitFile: e.attr("action")
		});
	  }else if( !e.attr("valed") ) {
		e.validationEngine();
	  }

	  e.attr("valed", "1");
	  e.submit(); 

	  return false;
   });

});
// end comments form
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
(function($) {
	$.fn.addWidgetHover = function() {

		var theGallery = $(".gallery"); // add hovers only to NEW ajax content
		$(".widget-info > .textwidget-photo", theGallery).hide(); // this is sollution a-la "per rectum"

		var widgetHoverTimeout;
		
		
		if( isAndroid || isiPhone() || agentID ){				
			if ($('.widget-info', theGallery).length < 1) {

				$(".textwidget-photo a", theGallery).not('.highslide').on('click', function(e) {
					window.location = this.href;
					return false;
				});

			} else {

				$(".textwidget-photo a", theGallery).not('.highslide').on("click", function(e) {
					e.preventDefault();
					var $this = $(this);
					
					if ($this.hasClass("is-clicked")) {
						window.location = this.href;
						return false;
					} else {
						$(".textwidget-photo a", theGallery).removeClass("is-clicked");
						$('.widget-info').hide();

						
						$this.addClass("is-clicked");
						$this.next(".widget-info").show();
						return false;
					}
				});	

			};			
		};
		
		
		$(".textwidget-photo", theGallery).hover(
			function() {
				var $this = $(this);
				window.img_width = $(this).find('img').width();
				var img_h = $(this).find('img').height();
				$this.addClass("isHovered");

				$(".widget-info").stop().fadeOut(100);
	
				clearTimeout(widgetHoverTimeout);
				widgetHoverTimeout = setTimeout(function() {

					$this.next(".widget-info")
						.stop()
						.css({
							top: img_h,
							width: img_width -40
							//marginTop: "-6px"
							/*,
							paddingTop: "15px"*/
						})
						.fadeIn(500);
		
				}, 500);
	
			}, function() {
				clearTimeout(widgetHoverTimeout);

				var $this = $(this);

				$this.removeClass("isHovered");
				$this.next(".widget-info").stop().fadeOut(300, function() { 
					$(this).hide();
				});
			}
		);
		if (!('.widget-info', theGallery).length) {
			return false;
		} else {
			$( "#bg, #wrap" ).on("click", function(){
				$('.widget-info', theGallery).hide();
				$(".textwidget-photo a", theGallery).removeClass("is-clicked");		
			});
	
			// Cancel all click events off of paragraphs.
			$('.widget-info', theGallery).on('touchend', function(){
				return false
			});
			$('.widget-info', theGallery).on('touchstart', function(){
				return true
			});
		}
		
	};
	
})(jQuery);

function widget_add_hover() {
	jQuery.fn.addWidgetHover();
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function element_add_hover( element ) {
	
	if( typeof element == 'string' ) {
		element = jQuery(element);
	}
	
	var span;
	if( typeof arguments[1] == 'undefined' || typeof arguments[1] == 'number' ) {
		span = jQuery('>i.widget-inf', element);
	}else if( typeof arguments[1] == 'string' ) {
		span = jQuery(arguments[1], element);
	}else {
		span = arguments[1];
	};
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function portfolio_add_zoom( element ) {
	if( typeof element == 'string' ) {
		element = jQuery(element);
	}

	element.each(function(){
	});
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function list_to_grid() {	
	jQuery(".gallery-inner").fadeOut("fast", function() {
		jQuery(this).fadeIn("fast").addClass("w-i");
		jQuery('.textwidget:first', this).removeClass('first')
		jQuery('.textwidget.text', this).each(function(){
			jQuery(this).removeClass('text').addClass('children');
			jQuery('.info', this).each(function () {
				jQuery(this).wrap("<div class='widget-info'></div>");
			});						
			jQuery('.textwidget-photo', this).each(function() {
				jQuery(this).clone(true).prependTo(jQuery(this).parent(".textwidget").find(".widget-info"))
			});
			jQuery('.widget-info .info a.button', this).removeClass("button").addClass('details');
		});
		portfolio_add_zoom( jQuery('.widget-info', this) );
	});
	return false;
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function grid_to_list() {
	$(".gallery-inner").fadeOut("fast", function() {
		$(this).fadeIn("fast").addClass("t-l");
		$('.textwidget:first', this).addClass('first')
		$('.textwidget', this).each(function(){			
			$(this).addClass('text')
			$(this).append( $('.widget-info > .info', this))
			$('.widget-info', this).remove();
			$('.info a.details', this).removeClass("details").addClass('button')				
		});
	});	
	return false;
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function add_hover_effect( element ) {
	if( typeof element == 'string' ) {
		element = jQuery(element);
	}

	if( (typeof arguments[1] == 'undefined') || arguments[1] ) {

		element.append('<i class="fade"></i>');

	};
	
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function isiPhone(){
	return (
		(navigator.platform.indexOf("iPhone") != -1) ||
		(navigator.platform.indexOf("iPod") != -1)
	);
}
if(isiPhone()) {
	jQuery('.fluid-width-video-wrapper').addClass('ip');
}
else{
	jQuery('.fluid-width-video-wrapper').removeClass('ip');
};
function add_i_height() {
	if(typeof doHover == 'function') {
		doHover();
	}
	jQuery(".textwidget-photo a.photo").each(function () {
		var im = jQuery(this).find("img"),
			im_h = im.height(),
			im_w = im.width(),
			myIm_h = parseInt(im_h),
			myIm_w = parseInt(im_w);
			
	jQuery(this).next('.form-protect').css({
			'height': im_h, 
			'width': im_w
		});
		var form_w = jQuery(this).next('.form-protect').width();
		if(form_w < 230){
			jQuery(this).next('.form-protect').addClass('fourth')
		}
		else{
			jQuery(this).next('.form-protect').removeClass('fourth')
		}	
	});
	
	if(typeof hoverArrows == 'function') {
		hoverArrows();
	}
	//hoverArrowsSmall();
	
	jQuery('.textwidget-photo').each(function () {
		if(jQuery('.form-protect', this).length){
			jQuery(this).addClass('protect')
		}else{
			jQuery(this).removeClass('protect')
		}
		  var $span = jQuery('.form-protect', this);
		 if (jQuery.browser.msie && jQuery.browser.version < 9)
			$span.hide();
		 else
			$span.css('opacity', 0);
		  jQuery(this).hover(function () {
			  
			if (jQuery.browser.msie && jQuery.browser.version < 9)
			  $span.show();
			else
			$span.stop().fadeTo(500, 1);
		  }, function () {
			if (jQuery.browser.msie && jQuery.browser.version < 9)
			  $span.hide();
			else
			  $span.stop().fadeTo(500, 0);
		  });
		});
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function portfolio_add_cufon() {
	jQuery('.textwidget .info .head').each(function(){
		jQuery(this).clone().prependTo(jQuery(this).parent()).removeClass("head").addClass("hide-me");
	})		
	/*cufon_in_gall();*/
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// dt ajax object
function DT_PAGE_AJAX() {
	var used_hash = '';
	
	this.parse_hash = function( hash ) {
		if( -1 == hash.search(/\//) )
			return null;

		hash_arr = hash.split('/');
		
		if( hash_arr.length != 3 )
			return null;

		return hash_arr;
	}

	this.do_ajax = function( hash ) {
	
		// Some preloading stuff by Miroslav
		var loading_label = null;
		
		if (jQuery("#loading-label").length < 1) {
			loading_label = jQuery("<div></div>").attr("id", "loading-label").addClass("loading-label").css("position" , "fixed").hide().appendTo("body");
		} else {
			loading_label = jQuery("#loading-label");
		}
		
		loading_label.fadeIn(250);
	
		hash = hash.slice(1);
		
		if( used_hash == hash ) {
			return false;
		}
		
		used_hash = hash;
		
		var cat_id = '', page = 1, layout = 'list';
		
		var hash_arr = this.parse_hash(hash);
		if( hash_arr ) {
			cat_id = hash_arr[0];
			page = hash_arr[1];
			layout = hash_arr[2]; 
		}else
			return false;

		jQuery('.dt-ajax-content').load( dt_ajax.ajaxurl, {
			action:         'dt_post_type_do_ajax',
			cat_id:         cat_id,
			paged:          page,
			post_id:        dt_ajax.post_id,
			layout:         layout,
			page_layout:    dt_ajax.page_layout,
			nonce:          dt_ajax.nonce 
		}, function( response ) {
			if( jQuery(this).parent().next().is('#nav-above') )
				jQuery(this).parent().next().detach();	
			// Danil you are showing Alla not very nice code: where is your "{}"
			// At least keep all the code on the same line...
			jQuery('#nav-above', jQuery(this)).insertAfter(jQuery(this).parent());
			widget_add_hover();
			loading_label.fadeOut(500);
			
			portfolio_add_cufon();
			jQuery(window).attachHs();
			preloadAjaxImages();
			add_hover_effect(jQuery('a.photo ', this));
			if ( 'grid' == layout ) {
				jQuery(this).addClass("w-i");
				portfolio_add_zoom( jQuery('.widget-info', this) );
			};
			add_i_height();
		});
  
	}
};
window.doSize = function(){	
		
		var funcObject = arguments.callee,
			$container = jQuery( '#container' );
		
		if ( typeof funcObject.dtHasSidebar == 'undefined' ) {
			
			if ( $container.hasClass( 'full-width' ) ) {
				funcObject.dtHasSidebar = false;
			} else {
				funcObject.dtHasSidebar = true;
			}
		}

		//size for hovers
		jQuery('a.img-frame, a.alignleft, a.alignright, a.alignnone, a.photo, .alignleft-f, .gallery-item a').each(function () {				  
			var i=jQuery(this).find("img");
			var i_w = i.width();
			var i_h = i.height();
			jQuery('i.fade', this).css('width', i_w);
			jQuery('i.fade', this).css('height', i_h-3);
		});
		/*Carousel height*/

		var wrap=jQuery('.caroufredsel_wrapper ul').find(" > img");
		var h_wrap = wrap.height();	
		jQuery(this).css('height', h_wrap); //'.caroufredsel_wrapper'
		
	
		//make width container
		
		if( notResponsive == 0 ) {
			jQuery('body').removeClass('not-responsive');
			if ( window.innerWidth < 1006 ) {
				if ( $container.hasClass( 'full-width' ) ) {
					$container.removeClass( 'full-width' );
				}
			}
			else if( ! funcObject.dtHasSidebar ) {
				if( ! $container.hasClass( 'full-width' ) ) {
					$container.addClass( 'full-width' );
				}
			}
			
//			if(jQuery('#container').next('#aside').length || jQuery('#container').prev('#aside').length) {
/*			if( funcObject.dtHasSidebar ) {
				jQuery('#container').removeClass('full-width')
			}
*/			
			//move soc-ico

			if(window.innerWidth < 1006){
				jQuery(".contact-block").appendTo('#header');
				jQuery(".soc-ico").css({'visibility':'visible'});
			}
			else{
				jQuery(".contact-block").appendTo('.top-cont');
				jQuery(".soc-ico").css({'visibility':'visible'});
			}
			return false;	
		}else {
			jQuery('body').addClass('not-responsive');			
			//return false;
			
		}
	};
jQuery(window).bind("popstate", function() {
	doSize();
	//jQuery(window).trigger('resize');
});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
var dt_pajax_obj = new DT_PAGE_AJAX();

function dt_change_layout_hash() {
	var cur_hash = dt_pajax_obj.parse_hash(window.location.hash.slice(1));
	jQuery('.navig-category').children('.categ').each( function() {
		href = jQuery(this).attr('href').split('#');
		if( href && href.length == 2 ) {
			hash = dt_pajax_obj.parse_hash(href[1]);
			if( (hash && hash.length == 3) && (cur_hash && cur_hash.length == 3) ) {
				hash[0] = cur_hash[0];
				hash[1] = cur_hash[1];
				href[1] = hash.join('/');
				jQuery(this).attr('href', href.join('#'));
			}
		}
	});
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function dt_change_pagination_hash() {
	var cur_hash = dt_pajax_obj.parse_hash(window.location.hash.slice(1));
	jQuery('#nav-above').find('a').each( function() {
		href = jQuery(this).attr('href').split('#');
		if( href && href.length == 2 ) {
			hash = dt_pajax_obj.parse_hash(href[1]);
			if( (hash && hash.length == 3) && (cur_hash && cur_hash.length == 3) ) {
				hash[2] = cur_hash[2];
				hash[0] = cur_hash[0];
				href[1] = hash.join('/');
				jQuery(this).attr('href', href.join('#'));
			}
		}
	});
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function dt_replace( old_data, new_data ) {
	if( typeof old_data == 'array' && typeof new_data == 'array' ) {
		for( i=0;i<old_data.length;i++) {
			if( typeof new_data[i] != 'undefined' ) {
				old_data[i] = new_data[i];
			}
		}
	}else {
		old_data = new_data;
	}
	return old_data;
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function dt_change_navigation_hash() {
	var cur_hash = dt_pajax_obj.parse_hash(window.location.hash.slice(1));
	jQuery('.navig-category a.button').each( function() {
		href = jQuery(this).attr('href').split('#');
		if( href && href.length == 2 ) {
			hash = dt_pajax_obj.parse_hash(href[1]);
			if( (hash && hash.length == 3) && (cur_hash && cur_hash.length == 3) ) {
				hash[2] = cur_hash[2];
				href[1] = hash.join('/');
				jQuery(this).attr('href', href.join('#'));
			}
		}
	});
};
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function dt_portfolio_ajax() {    
	var holder = jQuery('.navig-category');
	var hash_orig;

	window.onhashchange = function() {
//        showBlackLoader();

		dt_change_layout_hash();
		dt_change_pagination_hash();
		dt_change_navigation_hash();

		dt_pajax_obj.do_ajax( window.location.hash );
	};

	if( !window.location.hash ) {
		var btn_href = holder.children('.categ.act').attr('href');
		var layout = 'list';
		if( btn_href ) {
			btn_href = btn_href.split('#');
			if( btn_href[1] ) {
				layout = dt_pajax_obj.parse_hash(btn_href[1]);
				layout = layout[2];
			}
		}else if( dt_ajax.layout ) {
			layout = dt_ajax.layout;
		}

		window.location.hash = 'all/1/' + layout;
	}
	window.onhashchange();
		
	hash_orig = dt_pajax_obj.parse_hash(window.location.hash);
	
	holder.find('a.button').not('.categ').each(function(){
		if( hash_orig && (-1 != jQuery(this).attr('href').search(hash_orig[0])) ) {
			holder.find(".but-wrap a.button").not('.categ').removeClass("act");
			holder.find(".but-wrap").removeClass("act");
			jQuery(this).parent().addClass("act");
		}
		
		jQuery(this).on('click', function(){
			
			if( jQuery(this).parent().hasClass('act') ) {
				return false;
			}
			
			// reassign act class properly
			holder.find(".but-wrap.act a.button").not('.categ').removeClass("act");
			holder.find(".but-wrap.act").not('.categ').removeClass("act");
			jQuery(this).parent().addClass("act");
		});
	});

	// remove window.onhashchange handler wen layout switcher is clicked
	holder.find('.categ').each( function() {
		if( hash_orig && (-1 != jQuery(this).attr('href').search(hash_orig[2])) ) {
			holder.find(".categ.act").removeClass("act");
			jQuery(this).addClass("act");
		}
		
		jQuery(this).on('click', function(e) {
			if( jQuery(this).hasClass('act') ) {
				return false;
			}
			e.preventDefault();
			window.location.hash = '#'+jQuery(this).attr('href').split('#')[1];

			// reassign act class properly
			holder.find("a.categ.act").removeClass("act");
			jQuery(this).addClass("act");
			return false;
		}); 
	});
	

};// dt_portfolio_ajax end

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function() {

	if( jQuery('.dt-ajax-content').length ) {
		dt_portfolio_ajax();
	}

	if( jQuery('#comments .comments-container').length ) {
		jQuery('#comments .comments-container').find('.children').each(function() {
			jQuery(this).children('.comment:last').addClass('last');
		});
	}

});

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//hover arrow
jQuery(document).ready(function($){

	window.theTest = 0;
	window.hoverArrows = function() {

		$('.prev, .nivo-prevNav, #carousel-left, .flex-prev, .jfancytileBack').hover(
			function() {
				var $this	= $(this),
					$front	= $this.find('span.a-l'),
					$back	= $this.find('span.a-r').show();

				if($this.is(".temp_disabled") || $this.is(".disabled")) return;
	
				$front.stop().animate({			
					"margin-left": "-2px"
				}, 200);
				$back.stop().animate({				
					"margin-left": "2px"
				}, 200);

			}, function() {

				var $this	= $(this),
					$front	= $this.find('span.a-l'),
					$back	= $this.find('span.a-r');

				$front.stop().animate({				
					"margin-left": 0
				}, 150);

				$back.stop().animate({				
					"margin-left": 0
				}, 150, function() {
					$back.hide();
				});

			}
		);


		$('.next, .nivo-nextNav, #carousel-right, .flex-next, .jfancytileForward').hover(
			function() {

				var $this	= $(this),
					$front	= $this.find('span.a-l'),
					$back	= $this.find('span.a-r').show();

				if($this.is(".temp_disabled") || $this.is(".disabled")) return;

				$front.stop().animate({			
					"margin-left": "2px"
				}, 200);
				$back.stop().animate({				
					"margin-left": "-2px"
				}, 200);

			}, function() {

				var $this	= $(this),
					$front	= $this.find('span.a-l'),
					$back	= $this.find('span.a-r');

				$front.stop().animate({				
					"margin-left": 0
				}, 150);

				$back.stop().animate({				
					"margin-left": 0
				}, 150, function() {
					$back.hide();
				});

			}
		);

			
			$('.list-carousel .prev, .coda-nav-right').not('.no-act').hover(function(){
			$(this).find('span.a-l-s').animate({				
				left: "4px"
			},{queue:false,duration:200});

			$(this).find('span.a-r-s').fadeIn('fast').animate({				
				left: "0px"
			},{queue:false,duration:200});

	
			}, function(){
				$(this).find('span.a-l-s').animate({				
					left: "2px"
				},{queue:false,duration:200});
				$(this).find('span.a-r-s').fadeOut('fast').animate({				
					left: "2px"
				},{queue:false,duration:200});			
			});
		
			$('.list-carousel .next, .coda-nav-left').not('.no-act').hover(function(){
				
				$(this).find('span.a-l-s').animate({				
					left: "0px"
				},{queue:false,duration:200});
				$(this).find('span.a-r-s').fadeIn('fast').animate({				
					left: "4px"
				},{queue:false,duration:200});
				
			}, function(){
				$(this).find('span.a-l-s').animate({				
					left: "2px"
				},{queue:false,duration:200});
				
				$(this).find('span.a-r-s').fadeOut('fast').animate({				
					left: "2px"
				},{queue:false,duration:200});
				
			});
			
			$('.paginator-r a.prev, .SliderNamePrev').hover(
			function() {
	
				var $this	= $(this),
					$front	= $this.find('span.a-l-s'),
					$back	= $this.find('span.a-r-s').show();

				if($this.is(".temp_disabled") || $this.is(".disabled") ||  $this.is(".no-act")) return;
	
				$front.stop().animate({			
					"margin-left": "-2px"
				}, 200);
				$back.stop().animate({				
					"margin-left": "2px"
				}, 200);

			}, function() {

				var $this	= $(this),
					$front	= $this.find('span.a-l-s'),
					$back	= $this.find('span.a-r-s');

				$front.stop().animate({				
					"margin-left": 0
				}, 150);

				$back.stop().animate({				
					"margin-left": 0
				}, 150, function() {
					$back.hide();
				});

			}
		);


		$('.paginator-r a.next, .SliderNameNext').hover(
			function() {

				var $this	= $(this),
					$front	= $this.find('span.a-l-s'),
					$back	= $this.find('span.a-r-s').show();

				if($this.is(".temp_disabled") || $this.is(".disabled") ||  $this.is(".no-act")) return;

				$front.stop().animate({			
					"margin-left": "2px"
				}, 200);
				$back.stop().animate({				
					"margin-left": "-2px"
				}, 200);

			}, function() {

				var $this	= $(this),
					$front	= $this.find('span.a-l-s'),
					$back	= $this.find('span.a-r-s');

				$front.stop().animate({				
					"margin-left": 0
				}, 150);

				$back.stop().animate({				
					"margin-left": 0
				}, 150, function() {
					$back.hide();
				});

			}
		);
			
		
	};

	hoverArrows();

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	//arrow for list-carousel
	$("<span class='a-l-s'>&#8249;</span><span class='a-r-s'>&#8249;</span>").appendTo(".list-carousel .next, .SliderNamePrev");	
	$("<span class='a-l-s'>	&#8250;</span><span class='a-r-s'>	&#8250;</span>").appendTo(".list-carousel .prev, .SliderNameNext");

/*	
	$("<span class='a-l-s'>&#8249;</span><span class='a-r-s'>&#8249;</span>").appendTo(".paginator-r .prev");	
	$("<span class='a-l-s'>&#8250;</span><span class='a-r-s'>&#8250;</span>").appendTo(".paginator-r .next");
*/
	
});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// change appereance on resize 

jQuery( function($) {
	
	if($('#aside').hasClass('left')){
		$('#container').addClass('right')
	}
	else{
		$('#container').removeClass('right')
	};
	//responsive
	$(window).bind('orientationchange', function(event) {
 
		doSize();
		//$(window).trigger("resize");
	});
	//**********************************************************************************************************************************************
	
	function isiPhone(){
		return (
			(navigator.platform.indexOf("iPhone") != -1) ||
			(navigator.platform.indexOf("iPod") != -1)
		);
	};
	var resizeTimeout = false;
	$(window).on("resize", function() {
		clearTimeout(resizeTimeout);
		resizeTimeout = setTimeout(function() {
			dtStorage.resizeCounter++;
			if ($(window).width() == dtStorage.theWidth) return false;
			
			dtStorage.theWidth = $(window).width()
			
			$("#nav").find('> li').each(function () {
				var $this = $(this);
				var nav_right     = $("#header").innerWidth() - ( ($this.offset().left -$("#header").offset().left) - $this.width());
				
				if(nav_right < 220 ){
					$(this).addClass('nav-left');			
				}else if(nav_right < 242){
					$(this).addClass('nav-div-left');
				}else{
					$(this).removeClass('nav-left').removeClass('nav-div-left');
				}
			});
			//hoverArrows();
			//hoverArrowsSmall();
			//hSlider();
			$('.widget-info').hide();
			$(".textwidget-photo a").removeClass("is-clicked");	
			if(agentID || isAndroid || isiPhone){}
			else {
				doHover(); // 2review
			};
			doSize();
						
			//Call to action width
			$('.about-cont').each(function(){
				if($('.but-wrap', this).length){
					$('.about-iiner', this).css({
						'maxWidth':$(this).width() - $('.but-wrap', this).width() - 16
					});
				}
				else{
					$('.about-iiner', this).css({
						'maxWidth':100 + '%'
					});
				};
			});
			/*****************************************************************************/
			//widget popular posts
			$('.post-bg').each(function(){
				var post_w = $(this).width();
				var img = $(this).find('img');
				var img_w = img.attr('width');
				$('.post-inner', this).css({
					width: post_w - img_w - 21
				});
			});
			/****************************************************************************/

			//max-width for soc-ico
			$('.soc-ico').css({
				'max-width' : $('.top-cont').width() - $('.right-top').width() - 20 +'px',
				'visibility':'visible'
			})
			var inner_w = $('.inner-navig').width();
			if(('.inner-navig').length){
				$('#container > h1').css({
					'maxWidth':$('#container').width() - 40 - inner_w
				});
			}
			else{
			};

			$(".slider-shortcode").each(function () {
				var im=$(this).find("img");
				var im_w = $(this).width();
				var im_h = im.height();
			
				$('.html-caption', this).css({
					'width': im_w -36
				}).show()

			});
			var winHeight = window.innerHeight ? window.innerHeight : $(window).height();
			if( winHeight < 300 ){
				
				$('.menu-wrap').css({
					height: $('.mobile-menu').height() - 40,
					'minHeight': winHeight - 40
				});
				$('.menu-container').css({
					'paddingBottom': 80
				});
				
			} else {
				$('.menu-wrap').css({
					height: $('.mobile-menu').height() - 40,
					'minHeight': winHeight - 40
				});
				
				$('.menu-container').css({
					'paddingBottom': 20
				});
			};
			
			if(dtStorage.resizeCounter > 1){
				if ( $('.slider1').length > 0 ){
					$('.slider1').each(function() {
						$(this).data("carousel").reloadShow();
					});
				};
				
				if ( $('.sliderBx').length > 0 ){
					$('.sliderBx').each(function() {
						$(this).data("carousel").reloadShow();
					});
				};
			};
			
		}, 300);
	});

});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//mobile menu

jQuery.extend(jQuery.browser,
 {SafariMobile : navigator.userAgent.toLowerCase().match(/iP(hone|ad)/i) }
);

jQuery(function($){
	/*if ($.browser.SafariMobile){
		
			$(window).on("orientationchange",  function() {			
				
				setTimeout(scrollTo, 0, 0, 1);
				$(window).trigger("resize");
			
			}).trigger("orientationchange");

			setTimeout( function() {$(window).trigger("orientationchange");}, 3000);	
		}*/
	//Hide overlay and mobile menu
	$('.overlay').animate({
		opacity: 0 }, 400, function() {
	});
	$('.mobile-menu ').animate({
		top: '-10000px' }, 800, function() {
	});
	//*************************************************
	/*
	if( isAndroid ){
		$('.mobile-menu .cross').removeClass('dt-posit');
	}else{		
		$('.mobile-menu .cross').addClass('dt-posit');
	}*/
	
	//Click on menu button
	$('#main-menu .button').on('click', function(e){
		if( dtStorage.isAndroid ){			
			$("body").addClass('dt-mob-andr');
		}else{
			$("body").removeClass('dt-mob-andr');
		};

		$('.mobile-menu ').css('display', 'block');
		$('nav').css('display', 'none');		

		e.preventDefault();
		$('html').addClass('no-scroll');
			
		$('.overlay').show().animate({ 
			opacity: 1 }, 400, function() {
		});

		$('.mobile-menu ').animate({
			top: '0px' }, 800, function() {

			/*if( dtStorage.isiPhone ){
				$(window).bind('orientationchange resize', function(event){
					window.scrollTo(0, 0);
				});	
			};*/

			dtStorage.ul_menu_h = $('.menu-container').height();
			if( dtStorage.isiPad){
				//html.onscroll = function() { alert("Scrolled html"); };
				$(window).on('scroll', function(e){
					e.stopPropagation();
					$scrollTarget = $(e.target);
					if ( dtStorage.ul_menu_h < $(window).height()) {
						e.preventDefault();
						return;
					};
				});
			};

			//Prevent for body scroll
			if( dtStorage.isiPad){
				$(window).on('scroll',function(e){
					$scrollTarget = $(e.target);
					if ($('.overlay').has($scrollTarget).length) {
						e.preventDefault();
						return;
					};
					/*$('.overlay').on('touchstart', function(e){
						e.preventDefault();
						e.stopPropagation();
					});*/
				});
				$(window).on('scroll', function(e){
					//e.stopPropagation();
					$scrollTarget = $(e.target);
					if (!($scrollTarget.parents(".menu-wrap").length > 0)) {
						e.preventDefault();
						return;
					};

				});
			};

			/*if( dtStorage.isiPhone ){
				$(window).bind('orientationchange resize', function(event){
					window.scrollTo(0, 0);
				});	
			};*/
		});

		$('.menu-wrap').css({
			height: $('.mobile-menu').height() - 40
		});

		
	});
	//$(window).unbind('scrollstart');
	//Close mobile menu
	$('.mobile-menu .cross, .overlay').on('click, tap', function(){
		$('html').removeClass('no-scroll');
		//alert('cross click')
		$('nav').css('display', 'block');
		$('.overlay').animate({ 
			opacity: 0}, 800, function() {
		});
		$('.mobile-menu').animate({
			top:'-10000px' }, 800, function() {
				if( dtStorage.isiPad){
					$(window).unbind('scroll');
				}
		});
		setTimeout(function(){			 
			$('.overlay').hide();
		},1000);
	});
	$('.mobile-menu .cross').on('tap', function(){
		//alert('cross tap')
	});
	//Add class children
	$('.menu-container').find('li').each(function(){
		var $_this = $(this);
		if ($_this.find("div").length > 0) {
			$_this.addClass('children');
		}
		else{
			$_this.removeClass('children');
		};
	});
	//Append elements
	$('<span class="toggle-ico"></span>').insertAfter('.menu-container li.children > a');
	$('<i class="current-ico">&#10004;</i>').insertAfter('.menu-container a.current-menu-item span.inner-item');
	
	//Add class act for li
	$(".menu-container").find(' li.children').each(function () {
		var $_this = $(this);
		if($_this.children('a').hasClass('act')){
			$_this.addClass('act');
		}
		else{
			$_this.removeClass('act');
		};

		$(".menu-container li a.act").siblings('div').css('display','block');		
		
		if($_this.hasClass('act')){			
			$_this.children('.toggle-ico').removeClass('plus').addClass('minus');
		}
		else{
			$_this.children('.toggle-ico').removeClass('minus').addClass('plus');
		};		
	});

	//Show-hide sub menu
	$(".menu-container li").find(' .toggle-ico').each(function () {
		var $_this = $(this);
		$_this.on('click', function() {
			if($_this.hasClass('minus')) {
				$_this.siblings('div').stop(true, true).slideUp(300, function(){dtStorage.ul_menu_h = $('.menu-container').height();});
				$_this.parent().removeClass('act');
				$_this.removeClass('minus').addClass('plus');
			}
			else{
				$_this.parent('li').addClass('act');		
				$_this.siblings('div').stop(true, true).slideDown(800, function(){dtStorage.ul_menu_h = $('.menu-container').height();});
				$_this.removeClass('plus').addClass('minus');
			};
		});
	});

	//Click
	$('.menu-container').find('li.children > a').each(function() {
		
		var $this = $(this);
		$(".menu-container li a.act").next('div').css('display','block');
		$this.on('click', function(e) {
			if($(this).hasClass('click-auto')){
				if($this.parent().hasClass('act')){
						return false;							
				}
				else{
					e.preventDefault();
					$this.parent().addClass('act');		
					$this.siblings('div').stop(true, true).slideDown(800, function(){dtStorage.ul_menu_h = $('.menu-container').height();});					
					$this.siblings('.toggle-ico').removeClass('plus').addClass('minus');
					$this.bind('click', function(){
							return false;
					});	
				};
			}
			else{
				if($this.parent().hasClass('act')){
						window.location = this.href;
							return false;							
				}
				else{
					e.preventDefault();
					$this.parent().addClass('act');		
					$this.siblings('div').stop(true, true).slideDown(800, function(){dtStorage.ul_menu_h = $('.menu-container').height();});					
					$this.siblings('.toggle-ico').removeClass('plus').addClass('minus');
					$this.bind('click', function(){
						window.location = this.href;
							return false;
					});	
				};
			};
		});		
	});

//scroll for iphone android
	var ua = navigator.userAgent.toLowerCase();
	var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
	
	if( dtStorage.isiPad || dtStorage.isiPhone ){

		$('.menu-wrap').addClass('trans-z').css({'-webkit-overflow-scrolling': 'touch'});		

	}else if( isAndroid ){
		jQuery('.overlay-mask').css('display', 'none')
		jQuery.fn.oneFingerScroll = function() {
			var scrollStartPos = 0;
			$(this).bind('touchstart', function(event) {				
				// jQuery clones events, but only with a limited number of properties for perf reasons. Need the original event to get 'touches'
				var e = event.originalEvent;
				scrollStartPos = $(this).scrollTop() + e.touches[0].pageY;
				//e.preventDefault();
			});
		
			$(this).bind('touchmove', function(event) {
				
				var e = event.originalEvent;
				$(this).scrollTop(scrollStartPos - e.touches[0].pageY );
				e.preventDefault();
			});
			return this;
		};
		$('.menu-wrap').oneFingerScroll();
		//usage
	}else{$('.menu-wrap').removeClass('trans-z');};	
	
	//**************************************************************************************************	
	//Position fixed for menu button

	if($.browser.msie && $.browser.version < 9){
	}else{
		var sticky = document.querySelector('#main-menu');
		var origOffsetY = 150;

		function onScroll(e) {		

			//$('#main-menu').stop(true, true).fadeOut();

			if( window.scrollY >= 70 && window.scrollY < origOffsetY  ){

				$('#main-menu').css({'opacity': 0});
		        sticky.classList.remove('fixed');

			}else if( window.scrollY >= origOffsetY ){

				sticky.classList.add('fixed');
				$('#main-menu').css({'opacity': 1});

			}else{
				$('#main-menu').removeClass("big-blue");
		        sticky.classList.remove('fixed');
				
				$('#main-menu').css({'opacity': 1});

		    };

		};

		document.addEventListener('scroll', onScroll);
	}
});

//**************************************************************************************************	
jQuery(function($) {
	$(window).trigger("resize");
	preloadImages();
});