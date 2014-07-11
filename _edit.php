<?php
/*
 * Settings Page, It's required by WPWSLGeneral Class only.
 *
 */
function redirect(){
	$redirect = '<script type="text/javascript">';
	$redirect .= 'window.location = "' . menu_page_url(WPWSL_GENERAL_PAGE,false). '"';
	$redirect .= '</script>';
	echo $redirect;
}

if(isset($_GET['edit'])){
	$current_id=$_GET['edit'];
}else{
	$current_id='';
}

if(isset($_GET['delete'])){
	$current_id=$_GET['delete'];
	if($current_id!=''){
		wp_delete_post($current_id,true);
	}
	redirect();
}

/*
 * Save contents
 */

if(isset($_POST['submit-save-exit']) || isset($_POST['submit-save'])){
	
	$_post_title=isset($_POST['post_title'])?$_POST['post_title']:'';
	$_post_status=isset($_POST['post_status'])?'publish':'draft';
	
	if($current_id==''){
		$_post = array(
			  'post_title'    => $_post_title,
			  'post_status'   => $_post_status,
			  'post_type'     => 'wpwsl_template',
			  'comment_status' => 'closed',
		);
		$current_id=wp_insert_post( $_post, true);
	}else{
		$_post = array(
			  'ID'    		  => $current_id,
			  'post_title'    => $_post_title,
			  'post_status'   => $_post_status,
			  'post_type'     => 'wpwsl_template',
			  'comment_status' => 'closed',
		);
		wp_update_post($_post);
	}
	
	if(isset($_POST['key'])){
		$_key=str_replace( ' ', '',$_POST['key']);
		$_key=str_replace( '，', ',',$_key);
		update_post_meta($current_id, '_keyword',strtolower($_key));
	}
		
	if(isset($_POST['trigger'])){
		//make sure only one 'default' and 'subscribe'.
		$current_trigger=$_POST['trigger'];
		if($current_trigger!=''){
			$args = array(
					'post_type' => 'wpwsl_template',
					'posts_per_page' => -1,
					'orderby' => 'date',
					'post_status' => 'any',
					'order'=> 'DESC',
					'meta_query' => array(
							array(
								'key' => '_trigger',
								'value' => '-',
								'compare'=> '!='
							)
					)
			);
			
			$raw=get_posts($args);

	
			foreach($raw as $p){
						
				if($p->ID!=$current_id){

					$target_trigger=get_post_meta($p->ID, '_trigger',TRUE);
					if($current_trigger==$target_trigger){
						update_post_meta($p->ID, '_trigger','-');//replace duplicate to '-' which is default trigger by keyword.
					}
				}
			}
			update_post_meta($current_id, '_trigger',$_POST['trigger']);
		}
	}
		
	if(isset($_POST['type']))
		update_post_meta($current_id, '_type',$_POST['type']);

	
	if(isset($_POST['content'])){
		update_post_meta($current_id, '_content',$_POST['content']);
	}
	
	$_phmsg_group=array();
	
	if(isset($_POST['title']) && isset($_POST['pic']) && isset($_POST['des']) && isset($_POST['url'])){
		$phmsg_length=count($_POST['title']);
		for($i=0; $i<$phmsg_length; $i++){
			$_phmsg_group[$i]=array('title'=>urlencode($_POST['title'][$i]),'pic'=>urlencode($_POST['pic'][$i]),'des'=>urlencode($_POST['des'][$i]),'url'=>urlencode($_POST['url'][$i]));
		}
	}
	delete_post_meta($current_id, '_phmsg_item');
	foreach($_phmsg_group as $_phmsg_item){
		add_post_meta($current_id, '_phmsg_item',json_encode($_phmsg_item));
	}
	
	
	if(isset($_POST['submit-save-exit'])){
		redirect();
	}
}

/*
 * Read contents
 */

$post=get_post($current_id);
$_date=isset($post->post_title)?mysql2date('Y.m.d - G:i', $post->post_date):'-';
$_post_title=isset($post->post_title)?$post->post_title:'';

$_key=get_post_meta($current_id,'_keyword',TRUE);

//trigger
$_trigger=get_post_meta($current_id,'_trigger',TRUE);
if($_trigger==''){
	$_trigger='-';
}

$trigger_options=array(
				'-'=>__('Normal','WPWSL'),
				'default'=>__('Default','WPWSL'),
				'subscribe'=>__('Subscribed','WPWSL'),
				);

//text message
$_content=get_post_meta($current_id,'_content',TRUE);

//photo message

$_phmsg_group=get_post_meta($current_id,'_phmsg_item');
if($_phmsg_group==''){
	$_phmsg_group=array();
}

$_phmsg_main=new stdClass();
if(isset($_phmsg_group[0])){
	$_phmsg_main=json_decode($_phmsg_group[0]);
}

