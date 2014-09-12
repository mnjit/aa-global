<?php
class DT_contact_Widget extends WP_Widget {

	/* Widget setup  */
	function __construct() {  
        /* Widget settings. */
		$widget_ops = array( 'description' => _x( 'Contact form', 'widget contact form', LANGUAGE_ZONE ) );

		/* Create the widget. */
        parent::__construct(
            'dt-contact-widget',
            DT_WIDGET_PREFIX . _x( 'Contact', 'widget contact form', LANGUAGE_ZONE ),
            $widget_ops
        );
	}

	/* Display the widget  */
    function widget( $args, $instance ) {
        static $widget_counter = 1;
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
        $en_captcha = isset( $instance['enable_captcha'] ) ? $instance['enable_captcha'] : true;

        $captcha_id = 'widget_' . $widget_counter++;
		echo $before_widget ;

		// start
		echo $before_title . $title . $after_title;

        if( isset($instance['text']) && $instance['text'] )
            echo force_balance_tags('<p>' . $instance['text'] . '</p>');
?>
        <form class="uniform get-in-touch ajaxing" method="post" action="/"> 
            <?php wp_nonce_field('dt_contact_' . $captcha_id,'dt_contact_form_nonce'); ?>
            <input type="hidden" name="send_message" value="" />
            <input type="hidden" name="send_contacts" value="<?php echo $captcha_id; ?>" />

            <div class="i-i">
				<div class="i-h">
					<input id="your_name" name="f_name" type="text" value="" class="validate[required]" />               
				</div>
				<div class="i-l"><span><?php _ex( 'Name*', 'widget contact form', LANGUAGE_ZONE ); ?></span></div>
			</div>
            <div class="i-i">
				<div class="i-h">
					<input id="email" name="f_email" type="text" value="" class="validate[required,custom[email]" />
				</div>
				<div class="i-l"><span><?php _ex( 'E-mail*', 'widget contact form', LANGUAGE_ZONE ); ?></span></div>
			</div>
            
            <div class="t-h">
                <textarea type="textarea" id="message" name="f_comment" class="validate[required]"></textarea>
            </div>

            <?php do_action('dt_contact_form_captcha_place', array( 'whoami' => $captcha_id, 'enable' => $en_captcha ) ); ?>
            
            <div class="but-wrap"><a href="#" class="button go_submit" title="<?php _ex( 'Submit', 'widget contact form', LANGUAGE_ZONE ); ?>"><span><i class="submit"></i><?php _ex( "Send message", 'widget contact form', LANGUAGE_ZONE ); ?></span></a></div>
            <span class="c-clear"><a href="#" class="do-clear"><?php _ex( 'clear form', 'widget contact form', LANGUAGE_ZONE ); ?></a></span>
        </form>   
<?php
		echo $after_widget;
    }

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['text'] = isset( $new_instance['text'] ) ? esc_html( $new_instance['text'] ) : '';
        $instance['enable_captcha'] = isset( $new_instance['enable_captcha'] );
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
            'text'              => '',
			'title'             => '',
            'enable_captcha'    => true
		);
			
        $instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _ex( 'Title:', 'widget contact form', LANGUAGE_ZONE ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _ex( 'Text:', 'widget contact form', LANGUAGE_ZONE ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $instance['text']; ?></textarea>
		</p>
		
		<?php if ( class_exists('Dt_Captcha') && Dt_Captcha::$global_enable ) : ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'enable_captcha' ); ?>"><?php _ex( 'Enable Captcha:', 'widget contact form', LANGUAGE_ZONE ); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'enable_captcha' ); ?>" name="<?php echo $this->get_field_name( 'enable_captcha' ); ?>" <?php checked( $instance['enable_captcha'] ); ?> />
		</p>
			
        <a href="<?php echo admin_url('admin.php?page=of-captcha-menu'); ?>"><?php _ex( 'Captha options', 'widget contact form', LANGUAGE_ZONE ); ?></a>

		<?php endif; // Captcha ?>

<?php

    }
}

