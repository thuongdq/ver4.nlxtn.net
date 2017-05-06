<?php
// Add Menu Support
add_theme_support('menus');

function menu_change_class_submenu_class($menu) {    
    $menu = preg_replace('/ class="sub-menu"/','/ class="dropdown-menu" /',$menu);    
    return $menu;
}
add_filter('wp_nav_menu','menu_change_class_submenu_class'); 

//Đăng ký vị trí cho menu
// function register_Position_menu()
// {
//   register_nav_menus(array( // Using array to specify more menus if needed
//     'header-menu' => __('Đầu trang', 'ThuongDQ'), // Main Navigation
//     'sidebar-menu' => __('Lề trang', 'ThuongDQ'), // Sidebar Navigation
//     'footer-menu' => __('Cuối trang', 'ThuongDQ'), // Sidebar Navigation
//     'content-menu' => __('Nội dung', 'ThuongDQ'), // Sidebar Navigation
//     'extra-menu' => __('Mở rộng', 'ThuongDQ') // Extra Navigation if needed (duplicate as many as you need!)
//   ));
// }
// function nav_menu()
// {
//   wp_nav_menu(
//     array(
//       'theme_location'  => 'header-menu',
//       'menu'            => '',
//       'container'       => 'div',
//       'container_class' => 'menu-{menu slug}-container',
//       'container_id'    => '',
//       'menu_class'      => 'menu',
//       'menu_id'         => '',
//       'echo'            => true,
//       'fallback_cb'     => 'wp_page_menu',
//       'before'          => '',
//       'after'           => '',
//       'link_before'     => '',
//       'link_after'      => '',
//       'items_wrap'      => '<ul>%3$s</ul>',
//       'depth'           => 0,
//       'walker'          => ''
//     )
//   );
// }
// add_action('init', 'register_Position_menu');