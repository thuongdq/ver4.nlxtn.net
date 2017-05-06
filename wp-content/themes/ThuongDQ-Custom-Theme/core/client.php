<?php
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );

/*
//Chuyển trang trước khi load
function edirect_page() {
if ( is_category() && !is_category(2) && !is_category(3)) {
$category = get_category(get_query_var('cat'));
$term_children = get_term_children( $category->term_id, 'category' );
if($category->parent == 0 && !empty($term_children)){
$category_redirect = get_category( $term_children[0] );
wp_redirect(get_term_link($category_redirect->term_id));
}
}
}
add_action( 'template_redirect', 'edirect_page' );
*/

//Kiểm tra để xoá js và css không dùng
if ( !is_admin() ) {
    // wp_deregister_script('jquery');
    // wp_enqueue_script('jquery');
    // wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"), false);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    // function deregister_cf7_js() {
    //  if ( ! is_page( 'contact' ) ) {
    //   wp_deregister_script( 'contact-form-7' );
    //    }
    // }
    // add_action( 'wp_print_scripts', 'deregister_cf7_js', 100 );
    
    // function deregister_ct7_styles() {
    //    if ( ! is_page( 'contact' ) ) {
    //         wp_deregister_style( 'contact-form-7' );
    //     }
    // }
    // add_action( 'wp_print_styles', 'deregister_ct7_styles', 100 );
    // function my_deregister_scripts(){
    //   wp_deregister_script( 'wp-embed' );
    // }
    // add_action( 'wp_footer', 'my_deregister_scripts' );
    function my_deregister_scripts(){
        wp_dequeue_script( 'wp-embed' );
    }
    add_action( 'wp_footer', 'my_deregister_scripts' );
}

// function redirect_to_child_category($category_slugs_array){
//     $total = count($category_slugs_array);
//     echo '<pre>';
//     print_r($category_slugs_array[$total - 1]);
//     echo '</pre>';

//     $category = get_category_by_slug($category_slugs_array[$total - 1]);
//     if($category->parent == 0){
//       $term_children = get_term_children( $category->term_id, 'category' );
//       if(!empty($term_children)){
//         header("Location: http://example.com/myOtherPage.php");
//         return true;
//       }
//       echo '<pre>';
//       print_r($term_children);
//       echo '</pre>';
//     }
//     return false;
// }
// add_filter( 'wp_redirect', 'redirect_to_child_category' );


// function wpse121308_redirect_page() {
//     if ( is_category() && !is_category(2) && !is_category(3)) {
//         $category = get_category(get_query_var('cat'));
//         $term_children = get_term_children( $category->term_id, 'category' );
//         if($category->parent == 0 && !empty($term_children)){
//           $category_redirect = get_category( $term_children[0] );
//           wp_redirect(get_term_link($category_redirect->term_id));
//           // echo '<pre>';
//           // print_r($category_redirect);
//           // echo '</pre>';
//         }
//     }
// }
// add_action( 'template_redirect', 'wpse121308_redirect_page' );