$default_pic=WPWSL_PLUGIN_URL.'/img/trans.png';

if(!isset($_phmsg_main->title)){
	$_phmsg_main->title='';
	$_phmsg_main->pic='';
	$_phmsg_main->des='';
	$_phmsg_main->url='';
}else{
	$_phmsg_main->title=urldecode($_phmsg_main->title);
	$_phmsg_main->pic=urldecode($_phmsg_main->pic);
	$_phmsg_main->des=urldecode($_phmsg_main->des);
	$_phmsg_main->url=urldecode($_phmsg_main->url);
}
$_current_pic=$_phmsg_main->pic==''?$default_pic:$_phmsg_main->pic;


array_shift($_phmsg_group);
$_tmp_phmsg_group=array();
foreach($_phmsg_group as $item){
	$_tmp_item=json_decode($item);
	$_tmp_item->title=urldecode($_tmp_item->title);
	$_tmp_item->pic=urldecode($_tmp_item->pic);
	$_tmp_item->des=urldecode($_tmp_item->des);
	$_tmp_item->url=urldecode($_tmp_item->url);

	$_tmp_phmsg_group[]=$_tmp_item;
}
$_phmsg_group=$_tmp_phmsg_group;

//switch type
$type=get_post_meta($current_id,'_type',TRUE);
$type_options=array(
				'text'=>__('Text (Plain text)','WPWSL'),
				'news'=>__('News (Picture with text)','WPWSL')
				);
				

switch($type){
	case "news":
		$display_resp_msg='style="display:none"';
		$display_resp_phmsg='style="display:block"';
	break;
	default:
		$display_resp_phmsg='style="display:none"';
		$display_resp_msg='style="display:block"';
}

//switch status
$_post_status=isset($post->post_status)?$post->post_status:'';
$_status=($_post_status=='publish')?'checked':'';

