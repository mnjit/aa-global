<?php
/*
Plugin Name: Captcha
Plugin URI:  http://bestwebsoft.com/plugin/
Description: Plugin Captcha intended to prove that the visitor is a human being and not a spam robot. Plugin asks the visitor to answer a math question.
Author: BestWebSoft
Version: 2.24
Author URI: http://bestwebsoft.com/
License: GPLv2 or later
*/

/*  © Copyright 2011  BestWebSoft  ( admin@bestwebsoft.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Modified by Dream-Theme
*/

// start session
function dt_start_session() {

	if ( Dt_Captcha::session_check() ) {
		Dt_Captcha::init();
	}
}
add_action( 'init', 'dt_start_session' );

if ( ! defined( 'DT_CAPTCHA_KEY' ) ) {
    define( 'DT_CAPTCHA_KEY', '123' );
}

class Dt_Captcha {
    static $hide_register = false;
    static $math_action_plus = true;
    static $math_action_minus = true;
	static $math_action_increase = true;
	static $label_form = '';
	static $difficulty_number = true;
	static $difficulty_word = true;
    static $contact_form = true;
    static $contact_widget = true;
    static $obj_count = 0;

	// global switch
	static $global_enable = true;

    private $whoami = false;
    private $enable = true;

	static function session_check() {
    	if ( !session_id() ) {
        	@session_start();
    	}

		if ( !session_id() ) {
			Dt_Captcha::$global_enable = false;
			return false;
		}
		return true;
	}

    
    function add_options( $origin_options ) {
        include( dirname(__FILE__) . '/options/options.php' );
        return wp_parse_args($options, $origin_options);
    }

    function init() {
        if ( function_exists( 'of_get_option' ) ) {
            Dt_Captcha::$hide_register = of_get_option( 'captcha_hide_register', true );
            Dt_Captcha::$math_action_minus = of_get_option( 'captcha_math_action_minus', true );
            Dt_Captcha::$math_action_increase = of_get_option( 'captcha_math_action_increase', true );
            Dt_Captcha::$label_form = of_get_option( 'captcha_label_form', '' );
            Dt_Captcha::$difficulty_number = of_get_option( 'captcha_difficulty_number', true );
            Dt_Captcha::$difficulty_word = of_get_option( 'captcha_difficulty_word', true );
        }

        // hopefuly add captcha theme options page
        add_filter( 'optionsframework_options', array('Dt_Captcha', 'add_options') );
		add_action( 'dt_contact_form_captcha_place', 'dt_add_captcha_to_form', 10, 1 );
    }
    
    function __construct( $data ) {
//        $this->whoami = $str;
        if ( ! is_array( $data ) )
            return false;

        if ( isset( $data['whoami'] ) ) {
            if ( isset( $data['rewrite'] ) && ! $data['rewrite'] && ! isset( $_SESSION['dt_captcha'][$data['whoami']] ) ) {
                return false;
            }
            $this->whoami = trim( strip_tags( $data['whoami'] ) );
        }

        if ( isset( $data['enable'] ) && false !== $this->whoami ) {
            $this->enable = $data['enable'];
            $_SESSION['dt_captcha'][$this->whoami]['enable'] = $this->enable;
        } elseif( isset( $_SESSION['dt_captcha'][$this->whoami]['enable'] ) ) {
            $this->enable = ( bool ) $_SESSION['dt_captcha'][$this->whoami]['enable'];
        }
    }
    
    function get_captcha() {
        $out = '';
        
        // skip captcha if user is logged in and the settings allow
        if ( !self::$global_enable || (is_user_logged_in() && true == Dt_Captcha::$hide_register) ) {
            return $out;
        }

        // if not enabled or bad init
        if ( false === $this->whoami || !$this->enable ) {
            return $out;
        }

        // captcha html - comment form
        if ( ! empty( Dt_Captcha::$label_form ) ) {	
			$out .= '<p>'. stripslashes( Dt_Captcha::$label_form ) .'</p>';
        }
		$out .= '<div>';
        $out .= $this->generate_captcha();
		$out .= '</div>';
        
        return $out;
    }
    
