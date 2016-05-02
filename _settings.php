<?php
/*
 * Settings Page, It's required by WPWSLSettings Class only.
 *
 */

$options=$this->options;

$fields=array('token');

foreach($fields as $field){
	if(!isset($options[$field])){
		$options[$field]='';
	}
}
$interface_url=$options['token']!=''?home_url().'/?'.$options['token']:'none';

$default_img_pic_big=$options['sup_wechat_big']!='' ? $options['sup_wechat_big']:WPWSL_PLUGIN_URL.'/img/sup_wechat_big.png';

$default_img_pic_small=$options['sup_wechat_small'] != '' ? $options['sup_wechat_small']:WPWSL_PLUGIN_URL.'/img/sup_wechat_small.png';

//Load content
require_once( 'content.php' );
?>
<link href="<?php echo WPWSL_PLUGIN_URL;?>/css/style.css" rel="stylesheet">
<div class="wrap">
	<h2><?php _e('WeChat Subscribers Lite','WPWSL')?></h2>
	<form action="options.php" method="POST">
		<?php settings_fields( $this->option_group );?>
		<?php do_settings_sections( $this->page_slug ); ?>
		<hr>
		<h4><?php _e('Account Settings','WPWSL')?></h4>
		<table class="form-table">
      <tr valign="top">
        <th scope="row"><label>Token</label></th>
        <td>
        	<input type="text"
                 size="30"
                 name="<?php echo $this->option_name ;?>[token]"
                 value="<?php echo $options['token'];?>"
                 class="regular-text"/>
        	<p class="description">
            <?php _e('Access verification for your WeChat public platform. Only Latin letter, number, dash and underscore. 30 character limited.','WPWSL')?>
          </p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"><label>URL</label></th>
        <td>
        	<h4><?php echo $interface_url;?></h4>
        	<p class="description">
            <?php _e('First input a TOKEN above and save the settings, then &quot;Copy&quot; and &quot;Bind&quot; this URL to WeChat Platform.','WPWSL')?>
          </p>
        </td>
      </tr>
      <!-- Big Image-->
      <tr valign="top">
        <th scope="row">
            <label><?php _e('Default Cover', 'WPWSL'); ?></label>
        </th>
        <td>
          <div class="preview-box large">
            <img src="<?php echo $default_img_pic_big; ?>" />
          </div>
          <input type="hidden"
                 value="<?php echo $default_img_pic_big; ?>"
                 name="<?php echo $this->option_name; ?>[sup_wechat_big]"
                 rel="img-input" class="img-input large-text"/>
          <button class='custom_media_upload button'>
              <?php _e('Upload', 'WPWSL'); ?>
          </button>
        </td>
      </tr>
      <!-- Small Image-->
      <tr valign="top">
          <th scope="row">
              <label><?php _e('Default Thumbnail', 'WPWSL'); ?></label>
          </th>
          <td>
              <div class="preview-box">
                  <img src="<?php echo $default_img_pic_small; ?>" />
              </div>
              <input type="hidden"
                     value="<?php echo $default_img_pic_small; ?>"
                     name="<?php echo $this->option_name; ?>[sup_wechat_small]"
                     rel="img-input" class="img-input large-text"/>
              <button class='custom_media_upload button'>
                  <?php _e('Upload', 'WPWSL'); ?>
              </button>
          </td>
      </tr>
		</table>

		<?php submit_button(); ?>
	</form>
	<hr>
	<?php echo $content['tips_content'];?>
</div>

<script>

jQuery(document).ready(function ($) {
	$('input[rel="img-input"]').each(function(){
		$(this).change(function(){
			var img=$($(this).parent().children('.preview-box').children('img'));
			if($(this).val()==''){
				var pic_url=img.data('default_pic');
				img.next('.remove-pic-btn').hide();
			}else{
				var pic_url=$(this).val();
				img.next('.remove-pic-btn').show();
			}
			img.attr('src', pic_url);
		});
	});
});
</script>