// © Dream-Theme.com

(function($) {

	$.fn.exists = function() {
		if ($(this).length > 0) {
			return true;
		} else {
			return false;
		}
	}

	$.fn.loaded = function(callback, jointCallback, ensureCallback){
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
	
})(jQuery);

(function($) {
	$.widget("dt.imgScale", {

		options	: {
			viewport	: false,
			filter		: false,
			
			landscape	: "fill",
			portrait	: "vertically"
		},

		_create	: function() {
			var base	= this;

			base.$viewport	= base.options.viewport ? $(base.options.viewport) : $(base.element);
			base.filter		= base.options.filter || "img";

			base.elements	= base.element.find(this.filter);
			if (base.elements.length < 1) return;
		},


		_init	: function() {
			this._doScale();
		},


/*
		destroy	: function() {
			alert("destroy");
			//$.Widget.prototype.destroy.call(this);
		},
*/


		_setData		: function(el, $el, callback) {
			var el 		= el,
				$el 	= $el,
				data	= $el.data("dt");
				
			if(!data && el.complete) {
				$el.data("dt", {
					"ratio"		: (el.width/el.height).toFixed(2)
				});
				callback.call($el);
			} else if (!data && !el.complete) {
				$el.loaded(function() {
					$el.data("dt", {
						"ratio"		: (el.width/el.height).toFixed(2)
					});
					callback.call($el);
				});
			} else if (data) {
				callback.call($el);
			}
		},
		
		_doScale		: function() {

			function scaleHorizontally($el) {
				var imgRatio = $el.data("dt").ratio;

				$el.css({
					//"width"		: "100%",
					//"height"	: "auto",
					"width"		: base.viewportWidth,
					"height"	: (base.viewportWidth/imgRatio),
					"left"		: 0,
					"top"		: (base.viewportHeight - (base.viewportWidth/imgRatio))/2
				});
			}

			function scaleVertically($el) {
				var imgRatio = $el.data("dt").ratio;

				$el.css({
					//"width"		: "auto",
					//"height"	: "100%",
					"width"		: (base.viewportHeight*imgRatio),
					"height"	: base.viewportHeight,
					"left"		: (base.viewportWidth - (base.viewportHeight*imgRatio))/2,
					"top"		: 0
				});			
			}

			function scalingMethod(method, $el) {
				var imgRatio = $el.data("dt").ratio;

				switch(method) {

					case "horizontally":
						scaleHorizontally($el);
						break;

					case "vertically":
						scaleVertically($el);
						break;

					case "fill":
						if(base.viewportRatio > imgRatio) {
							scaleHorizontally($el);
						}
						else if(base.viewportRatio <= imgRatio) {
							scaleVertically($el);
						}
						break;

					case "fit":
					default:
						if(base.viewportRatio <= imgRatio) {
							scaleHorizontally($el);
						}
						else if(base.viewportRatio > imgRatio) {
							scaleVertically($el);
						}
						break;
				}
			};


			var base = this;

			// viewport 
			base.viewportWidth	= base.$viewport.width();
			base.viewportHeight	= base.$viewport.height();
			base.viewportRatio	= (base.viewportWidth/base.viewportHeight).toFixed(2);

			base.elements.each(function(i) {
					
				var el	= this,
					$el	= $(el);

				base._setData(el, $el, function() {

					// image
					var	$el			= this,
						imgRatio	= $el.data("dt").ratio;
		
					// Apply proper sizing methods for vertical and horizontal photos
					if (imgRatio > 1) {
						// Landscape images
						scalingMethod(base.options.landscape, $el);
					}
					else if (imgRatio <= 1) {
						// Portrait and square images
						scalingMethod(base.options.portrait, $el);
					}
				});

			});

		}

	});
}(jQuery));



jQuery(function($) {

	var loading_label = jQuery("<div></div>").attr("id", "loading-label").addClass("loading-label").css("position" , "fixed").hide().appendTo("body");
	loading_label.fadeIn(250);
	
	var win				= $(window),
		base			= $(".fs-slideshow"),
		options			= {};
		
	options.spacing		= parseInt(base.attr("data-spacing")) || 0;
	options.height		= parseInt(base.attr("data-height")) || 0;
	options.autoslideOn	= parseInt(base.attr("data-autoslide_on")) || 0;
	options.autoslide	= parseInt(base.attr("data-autoslide")) || 0;
	options.overlay		= parseInt(base.attr("data-overlay")) || 0;

	if (options.height > 0 && options.height < 160) options.height = 160;
	if (options.autoslide > 0 && options.autoslide < 1500) options.autoslide = 1500;
		
	var	slides		= base.find("li"),
		count		= slides.length,
		curr		= 0,
		prev		= 0,
		next		= 0;

	var currSlide 			= false,
		currSlideImg 		= false,
		currSlideCaption 	= false,
		currSlideLink 		= false;

	var	nextSlide 			= false,
		nextSlideImg 		= false,
		nextSlideCaption 	= false,
		nextSlideLink 		= false;

	var	prevSlide 			= false,
		prevSlideImg 		= false,
		prevSlideCaption 	= false,
		prevSlideLink 		= false;
		
	var winResizeTimeout	= false,
		auroslideTimeout	= false,	
		focusOnSlider		= false;


	function setSlides() {
	
		if (prev != curr) {
			prev				= curr;
			prevSlide			= currSlide;
			prevSlideImg		= currSlideImg;
			prevSlideCaption	= currSlideCaption;
			prevSlideLink		= currSlideLink;
		}

		curr = (curr >= count) ? 0 : curr;
		curr = (curr < 0) ? count - 1 : curr;
		next = (curr + 1) >= count ? 0 : curr + 1;
		//prev = (curr - 1) < 0 ? count - 1 : curr - 1;
	
		currSlide			= slides.eq(curr);
		currSlideImg		= currSlide.find("img");
		currSlideCaption	= currSlide.find(".fs-caption");
		currSlideLink		= currSlide.find(".fs-link");
		
		nextSlide			= slides.eq(next);
		nextSlideImg		= nextSlide.find("img");
		nextSlideCaption	= nextSlide.find(".fs-caption");
		nextSlideLink		= nextSlide.find(".fs-link");
	}
	
	function changeSlides() {
	
		clearTimeout(auroslideTimeout);
		setSlides();

		if (prevSlide.exists) {
			prevSlide.delay(200).fadeOut(1000, function() {
				prevSlideCaption.css("left", "-280px");
				prevSlideLink.hide();
				prevSlideImg.hide(); // Hide image to improve performance
			});
		}

		currSlideImg.show();
		currSlide.fadeIn(1000);
		currSlideCaption
			.delay(800)
			.css({
				marginTop : -currSlideCaption.outerHeight()/2 + "px"
			})
			.animate({"left":0}, 400, "easeOutQuad");
		currSlideLink.delay(1400).fadeIn(400);
		
		if (count < 2) return;
		
		if (options.autoslideOn) {
			auroslideTimeout = setTimeout(function() {
				curr++;
				changeSlides();
			}, options.autoslide);
		}
	}


	// Let's begin
	if (options.overlay) {
		slides.prepend('<div class="fs-overlay" />');
	}
	slides.hide().css("visibility", "visible");
	slides.find("img").hide().css("visibility", "visible");
	setSlides();

	// Bind resize
	win.on("resize", function() {
		clearTimeout(winResizeTimeout);

		winResizeTimeout = setTimeout(function() {
			var	baseOffset		= base.offset(),
				winHeight		= window.innerHeight ? window.innerHeight : win.height(),
				sliderHeight	= winHeight - baseOffset.top - options.spacing;
				
			if ($("#page").hasClass("boxed") && $("body").hasClass("fs-no-footer") && (win.width() > 1149)) {
				sliderHeight = sliderHeight - 30;
			}
			
			if (sliderHeight < winHeight * 1 / 2) {
				sliderHeight = winHeight;
				focusOnSlider = true;
			} else {
				focusOnSlider = false;
			}
			
			if (options.height > 0) sliderHeight = options.height - options.spacing;

			base.animate({
				height : sliderHeight + "px"
			}, 400, function() {
				base.imgScale({viewport : ".fs-slideshow"});
				currSlideImg.loaded(function() {
					if (count > 1) $(".fs-controls").fadeIn(250);
					loading_label.fadeOut(500);
					changeSlides();
				});
			});
		}, 300);

	}).trigger("resize");	


	// Hindle clicks on next/prev buttons and wipe events
	$(".go-next").on("click", function(e) {
		e.preventDefault();
		if (slides.is(":animated") || count < 2) return false;
		if (focusOnSlider) $("html"+( ! $.browser.opera ? ",body" : "")).animate({scrollTop: $(".fs-slideshow").offset().top}, 200);
		curr++;
		changeSlides();
	});

	$(".go-prev").on("click", function(e) {
		e.preventDefault();
		if (slides.is(":animated") || count < 2) return false;
		if (focusOnSlider) $("html"+( ! $.browser.opera ? ",body" : "")).animate({scrollTop: $(".fs-slideshow").offset().top}, 200);
		curr--;
		changeSlides();
	});

	base.touchwipe({
		wipeLeft: function() { $(".go-next").trigger("click"); },
		wipeRight: function() { $(".go-prev").trigger("click"); },
		min_move_x: 30,
		min_move_y: 20,
		preventDefaultEvents: false,
		dtPreventX: true
	});

	// Handle hovers on next/prev buttons
	$(".go-prev").hover(
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

	$(".go-next").hover(
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
	
});