    function generate_captcha() {
    
        // In letters presentation of numbers 0-9
        $number_string = array(); 
        $number_string[0] = _x( 'null', 'captcha', LANGUAGE_ZONE );
        $number_string[1] = _x( 'one', 'captcha', LANGUAGE_ZONE );
        $number_string[2] = _x( 'two', 'captcha', LANGUAGE_ZONE );
        $number_string[3] = _x( 'three', 'captcha', LANGUAGE_ZONE );
        $number_string[4] = _x( 'four', 'captcha', LANGUAGE_ZONE );
        $number_string[5] = _x( 'five', 'captcha', LANGUAGE_ZONE );
        $number_string[6] = _x( 'six', 'captcha', LANGUAGE_ZONE );
        $number_string[7] = _x( 'seven', 'captcha', LANGUAGE_ZONE );
        $number_string[8] = _x( 'eight', 'captcha', LANGUAGE_ZONE );
        $number_string[9] = _x( 'nine', 'captcha', LANGUAGE_ZONE ); 
        // In letters presentation of numbers 11 -19
        $number_two_string = array();
        $number_two_string[1] = _x( 'eleven', 'captcha', LANGUAGE_ZONE );
        $number_two_string[2] = _x( 'twelve', 'captcha', LANGUAGE_ZONE );
        $number_two_string[3] = _x( 'thirteen', 'captcha', LANGUAGE_ZONE );
        $number_two_string[4] = _x( 'fourteen', 'captcha', LANGUAGE_ZONE );
        $number_two_string[5] = _x( 'fifteen', 'captcha', LANGUAGE_ZONE );
        $number_two_string[6] = _x( 'sixteen', 'captcha', LANGUAGE_ZONE );
        $number_two_string[7] = _x( 'seventeen', 'captcha', LANGUAGE_ZONE );
        $number_two_string[8] = _x( 'eighteen', 'captcha', LANGUAGE_ZONE );
        $number_two_string[9] = _x( 'nineteen', 'captcha', LANGUAGE_ZONE );
        // In letters presentation of numbers 10, 20, 30, 40, 50, 60, 70, 80, 90
        $number_three_string = array();
        $number_three_string[1] = _x( 'ten', 'captcha', LANGUAGE_ZONE );
        $number_three_string[2] = _x( 'twenty', 'captcha', LANGUAGE_ZONE );
        $number_three_string[3] = _x( 'thirty', 'captcha', LANGUAGE_ZONE );
        $number_three_string[4] = _x( 'forty', 'captcha', LANGUAGE_ZONE );
        $number_three_string[5] = _x( 'fifty', 'captcha', LANGUAGE_ZONE );
        $number_three_string[6] = _x( 'sixty', 'captcha', LANGUAGE_ZONE );
        $number_three_string[7] = _x( 'seventy', 'captcha', LANGUAGE_ZONE );
        $number_three_string[8] = _x( 'eighty', 'captcha', LANGUAGE_ZONE );
        $number_three_string[9] = _x( 'ninety', 'captcha', LANGUAGE_ZONE );
        // The array of math actions
        $math_actions = array();

        // If value for Plus on the settings page is set
        if ( true == Dt_Captcha::$math_action_plus ) {
            $math_actions[] = '&#43;';
        }
        // If value for Minus on the settings page is set
        if ( true == Dt_Captcha::$math_action_minus ) {
            $math_actions[] = '&minus;';
        }
        // If value for Increase on the settings page is set
        if ( true == Dt_Captcha::$math_action_increase ) {
            $math_actions[] = '&times;';
        }
            
        // Which field from three will be the input to enter required value
        $rand_input = rand( 0, 2 );
        // Which field from three will be the letters presentation of numbers
        $rand_number_string = rand( 0, 2 );
        // If don't check Word in setting page - $rand_number_string not display
        if ( false == Dt_Captcha::$difficulty_word) {
            $rand_number_string = -1;
        }
        // Set value for $rand_number_string while $rand_input = $rand_number_string
        while ( $rand_input == $rand_number_string ) {
            $rand_number_string = rand( 0, 2 );
        }
        // What is math action to display in the form
        $rand_math_action = rand( 0, count( $math_actions ) - 1 );

        $array_math_expretion = array();

        // Add first part of mathematical expression
        $array_math_expretion[0] = rand( 1, 9 );
        // Add second part of mathematical expression
        $array_math_expretion[1] = rand( 1, 9 );
        // Calculation of the mathematical expression result
        switch ( $math_actions[$rand_math_action] ) {
            case "&#43;":
                $array_math_expretion[2] = $array_math_expretion[0] + $array_math_expretion[1];
                break;
            case "&minus;":
                // Result must not be equal to the negative number
                if ( $array_math_expretion[0] < $array_math_expretion[1] ) {
                    $number						= $array_math_expretion[0];
                    $array_math_expretion[0]	= $array_math_expretion[1];
                    $array_math_expretion[1]	= $number;
                }
                $array_math_expretion[2] = $array_math_expretion[0] - $array_math_expretion[1];
                break;
            case "&times;":
                $array_math_expretion[2] = $array_math_expretion[0] * $array_math_expretion[1];
                break;
        }
        
        // String for display
        $str_math_expretion = "";
        // First part of mathematical expression
        if ( 0 == $rand_input )
            $str_math_expretion .= "<input type=\"text\" name=\"cptch_number\" value=\"\" maxlength=\"1\" size=\"1\" style=\"width:20px;margin-bottom:0;display:inline;\" />";
        else if ( 0 == $rand_number_string || false == Dt_Captcha::$difficulty_number )
            $str_math_expretion .= $number_string[$array_math_expretion[0]];
        else
            $str_math_expretion .= $array_math_expretion[0];
        
        // Add math action
        $str_math_expretion .= " ".$math_actions[$rand_math_action];
        
        // Second part of mathematical expression
        if ( 1 == $rand_input )
            $str_math_expretion .= " <input type=\"text\" name=\"cptch_number\" value=\"\" maxlength=\"1\" size=\"1\" style=\"width:20px;margin-bottom:0;display:inline;\" />";
        else if ( 1 == $rand_number_string || false == Dt_Captcha::$difficulty_number )
            $str_math_expretion .= " ".$number_string[$array_math_expretion[1]];
        else
            $str_math_expretion .= " ".$array_math_expretion[1];
        
        // Add =
        $str_math_expretion .= " = ";
        
        // Add result of mathematical expression
        if ( 2 == $rand_input ) {
            $str_math_expretion .= " <input type=\"text\" name=\"cptch_number\" value=\"\" maxlength=\"2\" size=\"1\" style=\"width:20px;margin-bottom:0;display:inline;\" />";
        } else if ( 2 == $rand_number_string || false == Dt_Captcha::$difficulty_number ) {
            if( $array_math_expretion[2] < 10 )
                $str_math_expretion .= " ".$number_string[$array_math_expretion[2]];
            else if( $array_math_expretion[2] < 20 && $array_math_expretion[2] > 10 )
                $str_math_expretion .= " ".$number_two_string[ $array_math_expretion[2] % 10 ];
            else {
                if ( get_bloginfo( 'language', 'Display' ) == "nl-NL" ) {
                    $str_math_expretion .= " ".( 0 != $array_math_expretion[2] % 10 ? $number_string[ $array_math_expretion[2] % 10 ]. _x( "and", 'captcha', LANGUAGE_ZONE ) : '').$number_three_string[ $array_math_expretion[2] / 10 ];
                } else {
                    $str_math_expretion .= " ".$number_three_string[ $array_math_expretion[2] / 10 ]." ".( 0 != $array_math_expretion[2] % 10 ? $number_string[ $array_math_expretion[2] % 10 ] : '');
                }
            }
        } else {
            $str_math_expretion .= $array_math_expretion[2];
        }
        
        $_SESSION['dt_captcha'][$this->whoami]['captcha'] = self::encode( $array_math_expretion[$rand_input], DT_CAPTCHA_KEY );
		
		$str_math_expretion = str_replace( '<input', '<input class="i-h"', $str_math_expretion );
        return $str_math_expretion;
    }
    
