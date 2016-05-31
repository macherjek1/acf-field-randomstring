<?php

/*
Plugin Name: Advanced Custom Fields: Random String
Plugin URI: http://www.github.com/hcmedia
Description: Random String Generator Add-On for the Advanced Custom Fields plugin
Version: 1.0.0
Author: HC-Media
Author URI: http://www.hc-media.org
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/




// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-randomstring', false, dirname( plugin_basename(__FILE__) ) . '/lang/' ); 




// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
/*
function include_field_types_randomstring( $version ) {
	
	include_once('acf-randomstring-v5.php');
	
}

add_action('acf/include_field_types', 'include_field_types_randomstring');	
*/



// 3. Include field type for ACF4
function register_fields_randomstring() {
	
	include_once('acf-randomstring-v4.php');
	
}

add_action('acf/register_fields', 'register_fields_randomstring');	



	
?>