<?php
/*
 * History page, record subscribers's messages while send to this plugin.
 *
 */

require_once( 'class-wpwsl-history-table.php' );

if(isset($_GET['clear_all_records'])){
	global $wpdb;
	$db_table=DB_TABLE_WPWSL_HISTORY;
    $wpdb->query("delete from $db_table");
}

function delete_record($id){
	global $wpdb;
	$db_table=DB_TABLE_WPWSL_HISTORY;
    $wpdb->query("delete from $db_table where id='$id'");
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
$start = ($paged-1)*SELECT_ROWS_AMOUNT;
global $wpdb;
//history
$db_table=DB_TABLE_WPWSL_HISTORY;
$match   = $wpdb->get_results("select count(id) as count from $db_table where is_match = 'y';");
$unmatch = $wpdb->get_results("select count(id) as count from $db_table where is_match = 'n';");
$match   = $match ? $match[0]->count : 0;
$unmatch = $unmatch ? $unmatch[0]->count : 0;
$unmatch_ = $unmatch == 0 && $match == 0 ? 0 : $unmatch;
$unmatch =  $unmatch == 0 && $match == 0 ? 1 : $unmatch;

//records
$raw = $wpdb->get_results("select id,openid,keyword,is_match,time from $db_table order by $order limit $start,".SELECT_ROWS_AMOUNT);
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
	<h2>
	 <?php _e('Statistics','WPWSL');?>
     <form action="" method="get" style="float:right;">
     <input type="hidden" name="page" value="wpwsl-history-page" />
	 <button  id="clear_all_records" type="submit" name="clear_all_records" value="rows" class="add-new-h2"><?php _e("Clear All Records","WPWSL");?></button>
	 </form>
	</h2>
    <br>
	<form action="" method="get">
		<input type="hidden" name="page" value="<?php echo WPWSL_HISTORY_PAGE;?>" />
		<input type="hidden" name="per_page" value="<?php _e($per_page); ?>" />
		<?php $wp_list_table->display();?>
	</form>
</div>
<script>document.getElementById("clear_all_records").onclick = function(){var r=confirm("<?php _e('Empty all the records ?','WPWSL');?>"); if(!r) return false;}</script>