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
    register_taxonomy_for_object_type('category', 'ThuongDQ Custom Theme');
    register_taxonomy_for_object_type('post_tag', 'ThuongDQ Custom Theme');
    register_post_type('agency',
    array(
    
    'labels' => array(
    'name' => __('Đại lý', 'ThuongDQ Custom Theme'),
    'singular_name' => __('Đại lý', 'ThuongDQ Custom Theme'),
    'add_new' => __('Thêm đại lý mới', 'ThuongDQ Custom Theme'),
    'add_new_item' => __('Thêm đại lý mới', 'ThuongDQ Custom Theme'),
    'edit' => __('Chỉnh sửa đại lý', 'ThuongDQ Custom Theme'),
    'edit_item' => __('Chỉnh sửa đại lý', 'ThuongDQ Custom Theme'),
    'new_item' => __('Đại lý mới', 'ThuongDQ Custom Theme'),
    'view' => __('Xem đại lý', 'ThuongDQ Custom Theme'),
    'view_item' => __('Xem đại lý', 'ThuongDQ Custom Theme'),
    'search_items' => __('Tìm kiếm đại lý', 'ThuongDQ Custom Theme'),
    'not_found' => __('Không có đại lý', 'ThuongDQ Custom Theme'),
    'not_found_in_trash' => __('Không có đại lý trong thùng rác', 'ThuongDQ Custom Theme')
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
    register_taxonomy_for_object_type('category', 'ThuongDQ Custom Theme');
    register_taxonomy_for_object_type('post_tag', 'ThuongDQ Custom Theme');
    register_post_type('product',
    array(
    'labels' => array(
    'name' => __('Sản phẩm', 'ThuongDQ Custom Theme'),
    'singular_name' => __('Sản phẩm', 'ThuongDQ Custom Theme'),
    'add_new' => __('Thêm sản phẩm mới', 'ThuongDQ Custom Theme'),
    'add_new_item' => __('Thêm sản phẩm mới', 'ThuongDQ Custom Theme'),
    'edit' => __('Chỉnh sửa sản phẩm', 'ThuongDQ Custom Theme'),
    'edit_item' => __('Chỉnh sửa sản phẩm', 'ThuongDQ Custom Theme'),
    'new_item' => __('Sản phẩm mới', 'ThuongDQ Custom Theme'),
    'view' => __('Xem sản phẩm', 'ThuongDQ Custom Theme'),
    'view_item' => __('Xem sản phẩm', 'ThuongDQ Custom Theme'),
    'search_items' => __('Tìm kiếm sản phẩm', 'ThuongDQ Custom Theme'),
    'not_found' => __('Không có sản phẩm', 'ThuongDQ Custom Theme'),
    'not_found_in_trash' => __('Không có sản phẩm trong thùng rác', 'ThuongDQ Custom Theme')
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