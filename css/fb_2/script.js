
(function ($) {
//http://beta.thomasclausen.dk/facebook-wall/script.js
	$(document).ready(function () {
		$('html').removeClass('no-js');
		if ($.browser.safari || $.browser.webkit) {
			$('body').addClass('webkit');
		}

		$('#facebook-wall').facebook_wall({
			// id: '140239969347795',
			  id: '161697954025605', 
			  // id: '168566203164321',   //365 page
			 access_token: 'CAACEdEose0cBABbt1gqs4uxfPrDHCTnaBZAWD5ZA6MWbDlsCm0NROyuH9ynTdURsaRwgfVaMhZAM34ZAYAHtSrR5TUQC5x0tX2fPMP76kmzFcHFfbVZAZCV7mmLJel5Q6mMlPoUSUbTsOgUV3KnaDmfZCzYD9Gog08iuQ5of3HFuuZA81hZAUEUqL', //365 page
			 // access_token: 'CAACEdEose0cBABiurtTpwlOHUBSAZCaACdEdCMCyQgZCZBHfCDDd8OOorduRZC8cMsggOpkOC3FHVEqUnYfc2vmI2ch3QFMNemtjxoaOaDVvkkEZBUmUBLhTt4ESkfZAw3bZCCw0YYJD0jZBk1UEEiPhheJxYCTrDlISdRrW8wW5twu2rEVQfsYk',
			limit: 1
		});

		// https://graph.facebook.com/140239969347795/posts/?access_token=144647fb715576539|6KPR_qYlwciPZl3cKklibgVdZNg&limit=10&locale=da_DK&date_format=U

		if (window.location.hash) {
			var start_styling = window.location.hash;
			$('#facebook-wall').removeClass('standard alt1 alt2 alt3').addClass(start_styling.replace('#', ''));
			$('.styling-buttons').find('a[href=' + start_styling + ']').addClass('current').siblings().removeClass('current');
		}

		$('.styling-buttons a').click(function (e) {
			$(this).addClass('current').siblings().removeClass('current');
			var new_styling = $(this).attr('href').replace('#', '');
			$('#facebook-wall').removeClass('standard alt1 alt2 alt3').addClass(new_styling);
			e.preventDefault();
		});

		$(document).on('click', '#facebook-wall.alt2 li', function () {
			var media_height_img = $(this).find('.media img').outerHeight(),
                media_height_text = $(this).find('.media .media-meta').height(),
                media_height = (media_height_img > media_height_text) ? media_height_img : media_height_text;
            
			$(this).find('.media').css({
				backgroundImage: 'none',
				cursor: 'auto'
			}).animate({
				height: media_height,
				paddingTop: '10px',
				paddingBottom: '10px'
			}, 400, function () {
				$('*', this).animate({
					opacity: '1'
				}, 400);
			});
		});
	});
})(jQuery);