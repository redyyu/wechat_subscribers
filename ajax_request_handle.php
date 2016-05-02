<?php
//Set ajax callback function
add_action( 'wp_ajax_add_foobar', 'prefix_ajax_add_foobar' );
function prefix_ajax_add_foobar(){
    $targetID = $_GET['tid'];
    $posts_per_page = 6;
    $current = isset($_GET['cur'])?$_GET['cur']:1;

		$offset = ($current-1)*$posts_per_page;
		$post_type = isset($_GET['ptype']) ? $_GET['ptype'] : "post";

		if (isset($_GET['catid'])&&$_GET['catid']!="default"){
			    $published_posts = get_category($_GET['catid'])->count;
	    }else{
	        //count all posts
			$published_posts = wp_count_posts($post_type)->publish;
	    }
	    if(isset($_GET['key'])&&trim($_GET['key'])!=""){
	    	global $wpdb;
	    	$str = urldecode($_GET['key']);
	    	$published_posts = $wpdb->get_results("select ID,post_date,post_title,post_type from wp_posts where post_status = 'publish' and post_title LIKE '%{$str}%' order by post_title asc limit 30 ");
	        $published_posts = count($published_posts);
	    }
		//show cates list
		 $args_cate = array(
		'type'                     => 'post',
		'orderby'                  => 'name',
		'order'                    => 'name ASC',
		'taxonomy'                 => 'category',
		'pad_counts'               => false
		);
	    $catelist =  get_categories( $args_cate );
	    $cateoptions = "<option value='default' value='default' class='select_cate_choose' >".__('All categories','WPWSL')."</option>";
	    foreach ($catelist as $key) {
	    	if(isset($_GET['catid'])&&$_GET['catid']== $key->term_id)
	    	$cateoptions .= "<option class='select_cate_choose' value='".$key->term_id."' selected='selected'>".$key->cat_name."</option>";
	        else
	        $cateoptions .= "<option class='select_cate_choose' value='".$key->term_id."' >".$key->cat_name."</option>";
	    }
	    $args = array(
	    'offset'           => $offset,
		'posts_per_page'   => $posts_per_page,
		'orderby'          => 'post_date',
		'order'            => 'post_date desc',
		'post_type'        => $post_type,
		);
		if($post_type=="post"||$post_type=="page"){ $args['post_status'] = 'publish';}

		if(isset($_GET['catid'])&&$_GET['catid']!="default") $args['category'] = $_GET['catid'];

    if($published_posts%$posts_per_page==0){
      $total = ((int)$published_posts/$posts_per_page);
    } else {
		  $total = ((int)$published_posts/$posts_per_page)+1;
    }

    //get posts
	  $typeORcate = __('Category','WPWSL');
	  $searchKeyInput = '';
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
    switch ($_GET['rtype']) {
      case 'posts':
      	$button_value = __('Insert','WPWSL').'<span>'.__(' Content','WPWSL').'</span>';
      break;
      case 'urls':
      	$button_value = __('Insert','WPWSL').'<span>'.__(' URL','WPWSL').'</span>';
      break;
      case 'phmsg':
      	$button_value = __('Sync','WPWSL');
    	break;
    }
    $args = array(
     'public'   => true,
     'show_ui'  =>true
    );
		$output = 'objects'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'
		$_re_types= get_post_types( $args, $output, $operator );
		$_post_types = '';
    foreach ($_re_types as $key => $val){
      $selected=($key==$post_type)?'selected = "selected"':'';
    	$_post_types .= '<option value="'.$key.'" class="select_type_choose"  '.$selected.'>'.$val->labels->name.'</option>';
    }

    $isCateShow = $post_type == 'post' ? '' : 'display:none;';

	  _e('<input type="hidden" id="hidden_post_tid" value="'.$_GET['tid'].'">
		<input type="hidden" id="hidden_post_type" value="'.$_GET['rtype'].'">
		<input type="hidden" id="hidden_search_key" value="'.$searchKeyInput.'">
		<div class="tablenav top">
          <div class="alignleft actions bulkactions" id="type_con">
		  <select id="select_type_action">'.$_post_types.'</select>

		  <span style="'.$isCateShow.'">
		  <select id="select_cate_action">'.$cateoptions.'</select>
          </span>

		  </div>

         <div class="alignleft actions" id="search_con">
         <label class="screen-reader-text" for="post-search-input"></label>
         <input id="post-search-key" type="search" value="'.$searchKeyInput.'" style="padding-top:5px;padding-bottom:4px;"></input>
         <input id="post-search-submit" class="button" type="submit" value="'.__('Search','WPWSL').'"></input>
         </div>
         <a href="#" id="easydialog_close">✕</a>
	     <br class="clear">
	     </div>
	</div>
	     <table class="wp-list-table widefat fixed posts" width="100%" style="min-height:100px;padding:10px;">');
    if(count($posts_array)==0){
        _e("<thead><tr><th style='text-align:center;height: 77px;'>".__('Search results is empty....','WPWSL')."</th></tr></thead>");
    }else{
    _e("<thead><tr><th class='' width='40%'>".__('Title','WPWSL')."</th><th width='16%'><div sytle='text-align:center;'>".$typeORcate."</div></th><th width='22%'>".__('Create Date','WPWSL')."</th><th width='22%' style='text-align:center;'>".__('Action','WPWSL')."</th></tr></thead>
    	<tbody>");
      $i=1;
	    foreach ($posts_array as $key) {
	    	$post_categories  =  wp_get_post_categories($key->ID);
	    	if(count($post_categories)>0){
	    	   $cats = '';
				foreach($post_categories as $c){
					$cat = get_category($c);
					$cats .= ','.$cat->name;
				}
				$cats = substr($cats,1);
				if(isset($_GET['key'])){
					$cats = $cats;
				}
	    	}else{
	    		$cats = $key->post_type;
	    		foreach($_re_types as $cat_key => $cat_val){
	    			if($cat_key==$key->post_type){
	    				$cats = '['.$cat_val->labels->name.']';
	    				break;
	    			}

                }
	    	}
			if($i%2!=0) $trclass = 'one';else $trclass = 'two';
			$i++;
	    	_e("<tr class='$trclass'><td>".$key->post_title."</td><td>".$cats."</td><td><div sytle='text-align:center;'>".$key->post_date."</div></td><td style='text-align:center;'><button type='button' class='button button-primary insert_content_to_input' postid='".$key->ID."' tid='".$targetID."'>".$button_value."</button></td></tr>");
	    }
    }
    _e('</tbody></table><div id="paginate_div">'.paginate_links($args_paginate).'</div>');

    die();
}

add_action( 'wp_ajax_get_insert_content', 'prefix_ajax_get_insert_content' );
function prefix_ajax_get_insert_content(){
	if($_GET['rtype']=='posts'){
      $myrow = get_post($_GET['postid']);
      $post_categories  =  wp_get_post_categories($myrow->ID);
	    $cats = '';

			foreach($post_categories as $c){
				$cat = get_category($c);
				$cats .= ','.$cat->name;
			}
			$cats = substr($cats,1);
      $text_title = trim_words($myrow->post_title,SYNC_TITLE_LIMIT);
      $text_content = trim_words($myrow->post_content,
                                 SYNC_CONTENT_LIMIT);
			$rpost = '#'
			         .$text_title
			         .'#'
			         .$text_content
			         .'['
			         .get_permalink($myrow->ID)
			         .']['
			         .$myrow->post_date
			         .']';
			$r = array(
				'status' => 'success',
				'data'   => $rpost
				);
	}else if($_GET['rtype']=='urls'){
	    $myrow = get_post($_GET['postid']);
	    $r = array(
	    	'status'=>'success',
	      'data'  =>get_permalink($myrow->ID)
        );
	}else if($_GET['rtype']=='phmsg'){
    if(isset($_GET['imagesize']) && $_GET['imagesize']=='small'){
      $imageSize = 'sup_wechat_small';
    }else{
      $imageSize = 'sup_wechat_big';
    }

		$myrow = get_post($_GET['postid']);
	  $myrow->pic = WPWSL_PLUGIN_URL.'/img/'.$imageSize.'.png';

    if(get_the_post_thumbnail($_GET['postid'])!=''){
      $_tmp_thumb_id = get_post_thumbnail_id($_GET['postid']);
      $tmp_img_obj= wp_get_attachment_image_src($_tmp_thumb_id,
                                                $imageSize);
      $myrow->pic = $tmp_img_obj[0];
    }else{
    	$attachments = get_posts( array(
    		'post_type' => 'attachment',
    		'posts_per_page' => -1,
    		'post_parent' => $_GET['postid'],
    		'exclude'     => get_post_thumbnail_id($_GET['postid'])
    	));

    	if(count($attachments)>0){
    	  $tmp_img_obj=wp_get_attachment_image_src($attachments[0]->ID,
                                                 $imageSize);
    		$myrow->pic=$tmp_img_obj[0];
    	}
    }
    $myrow->post_title = trim_words($myrow->post_title,SYNC_TITLE_LIMIT);

	  if(trim($myrow->post_excerpt)!=''){
      $myrow->post_content = trim_words($myrow->post_excerpt,
                                        SYNC_EXCERPT_LIMIT);
	  }else{
	    $myrow->post_content = trim_words($myrow->post_content,
                                        SYNC_EXCERPT_LIMIT);
	  }
    $myrow->url = get_permalink($myrow->ID);
    $r = array(
    	    'status'=>'success',
          'data'  => $myrow
    	  );
	}else{
		$r = array(
				  'status' => 'error',
				  'data'   => 'rtype error!'
				);
	}
	print(json_encode($r));
	die();
}
?>