<?php
/*
 * Settings Page, It's required by WPWSLGeneral Class only.
 *
 */
require_once( 'class-wpwsl-list-table.php' );

if(isset($_GET['action']) && isset($_GET['action2'])){
	if($_GET['action']=='delete' || $_GET['action2']=='delete'){
		if(isset($_GET['tpl'])){
	        foreach($_GET['tpl'] as $tpl){
	        	delete_template($tpl);
	        }
        }
	}
}
if(isset($_GET['delete'])){
	delete_template($_GET['delete']);
}

function delete_template($id){
	if(!is_wp_error(get_post($id))){
		wp_delete_post($id,true);
	}
}

$args = array(
		'post_type' => 'wpwsl_template',
		'posts_per_page' => -1,
		'orderby' => 'post_date',
		'post_status' => 'any',
		'order'=> 'ASC'
);

$raw=get_posts($args);

$all_keys=array();
foreach($raw as $e){
  if(get_post_meta($e->ID,'_trigger',TRUE)!='-'){
    continue;
  }
  $tmp_key_str=trim(get_post_meta($e->ID,'_keyword',TRUE));
  $tmp_keys=explode(',', $tmp_key_str);
  foreach($tmp_keys as $_k){
    $all_keys[] = $_k;
  }
}

$data=array();
foreach($raw as $d){
	$status=$d->post_status;

	$tmp_key=trim(get_post_meta($d->ID,'_keyword',TRUE));
	$key=$tmp_key;
	$array_key=explode(',', $tmp_key);

  if(count($array_key)>0){
    foreach($array_key as $k){
      if($k!=''){
        $count_dup_key = 0;
        foreach($all_keys as $k2){
          if(strtolower(trim($k))==strtolower(trim($k2))){
            $count_dup_key++;
          }
          if ($count_dup_key > 1){
            $conflicted='<br><span class="msg_conflict">'.__('Conflict','WPWSL').'[<i>'.$k.'</i>]</span>';
            $key=$key.$conflicted;
            break;
          }
        }
      }
    }
  }

	$type=get_post_meta($d->ID,'_type',TRUE);
	$_trigger=get_post_meta($d->ID,'_trigger',TRUE);

	switch($_trigger){
		case 'default':
			$key='<span class="msg_highlight">'.__('*Default*','WPWSL').'</span>';
		break;
		case 'subscribe':
			$key='<span class="msg_highlight">'.__('*Subscribed*','WPWSL').'</span>';
		break;
	}
	if($d->post_status!='publish'){
		$key='<span class="msg_disabled">'.__('*Deactivation*','WPWSL').'</span>';
	}
	$post_title=$d->post_title?$d->post_title:__('(empty)','WPWSL');
	$data[]=array('ID'=>$d->ID, 'title'=>$post_title, 'type'=>$type, 'date'=>mysql2date('Y.m.d', $d->post_date), 'trigger_by' => $key);
}

//Prepare Table of elements
$wp_list_table = new WPWSL_List_Table($data);
$wp_list_table->prepare_items();

//Load content
require_once( 'content.php' );
?>
<link href="<?php echo WPWSL_PLUGIN_URL;?>/css/style.css" rel="stylesheet">
<div class="wrap">
	<?php echo $content['header'];?>
	<?php echo $content['tips_content'];?>
	<p class="header_func">
		<?php if(current_user_can('manage_options')):?>
		<a href="<?php menu_page_url(WPWSL_SETTINGS_PAGE);?>"><?php _e('Settings','WPWSL');?></a>
		<?php endif;?>
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.imredy.com/wp_wechat/" target="_blank"><?php _e('Help','WPWSL');?></a>
	</p>
	<hr>
	<h2>
	<?php _e('Custom Replies','WPWSL');?>
	<a href="<?php menu_page_url(WPWSL_GENERAL_PAGE);?>&edit" class="add-new-h2"><?php _e('Add New Reply','WPWSL');?></a>
	</h2>
	<br>
	<!--<ul class='subsubsub'>
		<li class='all'><a href='<?php menu_page_url( WPWSL_GENERAL_PAGE);?>' class="current">All<span class="count"> (0) </span></a> |</li>
		<li class='publish'><a href='<?php menu_page_url( WPWSL_GENERAL_PAGE);?>&post_status=publish'>Published<span class="count"> (0) </span></a> |</li>
		<li class='trash'><a href='<?php menu_page_url( WPWSL_GENERAL_PAGE);?>&post_status=trash'>Trash<span class="count"> (0) </span></a></li>
	</ul>-->
	<form action="" method="get">
		<input type="hidden" name="page" value="<?php echo WPWSL_GENERAL_PAGE;?>" />
		<?php $wp_list_table->display(); ?>
	</form>
</div>