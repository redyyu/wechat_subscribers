<?php
/*
 * Settings Page, It's required by WPWSLGeneral Class only.
 *
 */
global $wpdb;

//Load content
require_once( 'content.php' );
?>
<link href="<?php echo WPWSL_PLUGIN_URL;?>/css/style.css" rel="stylesheet">
<div class="wrap">
	<?php echo $content['header'];?>
	<hr>
	<h2>
	<?php _e('Charts',"WPWSL");?> 
	<a href="<?php menu_page_url(WPWSL_HISTORY_PAGE);?>" class="add-new-h2"><?php _e('Statistics',"WPWSL");?></a>
	</h2>
	<br>
	
</div>