//Load content
require_once( 'content.php' );
?>
<link href="<?php echo WPWSL_PLUGIN_URL;?>/css/style.css" rel="stylesheet">
<div class="wrap">
	<?php echo $content['header'];?>
	<?php echo $content['tips_contect'];?>
	<hr>
	<h2><?php _e('Edit Reply Template','WPWSL');?></h2>
	<br>

		<div class="postbox">
			<div class="inside">
				<form action="" method="post" class="edit-template-form">
					<input type="hidden" name="edit" value="<?php echo $current_id;?>" />
					<input type="hidden" name="page" value="<?php echo WPWSL_GENERAL_PAGE;?>" />
						<h3><?php _e('Basic Settings','WPWSL');?></h3>
						<table class="form-table">
						    <tr valign="top">
							    <th scope="row"><label><?php _e('Template Title','WPWSL');?></label></th>
							    <td>
							    	<input type="text" name="post_title" value="<?php echo $_post_title;?>" class="large-text"/>
							    	<p class="description"><?php _e('Title of this template, only for easier to manage it.','WPWSL');?></p>
							    </td>
						    </tr>
						    <tr valign="top">
						        <th scope="row"><label><?php _e('Date','WPWSL');?></label></th>
						        <td>
						        	<p><?php echo $_date;?></p>
						        </td>
						    </tr>
						    <tr valign="top">
						        <th scope="row"><label><?php _e('Keyword','WPWSL');?></label></th>
						        <td>
						        	<input type="text" name="key" value="<?php echo $_key;?>" class="large-text"/>
						        	<p class="description"><?php _e('Subscribers enter keywords to reply with this message. Multiple keywords separate by &quot;,&quot; . etc., &quot;Hi,one,food,168&quot;. Keywords is only plain text with out space, and not case sensitive.','WPWSL');?></p>
						        </td>
						    </tr>
						    <tr valign="top">
						        <th scope="row"><label><?php _e('Trigger','WPWSL');?></label></th>
						        <td>
						        		<?php foreach($trigger_options as $key=>$val):?>
						        		<?php $checked=($key==$_trigger)?'checked':'';?>
						        		<label><input type="radio" name="trigger" value="<?php echo $key;?>" <?php echo $checked;?>><?php echo $val;?></label>&nbsp;&nbsp;
						        		<?php endforeach;?>
						        	<p class="description"><?php _e('You can set this message trigger by special condition, special trigger is higher priority than keywords.','WPWSL');?></p>
						        	<ul class="description deslist">
						        		<li><?php _e('&quot;Normal&quot;: Trigger by keyword.','WPWSL');?></li>
						        		<li><?php _e('&quot;Default&quot;: trigger by any unknown keyword.','WPWSL');?></li>
						        		<li><?php _e('&quot;Subscribed&quot;: trigger by new subscriber join in.','WPWSL');?></li>
						        	</ul>
						        </td>
						    </tr>
						    <tr valign="top">
						        <th scope="row"><label><?php _e('Publish','WPWSL');?></label></th>
						        <td>
						        	<label>
						        		<input type="checkbox" name="post_status" value="publish" <?php echo $_status;?>/>
						        		<?php _e('Is Publish ?','WPWSL');?>
						        	</label>
						        	<p class="description"><?php _e('Check &quot;Publish&quot; to activate this message, otherwise deactivate as &quot;Draft&quot;.','WPWSL');?></p>
						        </td>
						    </tr>
						    <tr valign="top">
						        <th scope="row"><label><?php _e('Type','WPWSL');?></label></th>
						        <td>
						        	<select name="type" id="msg_type">
						        		<?php foreach($type_options as $key=>$val):?>
						        		<?php $selected=($key==$type)?'selected':'';?>
						        		<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val ;?></option>
						        		<?php endforeach;?>
						        	</select>
						        	<p class="description"><?php _e('Select your Template type.','WPWSL');?></p>
						        </td>
						    </tr>
						</table>
						<div id="resp_msg" <?php echo $display_resp_msg;?>>
							<hr>
							<h3><?php _e('Text Message','WPWSL');?></h3>
							<div class="msg-box">
								<table class="form-table">
								    <tr valign="top">
								    	<th scope="row"><label><?php _e('Content','WPWSL');?></label></th>
									    <td>
									    	<textarea name="content" rows="10" class="large-text"><?php echo $_content;?></textarea>
									    	<p class="description"><?php _e('Only plain text, without any script.','WPWSL');?></p>
									    </td>
								    </tr>
								</table>
							</div>
						</div>
						<div id="resp_phmsg" <?php echo $display_resp_phmsg;?>>
							<hr>
							<h3><?php _e('News Message','WPWSL');?></h3>
							<div id="phmsg-base">
								<div class="msg-box">
									<h3 rel="title" class="msg-box-title" data-subtitle="<?php _e('Sub','WPWSL');?>"><?php _e('Main Photo and Text','WPWSL');?></h3>
									<div class="func-msg-box"><a href="#" class="up-msg-box-btn">&nbsp;</a>&nbsp;<a href="#" class="down-msg-box-btn">&nbsp;</a></div>
									<div class="clear"></div>
									<table class="form-table">
										<tr valign="top">
											<th scope="row">
												<label><?php _e('Title','WPWSL');?></label>
											</th>
											<td>
												<input type="text" name="title[]" value="<?php echo $_phmsg_main->title;?>" class="large-text"/>
												<p class="description"><?php _e('Only plain text, without any script.','WPWSL');?></p>
											</td>
										</tr>
										<tr valign="top">
											<th scope="row">
												<label><?php _e('Pic URL','WPWSL');?></label>
											</th>
											<td>
												<div class="preview-box">
													<img src="<?php echo $_current_pic;?>" data-default_pic="<?php echo $default_pic;?>"/>
													<a href="#" class="remove-pic-btn"><?php _e('Remove','WPWSL');?></a>
												</div>
												<input type="hidden" name="pic[]" value="<?php echo $_phmsg_main->pic;?>" rel="img-input" class="img-input large-text"/>
												<button class='custom_media_upload button'><?php _e('Upload','WPWSL');?></button>
												<p class="description"><?php _e('Add Picture for this message.','WPWSL');?></p>
											</td>
										</tr>
										<tr valign="top">
											<th scope="row">
												<label><?php _e('Description','WPWSL');?></label>
											</th>
											<td>
												<input type="text" name="des[]" value="<?php echo $_phmsg_main->des;?>" class="large-text"/>
												<p class="description"><?php _e('Leave it empty if you wont have description of this message. Only plain text, without any script.','WPWSL');?></p>
											</td>
										</tr>
										<tr valign="top">
											<th scope="row">
												<label><?php _e('URL','WPWSL');?></label>
											</th>
											<td>
												<input type="text" name="url[]" value="<?php echo $_phmsg_main->url;?>" class="large-text"/>
												<p class="description"><?php _e('The URL you want direct to. etc., http://www.tinforce.com','WPWSL');?></p>
											</td>
										</tr>
									</table>
									<div class="func-footer"><a href="#" class="remove-msg-box-btn"><?php _e('Remove','WPWSL');?></a>&nbsp;&nbsp;</div>
								</div>
							</div>
							<div id="phmsg-group"></div>
							<?php echo $content['tips_phmsg'];?>
							<div class="add-phmsg">
								<a href="#" class="button button-large" id="add-phmsg-btn"><?php _e('+ Add More Sub Message','WPWSL');?></a>
							</div>
						</div>
					<hr>
					<div class="func-submit">
						<?php submit_button(__('Save and exit','WPWSL'),'primary','submit-save-exit', false); ?>&nbsp;&nbsp;
						<?php submit_button(__('Save','WPWSL'),'secondary','submit-save', false); ?>&nbsp;
						<a href="<?php echo menu_page_url(WPWSL_GENERAL_PAGE,false);?>" class="button secondary"><?php _e('Cancel','WPWSL');?></a>
					</div>
					<div class="clear"></div>
					<?php if($current_id!=''):?>
					<div class="func-delete">
						<a href="<?php echo menu_page_url(WPWSL_GENERAL_PAGE,false).'&delete='.$current_id;?>"><?php _e('Delete','WPWSL');?></a>
					</div>
					<?php endif;?>
				</form>
			</div>
		</div>
