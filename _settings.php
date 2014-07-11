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
$interface_url=isset($options['token']) && $options['token']!=''?home_url().'/?'.$options['token']:'none';

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
		        	<input type="text" size="30" name="<?php echo $this->option_name ;?>[token]" value="<?php echo $options['token'];?>" class="regular-text"/>
		        	<p class="description"><?php _e('Access verification for your WeChat public platform. Only Latin letter, number, dash and underscore. 30 character limited.','WPWSL')?></p>
		        </td>
	        </tr>
	        <tr valign="top">
		        <th scope="row"><label>URL</label></th>
		        <td>
		        	<h4><?php echo $interface_url;?></h4>
		        	<p class="description"><?php _e('First input a TOKEN above and save the settings, then &quot;Copy&quot; and &quot;Bind&quot; this URL to WeChat Platform.','WPWSL')?></p>
		        </td>
	        </tr>
	    </table>
		
		<?php submit_button(); ?>
	</form>
	<hr>
	<?php echo $content['tips_content'];?>
</div>