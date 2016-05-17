<?php
error_log('Debug posttype: memory usage: ' . memory_get_peak_usage());

// Custom post type for Template page.
custom_posttype_wpwsl_template();

function custom_posttype_wpwsl_template()
{
    //Set up labels
    $labels = [
        'name' => 'WPWSL Template',
        'singular_name' => 'Template'];

    $fields = [
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => false,
        'query_var' => false,
        'rewrite' => [
            'slug' => 'wpwsl_template'],
        'capability_type' => 'page',
        'hierarchical' => false,
        'menu_position' => 60,
        'supports' => [
            'title']];

    register_post_type('wpwsl_template', $fields);
}
