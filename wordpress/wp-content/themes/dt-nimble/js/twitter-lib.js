function dtTwitterCarouFredseller( id ) {
	
	jQuery( document ).ready( function($) {
		var $this				= jQuery(id),		
			autoslideOn			= $this.attr("data-autoslide_on") || 0,
			autoslideInterval	= parseInt($this.attr("data-autoslide") || 7000);	
			
			if(autoslideOn == "0") {
				autoslideOn = false;
			} else if (autoslideOn == "1") {
				autoslideOn = true;
			}
			
			var mySlider = $this.bxSlider({
				displaySlideQty: 4,
				auto : autoslideOn,
				pause	: autoslideInterval,
				autoHover	: true,
				
				moveSlideQty: 1,
				onCallbackSlide: function() {},
				onAfterSlide: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
					$this.parents(".bx-window").css({
						height: currentSlideHtmlObject.height()
					});
				
				}
				
			});
		
			$this.data("carousel", mySlider);
		
		
		
		setTimeout( function() {
			$this.parents(".list-carousel").css({"overflow": "visible"});
		}, 800);
	});
}