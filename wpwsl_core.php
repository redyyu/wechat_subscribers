<?php
/**
 * Plugin Name: WeChat Subscribers Lite
 * Plugin URI: http://www.imredy.com/wp_wechat/
 * Description: 轻便易用的微信(weixin)公众平台订阅号管理工具。Light weight WeChat (Subscribers) public platform management tool.
 * Version: 2.0
 * Author: Redy Ru,Gu Yue
 * Author URI: http://www.imredy.com/
 * License: GPLv2 or later
 * Text Domain: WPWSL
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define('WPWSL_PLUGIN_URL', plugins_url('', __FILE__));
define('WPWSL_GENERAL_PAGE', 'wpwsl-general-page');
define('WPWSL_HISTORY_PAGE', 'wpwsl-history-page');
define('WPWSL_SETTINGS_PAGE', 'wpwsl-settings-page');
define('WPWSL_SETTINGS_OPTION', 'wpwsl_settings_option');
define("SELECT_ROWS_AMOUNT", 100);
define("SYNC_TITLE_LIMIT", 80);
define("SYNC_CONTENT_LIMIT", 500);
define("SYNC_EXCERPT_LIMIT", 140);

require_once('ajax_request_handle.php');

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
//create db table wechat_subscribers_lite_messages
 global $wpdb;
 $table_name ="wechat_subscribers_lite_keywords"; 
 $sql = "CREATE TABLE $table_name (
  id bigint(20) NOT NULL KEY AUTO_INCREMENT,  
  openid   varchar(100) NOT NULL,
  keyword  varchar(255) NOT NULL,
  is_match char(1)   NOT NULL,
  time     datetime  NOT NULL
  );";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta($sql);
//Setup wechat image size
function set_wechat_img_size(){
	add_image_size( 'sup_wechat_big'  , 360,200, true );
	add_image_size( 'sup_wechat_small', 200,200, true );
}
add_action( 'after_setup_theme','set_wechat_img_size'); 

function sup_wechat_custom_sizes( $sizes ) {
    return array_merge($sizes, array(
        'sup_wechat_big' => __('WeChat big image','WPWSL'),
        'sup_wechat_small' => __('WeChat small image','WPWSL')
    ));
}
add_filter( 'image_size_names_choose', 'sup_wechat_custom_sizes' );



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
	require_once( 'class-wpwsl-history.php' );
	//Settings
	$settingObject=WPWSL_Settings::get_instance();
	//General
	$generalObject=WPWSL_General::get_instance();
	//History
	$hitsotryObject=WPWSL_History::get_instance();
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
	wp_register_script('custom-upload', WPWSL_PLUGIN_URL.'/js/custom_upload.js', array('jquery','media-upload','thickbox'),"2.0");
	wp_enqueue_script('custom-upload');
	wp_register_script('modal', WPWSL_PLUGIN_URL.'/js/modal.js',array(),"2.0");
	wp_enqueue_script('modal');
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
