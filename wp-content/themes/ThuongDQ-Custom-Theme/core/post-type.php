<?php
// Create 1 Custom Post type for a Demo, called ThuongDQ Custom Theme
function post_type_create()
{
    register_taxonomy_for_object_type('category', 'ThuongDQ Custom Theme'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'ThuongDQ Custom Theme');
    register_post_type('ThuongDQ Custom Theme', // Register Custom Post Type
    array(
    'labels' => array(
    'name' => __('HTML5 Blank Custom Post', 'ThuongDQ Custom Theme'), // Rename these to suit
    'singular_name' => __('HTML5 Blank Custom Post', 'ThuongDQ Custom Theme'),
    'add_new' => __('Add New', 'ThuongDQ Custom Theme'),
    'add_new_item' => __('Add New HTML5 Blank Custom Post', 'ThuongDQ Custom Theme'),
    'edit' => __('Edit', 'ThuongDQ Custom Theme'),
    'edit_item' => __('Edit HTML5 Blank Custom Post', 'ThuongDQ Custom Theme'),
    'new_item' => __('New HTML5 Blank Custom Post', 'ThuongDQ Custom Theme'),
    'view' => __('View HTML5 Blank Custom Post', 'ThuongDQ Custom Theme'),
    'view_item' => __('View HTML5 Blank Custom Post', 'ThuongDQ Custom Theme'),
    'search_items' => __('Search HTML5 Blank Custom Post', 'ThuongDQ Custom Theme'),
    'not_found' => __('No HTML5 Blank Custom Posts found', 'ThuongDQ Custom Theme'),
    'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'ThuongDQ Custom Theme')
    ),
    'public' => true,
    'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
    'has_archive' => true,
    'supports' => array(
    'title',
    'editor',
    'excerpt',
    'thumbnail'
    ), // Go to Dashboard Custom HTML5 Blank post for supports
    'can_export' => true, // Allows export in Tools > Export
    'taxonomies' => array(
    'post_tag',
    'category'
    ) // Add Category and Post Tags support
    ));
}
// add_action('init', 'post_type_create');


// Custom Post type đại lý
function post_type_agency_create()
{
    register_taxonomy_for_object_type('category', 'twentyseventeen');
    register_taxonomy_for_object_type('post_tag', 'twentyseventeen');
    register_post_type('agency',
    array(
    
    'labels' => array(
    'name' => __('Đại lý', 'twentyseventeen'),
    'singular_name' => __('Đại lý', 'twentyseventeen'),
    'add_new' => __('Add New đại lý', 'twentyseventeen'),
    'add_new_item' => __('Add New đại lý', 'twentyseventeen'),
    'edit' => __('Edit đại lý', 'twentyseventeen'),
    'edit_item' => __('Edit đại lý', 'twentyseventeen'),
    'new_item' => __('New đại lý', 'twentyseventeen'),
    'view' => __('View đại lý', 'twentyseventeen'),
    'view_item' => __('View đại lý', 'twentyseventeen'),
    'search_items' => __('Search đại lý', 'twentyseventeen'),
    'not_found' => __('No đại lý', 'twentyseventeen'),
    'not_found_in_trash' => __('No đại lý in Trash', 'twentyseventeen')
    ),
    'rewrite' => array( 'slug' => 'dai-ly'),
    'public' => true,
    'hierarchical' => true,
    'has_archive' => true,
    'supports' => array(
    'title',
    'editor',
    'excerpt',
    'thumbnail'
    ),
    'can_export' => true,
    'taxonomies' => array(
    'agency','post_tag',
    )
    ));
}
add_action('init', 'post_type_agency_create');

// Custom Post type sản phẩm
function post_type_product_create(){
    register_taxonomy_for_object_type('category', 'twentyseventeen');
    register_taxonomy_for_object_type('post_tag', 'twentyseventeen');
    register_post_type('product',
    array(
    'labels' => array(
    'name' => __('Sản phẩm', 'twentyseventeen'),
    'singular_name' => __('Sản phẩm', 'twentyseventeen'),
    'add_new' => __('Add New sản phẩm', 'twentyseventeen'),
    'add_new_item' => __('Add New sản phẩm', 'twentyseventeen'),
    'edit' => __('Edit sản phẩm', 'twentyseventeen'),
    'edit_item' => __('Edit sản phẩm', 'twentyseventeen'),
    'new_item' => __('New sản phẩm', 'twentyseventeen'),
    'view' => __('View sản phẩm', 'twentyseventeen'),
    'view_item' => __('View sản phẩm', 'twentyseventeen'),
    'search_items' => __('Search sản phẩm', 'twentyseventeen'),
    'not_found' => __('No sản phẩm', 'twentyseventeen'),
    'not_found_in_trash' => __('No sản phẩm in Trash', 'twentyseventeen')
    ),
    'rewrite' => array( 'slug' => 'san-pham'),
    'public' => true,
    'hierarchical' => true,
    'has_archive' => true,
    'supports' => array(
    'title',
    'editor',
    'excerpt',
    'thumbnail'
    ),
    'can_export' => true,
    'taxonomies' => array(
    'agency','post_tag',
    )
    ));
}
add_action('init', 'post_type_product_create');