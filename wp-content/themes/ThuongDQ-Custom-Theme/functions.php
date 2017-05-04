<?php
/**
@ Khai bao hang gia tri
  @ THEME_URL = lay duong dan thu muc theme
  @ CORE = lay duong dan cua thu muc /core
**/
define( 'THEME_URL', get_stylesheet_directory() );
define ( 'CORE', THEME_URL . "/core" );
/**
@ Nhung file /core/init.php
**/
require_once( CORE . "/init.php" );

// Add Menu Support 
add_theme_support('menus');
//Add thumbnail, automatic feed links and title tag support
add_theme_support( 'post-thumbnails' );
add_image_size('smaller',68,60, true);
add_image_size('smallest',48,37, true);
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );

	
// Register sidebar
add_action('widgets_init', 'theme_register_sidebar');
function theme_register_sidebar() {
  // Declare sidebar widget zone 
  if (function_exists('register_sidebar')) {
    register_sidebar(array(
      'name' => 'left',
      'id'   => 'left',
      'description'   => 'These are widgets for the sidebar.',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2>',
      'after_title'   => '</h2>'
      ));
  }
  if (function_exists('register_sidebar')) {
    register_sidebar(array(
      'name' => 'right',
      'id'   => 'right',
      'description'   => 'These are widgets for the sidebar.',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2>',
      'after_title'   => '</h2>'
      ));
  }

  if (function_exists('register_sidebar')) {
    register_sidebar(array(
      'name' => 'main',
      'id'   => 'main',
      'description'   => 'These are widgets for the sidebar.',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2>',
      'after_title'   => '</h2>'
      ));
  }

  if (function_exists('register_sidebar')) {
    register_sidebar(array(
      'name' => 'footer',
      'id'   => 'footer',
      'description'   => 'These are widgets for the sidebar.',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2>',
      'after_title'   => '</h2>'
      ));
  }
}


/*------------------------------------*\
  Re-Config
\*------------------------------------*/
function load_template_part($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}
//chạy lệnh php trong text
function php_text($text) {
 if (strpos($text, '<' . '?') !== false) {
   ob_start();
   eval('?' . '>' . $text);
   $text = ob_get_contents();
   ob_end_clean();
 }
 return $text;
}
add_filter('widget_text', 'php_text', 99);

//config phân trang
function custom_pagination()
{
 global $wp_query;
    $big = 999999999; // need an unlikely integer
    $pages = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'prev_next' => false,
            'type'  => 'array',
            'prev_next'   => TRUE,
            'prev_text'    => __('&laquo;'),
            'next_text'    => __('&raquo;'),
        ) );
        if( is_array( $pages ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
            echo '<ul class="pagination pagination-sm page-numbers">';
            foreach ( $pages as $page ) {
                    echo "<li>$page</li>";
            }
           echo '</ul>';
        }
} 
add_action('init', 'custom_pagination'); // Add our HTML5 Pagination

