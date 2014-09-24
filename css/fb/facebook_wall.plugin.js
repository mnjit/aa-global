(function ($) {
	$.fn.facebook_wall = function (options) {
		if (options.id === undefined || options.access_token === undefined) {
			return;
		}

		options = $.extend({
			id: '',
			access_token: '',
			limit: 3, // You can also pass a custom limit as a parameter.
			timeout: 400,
			speed: 400,
			effect: 'slide', // slide | fade | none
			locale: 'en_IN', // your contry code
			date_engine: 'default', // default | moment.js
			date_format: 'dddd [d.] Do MMMM YYYY', // Format used in moment.js
			avatar_size: 'square', // square | small | normal | large
			message_length: 200, // Any amount you like. Above 0 shortens the message length
			show_guest_entries: false, // true | false
			text_labels: {
				shares: {
					singular: 'Shared % time',
					plural: 'Shared % times'
				},
				likes: {
					singular: '% like',
					plural: '% likes'
				},
				comments: {
					singular: '% comment',
					plural: '% comments'
				},
				like: 'like',
				comment: 'Write comment', 
				comment: '',
				share: 'Del',
				share: '',
                days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
			},
			on_complete: null
		}, options);

		var graphURL = 'https://graph.facebook.com/',
			graphTYPE = (options.show_guest_entries === false) ? 'posts' : 'feed',
			graphPOSTS = graphURL + options.id + '/' + graphTYPE + '/?access_token=' + options.access_token + '&limit=' + options.limit + '&locale=' + options.locale + '&date_format=U&callback=?',
			e = $(this);

		e.append('<div class="facebook-loading"></div>');

		$.getJSON(graphPOSTS, function (posts) {
			$.each(posts.data, function () {
				var output = '',
					post_class = '',
					media_class = '',
					split_id = '';

				if (this.is_hidden === undefined) {
					if (this.type === 'link') {
						post_class = 'type-link ';
					} else if (this.type === 'photo') {
						post_class = 'type-photo ';
					} else if (this.type === 'status') {
						post_class = 'type-status ';
					} else if (this.type === 'video') {
						post_class = 'type-video ';
					}
					//console.log(new Date(this.created_time).getTime());
					output += '<h4>FACEBOOK FEED</h4>';
					output += '<li class="post ' + post_class + 'avatar-size-' + options.avatar_size + '" data-datetime="' + new Date(this.created_time).getTime() + '">';
						output += '<div class="meta-header">';
							output += '<div class="avatar"><a href="http://www.facebook.com/profile.php?id=' + this.from.id + '" target="_blank" title="' + this.from.name + '"><img src="' + (graphURL + this.from.id + '/picture?type=' + options.avatar_size) + '" alt="' + this.from.name + '" /></a></div>';
							output += '<div class="author"><a href="http://www.facebook.com/profile.php?id=' + this.from.id + '" target="_blank" title="' + this.from.name + '">' + this.from.name + '</a></div>';
							output += '<time class="date" datetime="' + this.created_time + '" pubdate>' + timeToHuman(this.created_time) + '</time>';
						output += '</div>';

						/*console.log(this.likes !== undefined);
                        console.log(this.likes !== null);
                        console.log(this.likes + ' is a ' + (typeof this.likes));
                        console.log(this.likes.data !== undefined);
                        console.log(this.likes.data !== null);
                        console.log(this.likes.data + ' is a ' + (typeof this.likes.data));
                        console.log(this.comments !== undefined);
                        console.log(this.comments !== null);
                        console.log(this.comments + ' is a ' + (typeof this.comments));
                        console.log(this.comments.data !== null);
                        console.log(this.comments.data !== undefined);
                        console.log(this.comments.data + ' is a ' + (typeof this.comments.data));
                        console.log(this.shares !== undefined);
                        console.log(this.shares !== null);
                        console.log(this.shares + ' is a ' + (typeof this.shares));
                        console.log(this.shares.data !== undefined);
                        console.log(this.shares.data !== null);
                        console.log(this.shares.data + ' is a ' + (typeof this.shares.data));*/
                        
                        if (this.message !== undefined) {
							if (options.message_length > 0 && this.message.length > options.message_length) {
								output += '<div class="message">' + modText(this.message.substring(0, options.message_length)) + '...</div>';
							} else {
								output += '<div class="message">' + modText(this.message) + '</div>';
							}
						} else if (this.story !== undefined) {
							if (options.message_length > 0 && this.story.length > options.message_length) {
								output += '<div class="story">' + modText(this.story.substring(0, options.message_length)) + '...</div>';
							} else {
								output += '<div class="story">' + modText(this.story) + '</div>';
							}
						}

					

						output += '<div class="meta-footer">';
							output += '<time class="date" datetime="' + this.created_time + '" pubdate>' + timeToHuman(this.created_time) + '</time>';
							if (this.likes !== undefined && this.likes.data !== undefined) {
								if (this.likes.count !== undefined) {
									if (this.likes.count === 1) {
										output += '<span class="seperator">&middot;</span><span class="likes">' + options.text_labels.likes.singular.replace('%', this.likes.count) + '</span>';
									} else {
										output += '<span class="seperator">&middot;</span><span class="likes">' + options.text_labels.likes.plural.replace('%', this.likes.count) + '</span>';
									}
								} else {
									if (this.likes.data.length === 1) {
										output += '<span class="seperator">&middot;</span><span class="likes">' + options.text_labels.likes.singular.replace('%', this.likes.data.length) + '</span>';
									} else {
										output += '<span class="seperator">&middot;</span><span class="likes">' + options.text_labels.likes.plural.replace('%', this.likes.data.length) + '</span>';
									}
								}
							}
							if (this.comments !== undefined && this.comments.data !== undefined) {
								if (this.comments.data.length === 1) {
									output += '<span class="seperator">&middot;</span><span class="comments">' + options.text_labels.comments.singular.replace('%', this.comments.data.length) + '</span>';
								} else {
									output += '<span class="seperator">&middot;</span><span class="comments">' + options.text_labels.comments.plural.replace('%', this.comments.data.length) + '</span>';
								}
							}
							if (this.shares !== undefined) {
								if (this.shares.count === 1) {
									output += '<span class="seperator">&middot;</span><span class="shares">' + options.text_labels.shares.singular.replace('%', this.shares.count) + '</span>';
								} else {
									output += '<span class="seperator">&middot;</span><span class="shares">' + options.text_labels.shares.plural.replace('%', this.shares.count) + '</span>';
								}
							} else {
								output += '<span class="seperator">&middot;</span><span class="shares">' + options.text_labels.shares.plural.replace('%', '0') + '</span>';
							}
							split_id = this.id.split('_');
							//output += '<div class="actionlinks"><span class="like"><a href="http://www.facebook.com/permalink.php?story_fbid=' + split_id[1] + '&id=' + split_id[0] + '" target="_blank">' + options.text_labels.like + '</a></span><span class="seperator">&middot;</span><span class="comment"><a href="http://www.facebook.com/permalink.php?story_fbid=' + split_id[1] + '&id=' + split_id[0] + '" target="_blank">' + options.text_labels.comment + '</a></span><span class="seperator">&middot;</span><span class="share"><a href="http://www.facebook.com/permalink.php?story_fbid=' + split_id[1] + '&id=' + split_id[0] + '" target="_blank">' + options.text_labels.share + '</a></span></div>';
							output += '<div class="actionlinks"><span class="like"><a href="http://www.facebook.com/permalink.php?story_fbid=' + split_id[1] + '&id=' + split_id[0] + '" target="_blank">' + options.text_labels.like + '</a></span></div>';
						output += '</div>';

						if (this.likes !== undefined && this.likes.data !== undefined) {
							// output += '<ul class="like-list">';
							// 	for (var l = 0; l < this.likes.data.length; l++) {
							// 		output += '<li class="like">';
							// 			output += '<div class="meta-header">';
							// 				output += '<div class="avatar"><a href="http://www.facebook.com/profile.php?id=' + this.likes.data[l].id + '" target="_blank" title="' + this.likes.data[l].name + '"><img src="' + (graphURL + this.likes.data[l].id + '/picture?type=' + options.avatar_size) + '" alt="' + this.likes.data[l].name + '" /></a></div>';
							// 				output += '<div class="author"><a href="http://www.facebook.com/profile.php?id=' + this.likes.data[l].id + '" target="_blank" title="' + this.likes.data[l].name + '">' + this.likes.data[l].name + '</a>' + options.text_labels.likes.singular.replace('%', '') + '</div>';
							// 			output += '</div>';
							// 		output += '</li>';
							// 	}
							// output += '</ul>';
						}
						

				//comment list part disabled.
						// if (this.comments !== undefined && this.comments.data !== undefined) {
						// 	output += '<ul class="comment-list">';
						// 		for (var c = 0; c < this.comments.data.length; c++) {
						// 			output += '<li class="comment">';
						// 				output += '<div class="meta-header">';
						// 					output += '<div class="avatar"><a href="http://www.facebook.com/profile.php?id=' + this.comments.data[c].from.id + '" target="_blank" title="' + this.comments.data[c].from.name + '"><img src="' + (graphURL + this.comments.data[c].from.id + '/picture?type=' + options.avatar_size) + '" alt="' + this.comments.data[c].from.name + '" /></a></div>';
						// 					output += '<div class="author"><a href="http://www.facebook.com/profile.php?id=' + this.comments.data[c].from.id + '" target="_blank" title="' + this.comments.data[c].from.name + '">' + this.comments.data[c].from.name + '</a></div>';
						// 					output += '<time class="date" datetime="' + this.comments.data[c].created_time + '" pubdate>' + timeToHuman(this.comments.data[c].created_time) + '</time>';
						// 				output += '</div>';
						// 				output += '<div class="message">' + modText(this.comments.data[c].message) + '</div>';
						// 				output += '<time class="date" datetime="' + this.comments.data[c].created_time + '" pubdate>' + timeToHuman(this.comments.data[c].created_time) + '</time>';
						// 			output += '</li>';
						// 		}
						// 	output += '</ul>';
						// }
					output += '</li>';

					e.append(output);
				}
			});
		}).complete(function () {
			$('.facebook-loading', e).fadeOut(800, function () {
				$(this).remove();
				for (var p = 0; p < e.children('li').length; p++) {
					if (options.effect === 'none') {
						e.children('li').eq(p).show();
					} else if (options.effect === 'fade') {
						e.children('li').eq(p).delay(p*options.timeout).fadeIn(options.speed);
					} else {
						e.children('li').eq(p).delay(p*options.timeout).slideDown(options.speed, function () {
							$(this).css('overflow', 'visible');
						});
					}
				}
			});
			if ($.isFunction(options.on_complete)) {
				options.on_complete.call();
			}
		});

		function modText(text) {
			return nl2br(autoLink(escapeTags(text)));
		}
		function nl2br(str) {
			return str.replace(/(\r\n)|(\n\r)|\r|\n/g, '<br />');
		}
		function autoLink(str) {
			return str.replace(/((http|https|ftp):\/\/[\w?=&.\/-;#~%-]+(?![\w\s?&.\/;#~%"=-]*>))/g, '<a href="$1" target="_blank">$1</a>');
		}
		function escapeTags(str) {
			return str.replace(/</g, '&lt;').replace(/>/g, '&gt;');
		}
		function timeToHuman(time) {
            if (options.date_engine == 'moment.js') {
                moment.lang('da');

                if (moment().diff(moment(time), 'days') < 10) {
                    return moment(time).fromNow();
                } else {
                    return moment(time).format(options.date_format);
                }
            } else {
                var timestamp = new Date(time*1000),
                    dateString = timestamp.toGMTString(),
                    time_difference = Math.round(new Date().getTime()/1000)-time;
                
                if (time_difference < 10) {
                    return 'a few seconds ago';
                } else if (time_difference < 60) {
                    return Math.round(time_difference) + ' seconds ago';
                } else if (Math.round(time_difference/60) == 1) {
                    return Math.round(time_difference/60) + ' minutes ago';
                } else if (Math.round(time_difference/60) < 60) {
                    return Math.round(time_difference/60) + ' minutes ago';
                } else if (Math.round(time_difference/(60*60)) == 1) {
                    return Math.round(time_difference/(60*60)) + ' hour ago';
                } else if (Math.round(time_difference/(60*60)) < 24) {
                    return Math.round(time_difference/(60*60)) + ' hour ago';
                } else if (Math.round(time_difference/(60*60*24)) == 1) {
                    return Math.round(time_difference/(60*60*24)) + ' day ago';
                } else if (Math.round(time_difference/(60*60*24)) <= 10) {
                    return Math.round(time_difference/(60*60*24)) + ' days ago';
                } else {
                    return options.text_labels.days[timestamp.getDay()] + ' d. ' + timestamp.getDate() + '. ' + options.text_labels.months[timestamp.getMonth()] + ' ' + timestamp.getFullYear();
                }
            }
		}
	};	
})(jQuery);