/* Register the widget */
function dt_contact_register() {
	register_widget( 'DT_contact_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_contact_register' );

/**
 * Mail function.
 */
function dt_check_current_date() {
    $place = isset( $_POST['send_contacts'] ) ? trim( $_POST['send_contacts'] ) : '';
    $honey_msg = isset( $_POST['send_message'] ) ? trim( $_POST['send_message'] ) : '';
    $name = isset( $_POST['f_name'] ) ? trim( strip_tags( $_POST['f_name'] ) ) : '';
    $email = isset( $_POST['f_email'] ) ? trim( strip_tags( $_POST['f_email'] ) ) : '';
    $phone = isset( $_POST['f_phone'] ) ? trim( strip_tags( $_POST['f_phone'] ) ) : '';
    $website = isset( $_POST['f_website'] ) ? trim( strip_tags( $_POST['f_website'] ) ) : '';
    $msg = isset( $_POST['f_comment'] ) ? trim( strip_tags( $_POST['f_comment'] ) ) : '';
    $captcha = isset( $_POST['cptch_number'] ) ? trim( strip_tags( $_POST['cptch_number'] ) ) : '';
    $pid = isset( $_POST['pid'] ) ? intval( $_POST['pid'] ) : false;
    $nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : false;

    $send = false;

    $errors = '';
	Dt_Captcha::session_check();
    $check = Dt_Captcha::check( $captcha, $place );
    
    if ( ! wp_verify_nonce( $nonce, 'dt_contact_'.$place ) ) {
        $errors = _x( 'Nonce do not match', 'feedback msg', LANGUAGE_ZONE );
    } elseif ( 2 == $check ) {
        $errors = _x( 'Captcha filled incorrectly', 'feedback msg', LANGUAGE_ZONE );
    } elseif ( 3 == $check ){
        $errors = _x( 'Fill the captcha', 'feedback msg', LANGUAGE_ZONE );
    } elseif ( $name && $email && $msg && 1 == $check && !$honey_msg ) {
        
        if ( $pid ) {
            $data = get_post_meta( $pid, 'contact_options', true );
            $em = ! empty( $data['target_email'] ) ? strip_tags( $data['target_email'] ) : get_option( 'admin_email' );
        } else {
            $em = get_option( 'admin_email' );
        }
        
		$headers = 'From: ' . esc_attr( strip_tags( $name ) ) . ' <' . esc_html( $email ) . '>' . "\r\n";
		$headers .= 'Reply-To: ' . esc_html( $email ) . "\r\n";
		
		$msg_mail = _x( 'Name: ', 'feedback mail', LANGUAGE_ZONE ) . esc_html( $name ) . "\n";
        $msg_mail .= _x( 'Email: ', 'feedback mail', LANGUAGE_ZONE ) . esc_html( $email ) . "\n";
        
        if ( ! empty( $phone ) ) {
            $msg_mail .= _x( 'Telephone: ', 'feedback mail', LANGUAGE_ZONE ) . esc_html( $phone ) . "\n";
        }
        
        if ( ! empty( $website ) ) {
            $msg_mail .= _x( 'Website: ', 'feedback mail', LANGUAGE_ZONE ) . esc_html( $website ) . "\n";
        }
        
        $msg_mail .= _x( 'Message: ', 'feedback mail', LANGUAGE_ZONE ) . esc_html( $msg ) . "\n";
        
        $send = wp_mail(
            $em,
            '[Feedback from: ' . esc_attr( get_option( 'blogname' ) ) . ']',
            $msg_mail,
			$headers
        );
        
        if ( $send ) {
            $errors = _x( 'Feedback has been sent to the administrator', 'feedback msg', LANGUAGE_ZONE );
        } else {
            $errors = _x( 'The message has not been sent', 'feedback msg', LANGUAGE_ZONE );
        }
        $nonce = wp_create_nonce( 'dt_contact_' . $place );
        
    } elseif( $honey_msg ) {
        $errors = _x( 'Sorry, we suspect that you are bot', 'feedback', LANGUAGE_ZONE );
    }
    
	$captcha = '';
	if ( Dt_Captcha::$global_enable ) {
    	$c_form = new Dt_Captcha( array( 'whoami' => $place, 'rewrite' => false ) );
    	$captcha = $c_form->get_captcha();
	}

    //wp_nonce_field('dt_contact_'.$place,'dt_contact_form_nonce', false, false);
    
    $response = json_encode(
		array(
			'success'		=> $send ,
			'errors'        => $errors,
            'captcha'       => $captcha,
            'nonce'         => $nonce
		)
	);

	// response output
    header( "Content-Type: application/json" );
    echo $response;

    // IMPORTANT: don't forget to "exit"
    exit;
}
add_action( 'wp_ajax_nopriv_dt_check_current_date', 'dt_check_current_date' );
add_action( 'wp_ajax_dt_check_current_date', 'dt_check_current_date' );
