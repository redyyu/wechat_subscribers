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
	wp_register_script('easydialog', WPWSL_PLUGIN_URL.'/js/easydialog.min.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('easydialog');
}
//Set ajax callback function
add_action( 'wp_ajax_add_foobar', 'prefix_ajax_add_foobar' );
function prefix_ajax_add_foobar(){

        $targetID = $_GET['tid'];
        $posts_per_page = 5;
        $current = isset($_GET['cur'])?$_GET['cur']:1;
        
		$offset = ($current-1)*$posts_per_page;
		$post_type = isset($_GET['ptype'])&&$_GET['ptype']=="page" ?"page":"post";
		if (isset($_GET['catid'])&&$_GET['catid']!="default"){
			    $published_posts = get_category($_GET['catid'])->count;
	    }else{
	        //count all posts 
			if($post_type=="post"){
			    $published_posts = wp_count_posts("post")->publish;
		    }else if ($post_type =="page") {
		    	$published_posts = wp_count_posts("page")->publish;
		    }
	    }
	    if(isset($_GET['key'])&&trim($_GET['key'])!=""){
	    	global $wpdb;
	    	$str = urldecode($_GET['key']);
	    	$published_posts = $wpdb->get_results("select ID,post_date,post_title,post_type from wp_posts where post_status = 'publish' and post_title LIKE '%{$str}%' order by post_title asc limit 30 ");
	        $published_posts = count($published_posts);
	    }


		$pageselect = $post_type =="page" ? 'selected="selected"' : null;
		$postselect = $post_type =="post" ? 'selected="selected"' : null;
		//show cates list
		 $args_cate = array(
		'type'                     => 'post',
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'taxonomy'                 => 'category',
		'pad_counts'               => false 
		);
	    $catelist =  get_categories( $args_cate );
	    $cateoptions = "<option value='default' value='default' class='select_cate_choose' >".__('All categories','WPWSL')."</option>";
	    foreach ($catelist as $key) {
	    	if( $_GET['catid']== $key->term_id)
	    	$cateoptions .= "<option class='select_cate_choose' value='".$key->term_id."' selected='selected'>".$key->cat_name."</option>";
	        else
	        $cateoptions .= "<option class='select_cate_choose' value='".$key->term_id."' >".$key->cat_name."</option>";
	    }
	    $args = array(
	    'offset'           => $offset,	
		'posts_per_page'   => $posts_per_page,
		'orderby'          => 'post_date',
		'order'            => 'ASC',
		'post_type'        => $post_type,
		'post_status'      => 'publish'
		);
		
		if(isset($_GET['catid'])&&$_GET['catid']!="default") $args['category'] = $_GET['catid'];
		
        if($published_posts%$posts_per_page==0)
        $total = ((int)$published_posts/$posts_per_page);
        else
		$total = ((int)$published_posts/$posts_per_page)+1;
        
        //get posts
	    $typeORcate = __('Category','WPWSL');
		if(isset($_GET['key'])&&trim($_GET['key'])!=""){
            $str = urldecode($_GET['key']);
            $searchKeyInput = trim($_GET['key']);
            $typeORcate = __('Type','WPWSL');
            $start = $offset;
            $end   = $offset+$posts_per_page;
		    $posts_array = $wpdb->get_results("select ID,post_date,post_title,post_type from wp_posts where post_status = 'publish' and post_title LIKE '%{$str}%' order by post_title asc limit $start,$end");
            
		}else{
		    $posts_array = get_posts( $args );
		}
		$args_paginate = array(
		'format'       => '#%#%',
		'total'        => $total,
		'current'      => $current,
		'show_all'     => false,
		'end_size'     => 3,           
		'mid_size'     => 2,          
		'prev_next'    => True,
		'prev_text'    => __('«'),
		'next_text'    => __('»')
		);

	_e('<input type="hidden" id="hidden_post_tid" value="'.$_GET['tid'].'">
		<input type="hidden" id="hidden_post_type" value="'.$_GET['rtype'].'">
		<input type="hidden" id="hidden_search_key" value="'.$searchKeyInput.'">
		<div class="tablenav top">
          <div class="alignleft actions bulkactions">
		  <select id="select_type_action">
          <option value="post" class="select_type_choose"  '.$postselect.'>'.__('Articles','WPWSL').'</option>
	      <option value="page" class="select_type_choose"  '.$pageselect.'>'.__('Pages','WPWSL').'</option>
	      </select>
		  </div>
		  <div class="alignleft actions" id="select_cate_conatiner">
		  <select id="select_cate_action">'.$cateoptions.'</select>
         </div>
         <div class="alignleft actions">
         <label class="screen-reader-text" for="post-search-input"></label>
         <input id="post-search-key" type="search" value="'.$searchKeyInput.'" style="padding-top:5px;padding-bottom:4px;"></input>
         <input id="post-search-submit" class="button" type="submit" value="'.__('Search','WPWSL').'"></input>
         </div>
         <a href="#" id="easydialog_close">✕</a>
	     <br class="clear">
	     </div>
	     <table class="wp-list-table widefat fixed posts" style="min-height:100px;">');
    if(count($posts_array)==0){
        _e("<thead><tr><th style='text-align:center;height: 77px;'>".__('Search results is empty....','WPWSL')."</th></tr></thead>");
    }else{
    _e("<thead><tr><th class=''>".__('Title','WPWSL')."</th><th>".$typeORcate."</th><th>".__('Create Date','WPWSL')."</th><th>".__('Action','WPWSL')."</th></tr></thead>
    	<tbody>");
        $i=1;
	    foreach ($posts_array as $key) {
	    	if($key->post_type=="post"){
		    	//get cates
		    	$post_categories  =  wp_get_post_categories($key->ID);
		    	$cats = "";
				foreach($post_categories as $c){
					$cat = get_category($c);
					$cats .= ",".$cat->name;
				}
				$cats = substr($cats,1);
				if(isset($_GET['key'])){
					$cats = __('Articles','WPWSL').":".$cats; 	
				}
			}else if($key->post_type=="page"){
			 	 $cats = "-";
			 	 if(isset($_GET['key'])){
				 $cats = __('Pages','WPWSL'); 	
				 }
			}
			if($i%2!=0) $trclass = "one";else $trclass = "two";
			$i++;
	    	_e("<tr class='$trclass'><td>".$key->post_title."</td><td>".$cats."</td><td>".$key->post_date."</td><td><button class='insert_content_to_input' postid='".$key->ID."' tid='".$targetID."'>".__('Insert','WPWSL')."</button></td></tr>");
	    }
    }
    _e('</tbody></table><div id="paginate_div">'.paginate_links($args_paginate).'</div>');
 
    die();
}

add_action( 'wp_ajax_get_insert_content', 'prefix_ajax_get_insert_content' );
function prefix_ajax_get_insert_content(){
	if($_GET['rtype']=="posts"){
	        $myrow = get_post($_GET['postid']);
	        $post_categories  =  wp_get_post_categories($myrow->ID);
	    	$cats = "";
			foreach($post_categories as $c){
				$cat = get_category($c);
				$cats .= ",".$cat->name;
			}
			$cats = substr($cats,1);
			require_once('simple_html_dom.php');
            $post = htmlspecialchars_decode($myrow->post_content);
    		$html = str_get_html($post);

			$rpost = "#".$myrow->post_title."#[".$myrow->post_date."]{".$html->plaintext."}~".$myrow->post_date."~";
			$r = array(
				"status" => "success",
				"data"   => $rpost
				);
	}else if($_GET['rtype']=="urls"){
        $myrow = get_post($_GET['postid']);
        $r = array(
        	"status"=>"success",
            "data"  =>$myrow->guid
        	);
	}else{
		$r = array(
				"status" => "error",
				"data"   => "rtype error!"
				);
	}
	_e(json_encode($r));
	die();
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
