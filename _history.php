<?php
/*
 * Settings Page, It's required by WPWSLGeneral Class only.
 *
 */
require_once( 'class-wpwsl-history-table.php' );

function delete_record($id){
	global $wpdb;
    $wpdb->query("delete from wechat_subscribers_lite_keywords where id='$id'");
}
if(isset($_GET['action']) && isset($_GET['action2'])){
	if($_GET['action']=='delete' || $_GET['action2']=='delete'){
		if(isset($_GET['record'])){
	        foreach($_GET['record'] as $r){
	        	 delete_record($r);
	        }
        }
	}
}
function results_order() {
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'time';
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'desc';
		return $orderby." ".$order;
	}


$order = results_order();
$paged = isset($_GET['paged']) ? $_GET['paged'] : 1;
$start = ($paged-1)*300;
global $wpdb;
$raw = $wpdb->get_results("select id,openid,keyword,is_match,time from wechat_subscribers_lite_keywords order by $order limit $start,300");
$data=array();
foreach($raw as $d){
	 $d->is_match = $d->is_match=="y"? __("Yes","WPWSL") :"<span style='color:red;'>".__("No","WPWSL")."<span>";
	 $data[]=array('ID'=>$d->id, 'openid'=>$d->openid, 'keyword'=>$d->keyword, 'is_match' =>$d->is_match, 'time'=>$d->time);
}

//Prepare Table of elements 
$wp_list_table = new WPWSL_History_Table($data);
$wp_list_table->prepare_items();

//Load content
require_once( 'content.php' );
?>
<link href="<?php echo WPWSL_PLUGIN_URL;?>/css/style.css" rel="stylesheet">
<div class="wrap">
	<?php echo $content['header'];?>
	<hr>
	<h2><?php _e('Statistics','WPWSL');?> <a href="<?php menu_page_url(WPWSL_GENERAL_PAGE);?>" class="add-new-h2"><?php _e('Reply Templates',"WPWSL");?></a></h2>
	<br>
	<form action="" method="get">
		<input type="hidden" name="page" value="<?php echo WPWSL_GENERAL_PAGE;?>" />
		<input type="hidden" name="keywords" value="true" />
		<input type="hidden" name="per_page" value="<?php _e($per_page); ?>" />
		<?php $wp_list_table->display();?>
	</form>
</div>