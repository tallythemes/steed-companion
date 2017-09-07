<?php
/**
Plugin Name: Steed Companion
Plugin URI: tallythemes.com/product/steed-companion/
Description: Enhances Steed’s themes with extra functionalities.
Version: 1.0.999
Author: TallyThemes
Author URI: http://tallythemes.com/
License: GPLv2 or later
Text Domain: steed-companion
Prefix: SteedCOM_ / STEEDCOM_
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA..
*/

// Make sure we don't expose any info if called directly

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}



define( 'STEEDCOM_URL', plugin_dir_url( __FILE__ ) );
define( 'STEEDCOM_DRI', plugin_dir_path( __FILE__ ) );



/*
	Load the plugin in a safe action
------------------------------------------*/
add_action( 'after_setup_theme', 'SteedCOM_load' );
function SteedCOM_load(){
	
}


/*
	Load some Admin side CSS and JavaScript
	files.
------------------------------------------*/
function SteedCOM_admin_script() {
	wp_enqueue_style( 'steed-companion-admin', STEEDCOM_URL . '/assets/css/steed-companion-admin.css');
	wp_enqueue_script( 'steed-companion-admin', STEEDCOM_URL.'/assets/js/steed-companion-admin.js', array('jquery'), '', true ); 
}
add_action( 'admin_enqueue_scripts', 'SteedCOM_admin_script' );


/*
	Load some CSS and JavaScript
	files.
------------------------------------------*/
function SteedCOM_front_script() {
	wp_enqueue_style( 'steed-companion', STEEDCOM_URL . '/assets/css/steed-companion.css');
	wp_enqueue_script( 'steed-companion', STEEDCOM_URL.'/assets/js/steed-companion.js', array('jquery'), '', true ); 
}
add_action( 'wp_enqueue_scripts', 'SteedCOM_front_script' );



/*
	Load Widgets
------------------------------------------*/
function SteedCOM_load_widget() {
	//register_widget( 'SteedCOM_widget_AdvanceText' );
	register_widget( 'SteedCOM_widget_SliderItem' );
	register_widget( 'SteedCOM_widget_vCard' );
	register_widget( 'SteedCOM_widget_quote' );
	register_widget( 'SteedCOM_widget_service' );
}
add_action( 'widgets_init', 'SteedCOM_load_widget' );
//include(STEEDCOM_DRI.'/widgets/advance-text-widget.php');
include(STEEDCOM_DRI.'/widgets/slider-item-widget.php');
include(STEEDCOM_DRI.'/widgets/vCard.php');
include(STEEDCOM_DRI.'/widgets/quote.php');
include(STEEDCOM_DRI.'/widgets/service.php');