/*------------------------------------*\
  Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
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
// Custom Post type đại lý
  function create_post_type_agency()
  {
    register_taxonomy_for_object_type('category', 'twentyseventeen'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'twentyseventeen');
    register_post_type('agency', // Register Custom Post Type
      array(

        'labels' => array(
            'name' => __('Danh sách đại lý', 'twentyseventeen'), // Rename these to suit
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
          'agency','post_tag',  
        ) // Add Category and Post Tags support
        ));
  }
add_action('init', 'create_post_type_agency'); // Add our HTML5 Blank Custom Post Type


function create_post_type_product()
  {
    register_taxonomy_for_object_type('category', 'twentyseventeen'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'twentyseventeen');
    register_post_type('product', // Register Custom Post Type
      array(

        'labels' => array(
            'name' => __('Danh sách sản phẩm', 'twentyseventeen'), // Rename these to suit
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
          'agency','post_tag',  
        ) // Add Category and Post Tags support
        ));
  }
add_action('init', 'create_post_type_product'); // Add our HTML5 Blank Custom Post Type
/*------------------------------------*\
  Theme option ShortCode Functions
\*------------------------------------*/
/*
function theme_settings_page()
{
    ?>
        <div class="wrap">
        <h1>Theme Setting</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");      
                submit_button(); 
            ?>          
        </form>
        </div>
    <?php
}

function add_theme_menu_item()
{
    add_menu_page("Theme setting", "Theme setting", "manage_options", "theme-setting", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");

function display_list_category_content_home()
{
    $list_category = get_option('list_category');
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục  1','hide_empty'=>0,'name'=>'list_category[0]','selected'=>$list_category[0]));
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục 2','hide_empty'=>0,'name'=>'list_category[1]','selected'=>$list_category[1]));
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục 3','hide_empty'=>0,'name'=>'list_category[2]','selected'=>$list_category[2]));

}

function display_sidebar_video()
{
    $sidebar_video = get_option('sidebar_video');
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục','hide_empty'=>0,'name'=>'sidebar_video[0]','selected'=>$sidebar_video[0]));
}




function display_theme_panel_fields()
{
  add_settings_section("section", "All Settings", null, "theme-options");
  add_settings_field("list_category", "Danh sách danh mục (Trang chủ) ", "display_list_category_content_home", "theme-options", "section");
  register_setting("section", "list_category"); 

  add_settings_section("section", "All Settings", null, "theme-options");
  add_settings_field("sidebar_video", "Video (slider-right) ", "display_sidebar_video", "theme-options", "section");
  register_setting("section", "sidebar_video"); 

}
add_action("admin_init", "display_theme_panel_fields");
*/


/*------------------------------------*\
  ShortCode Functions
\*------------------------------------*/
// get path thumbnail first in content post
function get_path_image_first_content_post($size='', $post_content = ''){
  global $post, $posts;
  $content = $post->post_content;
  if($post_content != ''){
    $content = $post_content;
  }
  $first_img = '';
  ob_start();
  ob_end_clean();
  preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );
  if ( isset( $matches[1][0] ) && $matches[1][0] ) {      // any image there?
    $postimage = $matches[1][0]; // we need the first one only!
  }
  if ( $postimage ) {
    $postimage_id = custom_get_attachment_id_from_url( $postimage );
    if(!empty($size)){
      $postthumb = wp_get_attachment_image_src( $postimage_id,$size);
      $postimage = $postthumb[0];
    }
    elseif ( false != wp_get_attachment_image_src( $postimage_id, 'thumbnail' ) ) {
      $postthumb = wp_get_attachment_image_src( $postimage_id, 'thumbnail' );
      $postimage = $postthumb[0];
    }else{
      $postthumb = wp_get_attachment_image_src( $postimage_id, 'full');
      $postimage = $postthumb[0];
    }
    return $postimage;
  }
}

function custom_get_attachment_id_from_url( $attachment_url = '' ) {

  global $wpdb;
  $attachment_id = false;

  // If there is no url, return.
  if ( '' == $attachment_url ) {
    return;
  }

  // Get the upload directory paths
  $upload_dir_paths = wp_upload_dir();

  // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
  if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

    // If this is the URL of an auto-generated thumbnail, get the URL of the original image
    $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

    // Remove the upload path base directory from the attachment URL
    $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

    // Finally, run a custom database query to get the attachment ID from the modified attachment URL
    $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

  }
  return apply_filters( 'custom_get_attachment_id_from_url', $attachment_id, $attachment_url );
} 

  function sub_excerpt($str, $len, $more = ' ...', $charset = 'UTF-8'){
  $str = html_entity_decode($str, ENT_QUOTES, $charset);
  $str = strip_tags(strip_shortcodes($str));
  if(mb_strlen($str, $charset) > $len) {
    $arr = explode(' ', $str);
    $str = mb_substr($str, 0, $len, $charset);
    $arrRes = explode(' ', $str);
    $last = $arr[count($arrRes)-1];
    unset($arr);
    if(strcasecmp($arrRes[count($arrRes)-1], $last)) {
      unset($arrRes[count($arrRes)-1]);
    }
    return implode(' ', $arrRes).$more;
  }
  return $str;
}



// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
  global $post;
  if (function_exists($length_callback)) {
    add_filter('excerpt_length', $length_callback);
  }
  if (function_exists($more_callback)) {
    add_filter('excerpt_more', $more_callback);
  }
  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  $output = '<p>' . $output . '</p>';
  echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
  global $post;
  return '... <a class="pull-right btn btn-primary read-more" href="' . get_permalink($post->ID) . '">' . __('Xem thêm', 'html5blank') . '</a>';
}
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts

function contentan_and_more($content, $link)
{
  return $content.'... <a class=" read-more" href="' . $link . '">Xem thêm</a>';
}

function new_submenu_class($menu) {    
    $menu = preg_replace('/ class="sub-menu"/','/ class="dropdown-menu" /',$menu);    
    return $menu;
}
add_filter('wp_nav_menu','new_submenu_class'); 

function get_name_by_category_ID( $cat_ID ) {
    $cat_ID = (int) $cat_ID;
    $category = get_term( $cat_ID, 'category' );
 
    if ( is_wp_error( $category ) )
        return $category;
 
    return ( $category ) ? $category->name : '';
}

// function to display number of posts.
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
 
// function to count views.
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
 
 
// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Views');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}



/**
 * Show a given widget based on it's id and it's sidebar index
 *
 * Example: wpse_show_widget( 'sidebar-1', 'calendar-2' ) 
 *
 * @param string $index. Index of the sidebar where the widget is placed in.
 * @param string $id. Id of the widget.
 * @return boolean. TRUE if the widget was found and called, else FALSE.
 */
function wpse_show_widget( $index, $id )
{
    global $wp_registered_widgets, $wp_registered_sidebars;
    $did_one = FALSE;

    // Check if $id is a registered widget
    if( ! isset( $wp_registered_widgets[$id] ) 
        || ! isset( $wp_registered_widgets[$id]['params'][0] ) ) 
    {
        return FALSE;
    }

    // Check if $index is a registered sidebar
    $sidebars_widgets = wp_get_sidebars_widgets();
    if ( empty( $wp_registered_sidebars[ $index ] ) 
        || empty( $sidebars_widgets[ $index ] ) 
        || ! is_array( $sidebars_widgets[ $index ] ) )
    {
        return FALSE;
    }

    // Construct $params
    $sidebar = $wp_registered_sidebars[$index];
    $params = array_merge(
                    array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']) ) ),
                    (array) $wp_registered_widgets[$id]['params']
              );

    // Substitute HTML id and class attributes into before_widget
    $classname_ = '';
    foreach ( (array) $wp_registered_widgets[$id]['classname'] as $cn )
    {
        if ( is_string($cn) )
            $classname_ .= '_' . $cn;
        elseif ( is_object($cn) )
            $classname_ .= '_' . get_class($cn);
    }
    $classname_ = ltrim($classname_, '_');
    $params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);         
    $params = apply_filters( 'dynamic_sidebar_params', $params );

    // Run the callback
    $callback = $wp_registered_widgets[$id]['callback'];            
    if ( is_callable( $callback ) )
    {
         call_user_func_array( $callback, $params );
         $did_one = TRUE;
    }

    return $did_one;
}

//Đăng ký vị trí cho menu
function register_Position_menu()
{
  register_nav_menus(array( // Using array to specify more menus if needed
    'header-menu' => __('Đầu trang', 'ThuongDQ'), // Main Navigation
    'sidebar-menu' => __('Lề trang', 'ThuongDQ'), // Sidebar Navigation
    'footer-menu' => __('Cuối trang', 'ThuongDQ'), // Sidebar Navigation
    'content-menu' => __('Nội dung', 'ThuongDQ'), // Sidebar Navigation
    'extra-menu' => __('Mở rộng', 'ThuongDQ') // Extra Navigation if needed (duplicate as many as you need!)
  ));
}
function nav_menu()
{
  wp_nav_menu(
    array(
      'theme_location'  => 'header-menu',
      'menu'            => '',
      'container'       => 'div',
      'container_class' => 'menu-{menu slug}-container',
      'container_id'    => '',
      'menu_class'      => 'menu',
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => 'wp_page_menu',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul>%3$s</ul>',
      'depth'           => 0,
      'walker'          => ''
    )
  );
}
add_action('init', 'register_Position_menu');
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
?>