    function encode( $String, $Password ) {
        $Salt = 'BGuxLWQtKweKEMV4';
        $String = substr( pack( "H*", sha1( $String ) ), 0, 1 ).$String;
        $StrLen = strlen( $String );
        $Seq = $Password;
        $Gamma	= '';
        while ( strlen( $Gamma ) < $StrLen ) {
                $Seq = pack( "H*", sha1( $Seq . $Gamma . $Salt ) );
                $Gamma.=substr( $Seq, 0, 8 );
        }

        return base64_encode( $String ^ $Gamma );
    }
    
    function decode( $String, $Key ) {
        $Salt =	'BGuxLWQtKweKEMV4';
        $StrLen = strlen( $String );
        $Seq = $Key;
        $Gamma = '';
        while( strlen( $Gamma ) < $StrLen ) {
                $Seq = pack( "H*", sha1( $Seq . $Gamma . $Salt ) );
                $Gamma.= substr( $Seq, 0, 8 );
        }

        $String = base64_decode( $String );
        $String = $String^$Gamma;

        $dt_decodedString = substr( $String, 1 );
        $Error = ord( substr( $String, 0, 1 ) ^ substr( pack( "H*", sha1( $dt_decodedString ) ), 0, 1 )); 

        if ( $Error ) 
            return false;
        else 
            return $dt_decodedString;
    }
    
    function check( $number, $place ) {
		if ( !self::$global_enable )
			return 1;
		
        if( !isset($_SESSION['dt_captcha'][$place]) )
            return 2;
                
        if( (is_user_logged_in() && true == Dt_Captcha::$hide_register) ||
            !$_SESSION['dt_captcha'][$place]['enable'] ) {
            return 1;
        }
        
        if( $number !== '' && !empty($place) && isset($_SESSION['dt_captcha'][$place]['captcha']) ) {
            
            if( 0 == strcasecmp( trim( self::decode( $_SESSION['dt_captcha'][$place]['captcha'], DT_CAPTCHA_KEY ) ), $number ) ) {
                unset($_SESSION['dt_captcha'][$place]['captcha']);
                return 1;
            } else {
                return 2;
            }
        
        }else {
            return 3;
        }
    }
}// end class

function dt_add_captcha_to_form( $data ) {
    $c_form = new Dt_Captcha( $data );
    echo '<div class="dt_captcha captcha">' . $c_form->get_captcha() . '</div>';
}
