<?php
// Custom post type for Template page.
custom_posttype_wpwsl_template();

function custom_posttype_wpwsl_template() {
	//Set up labels
	$labels = array('name' => 'WPWSL Template',
	'singular_name' => 'Template');
	
	$fields = array('labels' => $labels,
	'public' => false,
	'publicly_queryable' => false,
	'show_ui' => false, 
	'query_var' => false,
	'rewrite' => array('slug' => 'wpwsl_template'),
	'capability_type' => 'page',
	'hierarchical' => false,
	'menu_position' => 60,
	'supports' => array('title')); 
	
	register_post_type('wpwsl_template', $fields);
}

 ?>