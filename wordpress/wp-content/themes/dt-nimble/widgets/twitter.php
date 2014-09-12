<?php
class DT_Twitter_Widget extends WP_Widget {
    public $dt_defaults = array( 
		'title'     => '',
        'username'  => '',
        'number'    => 6,
        'link'      => '',
        'autoslide' => 0,
    );
	
	function _enqueue_scripts() {
		wp_enqueue_script( 'dt_widget_twitter_blogger', 'http://twitter.com/javascripts/blogger.js', array(), false );
		wp_enqueue_script( 'dt_widget_twitter_callback', get_template_directory_uri() . '/js/twitter-lib.js', array('jquery'), false );
	}
	
	function __construct() {
		$widget_ops = array( 'description' => __('Displays your tweets', LANGUAGE_ZONE) );
        parent::__construct(
            'dt_twitter_feed',
            DT_WIDGET_PREFIX . __('Twitter', LANGUAGE_ZONE),
            $widget_ops
        );
		
		add_action( 'wp_enqueue_scripts', array( $this, '_enqueue_scripts' ) );
	}

	function widget( $args, $instance ) {
		
		// count printed widgets
		static $widget_counter = 0;
		$widget_counter++;

		extract( $args, EXTR_SKIP );

        $instance = wp_parse_args( (array) $instance, $this->dt_defaults );

		$title = empty( $instance['title'] ) ? ' ' : apply_filters('widget_title', $instance['title']);	
		$username = isset( $instance['username'] ) ? $instance['username'] : '';
		$limit = $instance['number'];
		$link = $instance['link'];
        $autoslide = $instance['autoslide'];
        $autoslide_on = $autoslide?1:0;
/*		
		$feed = "http://search.twitter.com/search.atom?result_type=recent&q=from:" . $username . "&rpp=" . $limit; 
		$twitterFeed = wp_remote_fopen( $feed );
        
        $tweets = $this->pw_parse_feed($twitterFeed);
*/        
		echo $before_widget;

	    if( $title ) { echo $before_title . $title . $after_title; };
        ?>

        <div class="reviews-t twitts">
            <div class="list-carousel coda bx">
				
				<?php if( $username ): ?>

				<ul id="twitter_update_list_<?php echo $widget_counter; ?>" class="slider1 twitter" data-autoslide="<?php echo $autoslide; ?>" data-autoslide_on="<?php echo $autoslide_on; ?>">
					<script type="text/javascript">
						function dtTwitterCallback<?php echo $widget_counter; ?>( twitters ) {
							var statusHTML = [];
							for (var i=0; i<twitters.length; i++){
								var username = twitters[i].user.screen_name;
								var status = twitters[i].text.replace( /((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
									return '<a href="'+url+'">'+url+'</a>';
								}).replace( /\B@([_a-z0-9]+)/ig, function(reply) {
									return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
								});
								statusHTML.push('<li><div class="panel-wrapper"><p>'+status+'<br /><a class="blue-date" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></p></div></li>');
							}
							jQuery('#twitter_update_list_<?php echo $widget_counter; ?>').html( statusHTML.join('') );
							dtTwitterCarouFredseller('#twitter_update_list_<?php echo $widget_counter; ?>');							
						}
					</script>
					<script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline.json?screen_name=<?php echo esc_attr( $username ); ?>&callback=dtTwitterCallback<?php echo $widget_counter; ?>&count=<?php echo esc_attr( $limit ); ?>&trim_user=1"></script>
					
                </ul>
				
				<?php else: ?>
				
				<p><?php echo _x( 'No username specified', 'widget twitter', LANGUAGE_ZONE ); ?></p>
				
				<?php endif; ?>
				
            </div>
			<div class="reviews-b"></div>
        </div>

        <?php if( $link ): ?>
  
			<div class=" autor coda-author twit-author"><div class="ico-twit"><a href="http://twitter.com<?php echo '/' . $username; ?>" target="_blank"><?php echo $link; ?></a></div></div>
        
		<?php endif; ?>
        
	  	<?php
		echo $after_widget; 

	}
	
	function pw_parse_feed( $feed ) {
		$feed = str_replace("&lt;", "<", $feed);
		$feed = str_replace("&gt;", ">", $feed);
		$feed = str_replace("&quot;", '"', $feed);
		$clean = explode("<content type=\"html\">", $feed);
		
		$amount = count($clean) - 1;
		
        $result = array();    
		for ($i = 1; $i <= $amount; $i++) {
			$cleaner = explode("</content><updated>", $clean[$i]);
			$trulyclean = explode('</updated>', $cleaner[1]);
			$href_clean = explode('</published><link type="text/html" href="', $clean[$i-1]);
			
			$href = esc_url(current(explode('" rel="alternate"/>', $href_clean[1])));
			$time = date_parse(str_replace(array("T", "Z"), ' ', $trulyclean[0]));
			$time = gmmktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);
			$ago = $this->ago($time);
			$time = date(get_option( 'date_format' ). ' /i/n '. get_option( 'time_format' ), $time);
            $result[] = array( 'content' => str_replace("&amp;", "&", $cleaner[0]), 'ago' => $ago, 'time' => $time );
        }
        return $result;
	}
	
	function ago($time) {
		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");

		$now = time();
        $difference = $now - $time;
        $tense = "ago";

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference = ceil($difference/$lengths[$j]);
		}

		$difference = ceil($difference);

		if($difference != 1) {
			$periods[$j].= "s";
		}

		return "$difference $periods[$j] $tense";
	}

	function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, $this->dt_defaults );

		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', LANGUAGE_ZONE); ?>:<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username', LANGUAGE_ZONE); ?>: <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($instance['username']); ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Twitts', LANGUAGE_ZONE); ?>: <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Text Link', LANGUAGE_ZONE); ?>: <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($instance['link']); ?>" /></label>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'autoslide' ); ?>"><?php _e('Autoslide:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'autoslide' ); ?>" name="<?php echo $this->get_field_name( 'autoslide' ); ?>" value="<?php echo esc_attr($instance['autoslide']); ?>" size="4" />
			<em>milliseconds<br /> (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")</em>
	    </p>
		<div style="clear: both;"></div>
		<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['number'] = abs(intval($new_instance['number']));
        $instance['autoslide'] = abs(intval($new_instance['autoslide']));
		return $instance;
	}
}

/* Register the widget */
function dt_twitter_register() {
    register_widget('DT_Twitter_Widget');
}

/* Load the widget */
add_action( 'widgets_init', 'dt_twitter_register' );
?>