</div>
<script>
var limit_phmsg=9;
var count_phmsg=0;

jQuery(document).ready(function ($) {
	
	if($('#msg_type').length>0){
		$('#msg_type').change(function(){
			switch($('#msg_type').val()){
				case 'text':
					$('#resp_msg').show();
					$('#resp_phmsg').hide();
				break;
				case 'news':
					$('#resp_msg').hide();
					$('#resp_phmsg').show();
				break;
			}
		});
	}
	
	$('.remove-pic-btn').click(function(){
		var input=$(this).parent().next('input[rel="img-input"]');
		
		input.val('');
		input.trigger("change");
		return false;
	});
	
	$('input[rel="img-input"]').each(function(){
		$(this).change(function(){
			var img=$($(this).parent().children('.preview-box').children('img'));
			if($(this).val()==''){
				var pic_url=img.data('default_pic');
				img.next('.remove-pic-btn').hide();
			}else{
				var pic_url=$(this).val();
				console.log(img.next('.remove-pic-btn'));
				img.next('.remove-pic-btn').show();
			}
			img.attr('src', pic_url);
		});
	});
	
	$('#add-phmsg-btn').click(function(){
		add_phmsg_box();
		sort_phmsg_box();
		return false;
	});
	
	$('.remove-msg-box-btn').click(function(){
		remove_phmsg_box($(this).parent().parent());
		sort_phmsg_box();
		return false;
	});
	
	$('.up-msg-box-btn').click(function(){
		move_phmsg_box($(this).parent().parent(),true);
		sort_phmsg_box();
		return false;
	});
	
	$('.down-msg-box-btn').click(function(){
		move_phmsg_box($(this).parent().parent(),false);
		sort_phmsg_box();
		return false;
	});
	
	function add_phmsg_box(title,pic,des,url){
		var title = typeof title !== 'undefined' ? title : '';
		var pic = typeof pic !== 'undefined' ? pic : '';
		var des = typeof des !== 'undefined' ? des : '';
		var url = typeof url !== 'undefined' ? url : '';
	
		count_phmsg++;
		if(count_phmsg<=limit_phmsg && count_phmsg>0){
			var tpl=$($('#phmsg-base .msg-box')[0]);
			var clone=tpl.clone(true);
			var subtitle=clone.children('h3[rel="title"]').data('subtitle');
			clone.children('h3[rel="title"]').html(subtitle+'.'+count_phmsg);
			
			clone.find('.preview-box img').each(function(){
				$(this).attr('src', '');
			});
			
			clone.find('input').each(function(){
				if($(this).attr('name')=='title[]'){
					$(this).val(title);
				}
				if($(this).attr('name')=='pic[]'){
					$(this).val(pic);
					$(this).trigger("change");
				}
				if($(this).attr('name')=='des[]'){
					$(this).val(des);
				}
				if($(this).attr('name')=='url[]'){
					$(this).val(url);
				}
			});
			$('#phmsg-group').append(clone);
		}
		if(count_phmsg>=limit_phmsg){
			$('#add-phmsg-btn').hide();
		}
	}
	
	function remove_phmsg_box(obj){
		obj.remove();
		count_phmsg--;
	}
	
	function move_phmsg_box(obj,direct){
		
		if(direct){
			var prv=obj.prev('.msg-box');
			if(prv!=''){
				prv.before(obj);
			}
		}else{
			var nex=obj.next('.msg-box');
			if(nex!=''){
				nex.after(obj);
			}
		}
	}
	
	function sort_phmsg_box(){
		var length=$('#phmsg-group .msg-box').length;
		for(var i=0; i<length;i++){
			var cur=$($('#phmsg-group .msg-box')[i]);
			var subtitle=cur.children('h3[rel="title"]').data('subtitle');
			cur.children('h3[rel="title"]').html(subtitle+'.'+(i+1));
		}
	}
	
	<?php foreach($_phmsg_group as $item):?>
		add_phmsg_box('<?php echo $item->title;?>','<?php echo $item->pic;?>','<?php echo $item->des;?>','<?php echo $item->url;?>');
	<?php endforeach;?>
});
</script>