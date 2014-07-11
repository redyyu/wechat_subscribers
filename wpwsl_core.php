<?php
/**
 * Plugin Name: WeChat Subscribers Lite
 * Plugin URI: http://www.imredy.com/wp_wechat/
 * Description: 轻便易用的微信(weixin)公众平台订阅号管理工具。Light weight WeChat (Subscribers) public platform management tool. 
 * Version: 1.04
 * Author: Redy Ru
 * Author URI: http://www.imredy.com/
 * License: GPLv2 or later
 * Text Domain: WPWSL
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define('WPWSL_PLUGIN_URL', plugins_url('', __FILE__));
define('WPWSL_GENERAL_PAGE', 'wpwsl-general-page');
define('WPWSL_SETTINGS_PAGE', 'wpwsl-settings-page');
define('WPWSL_SETTINGS_OPTION', 'wpwsl_settings_option');


//Interface
$options=get_option(WPWSL_SETTINGS_OPTION);
$token=isset($options['token'])?$options['token']:'';

if($token!='' && isset($_GET[$token])){
	require( 'interface.php' );
}

//Languages
add_action('plugins_loaded', 'load_languages_file');
function load_languages_file(){
	load_plugin_textdomain( 'WPWSL', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


//Setup Admin
add_action('_admin_menu', 'wpwsl_admin_setup');
function wpwsl_admin_setup(){
	require_once( 'posttype_wpwsl_template.php' );
	$page_title=__('WeChat Subscribers Lite', 'WPWSL');
	$menu_title=__('WeChat Subscribers Lite', 'WPWSL');
	$capability='edit_posts';
	$menu_slug=WPWSL_GENERAL_PAGE;
	$function='';
	$icon_url=WPWSL_PLUGIN_URL.'/img/wpwsl_icon_16.png';
	add_object_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url );
	
	
	require_once( 'class-wpwsl-settings.php' );
	require_once( 'class-wpwsl-general.php' );
	//Settings
	$settingObject=WPWSL_Settings::get_instance();	
	//General
	$generalObject=WPWSL_General::get_instance();
}

//Safe Redirect
add_action('admin_init', 'safe_redirect', 999);
function safe_redirect(){
	if ( isset($_GET['_wp_http_referer'])){
		wp_redirect( remove_query_arg( array( '_wp_http_referer', '_wpnonce' ), stripslashes( $_SERVER['REQUEST_URI'] ) ) );
	}
}

//Scripts
add_action('admin_print_scripts', 'custom_admin_scripts');
//add custom upload jquery support.
function custom_admin_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_media();
	
	wp_register_script('custom-upload', WPWSL_PLUGIN_URL.'/js/custom_upload.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('custom-upload');
}

// Add settings link on plugin page
function wpwsl_plugin_settings_link($links) { 
  $settings_link = '<a href="'.menu_page_url( WPWSL_SETTINGS_PAGE,false).'">'.__('Settings','WPWSL').'</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'wpwsl_plugin_settings_link' );
?>