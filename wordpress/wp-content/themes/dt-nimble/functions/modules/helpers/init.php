<?php

// module uri
if( !defined('DT_HELPERS_URI') ) {
    define( 'DT_HELPERS_URI', get_template_directory_uri(). '/functions/modules/helpers' );
}

// setup module
require_once 'template-helpers.php';
require_once 'like_buttons-helpers.php';

?>