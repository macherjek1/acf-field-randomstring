<?php
/*
Plugin Name: Advanced Custom Fields: Random String
Plugin URI: http://www.github.com/macherjek1
Description: Random String Generator Add-On for the Advanced Custom Fields plugin
Version: 0.0.3
Author: Macherjek
Author URI: http://www.macherjek.at
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-randomstring', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );


// 3. Include field type for ACF4
function register_fields_randomstring() {
	require_once(__DIR__ . '/acf-randomstring-v5.php');
}

add_action('acf/include_field_types', 'register_fields_randomstring');
//add_action('acf/register_fields', 'register_fields_hidden');
?>
