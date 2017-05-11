<?php
/*********************
* re-order left admin menu
**********************/
function reorder_admin_menu( $__return_true ) {
    return array(
    'index.php', // Dashboard
    'edit.php', // Posts
    'edit.php?post_type=agency', // Post Agency
    'edit.php?post_type=product', // Post Product
    'edit.php?post_type=page', // Pages
    'upload.php', // Media
    'users.php', // Users
    '_options', // Redux Framework
    'wpseo_dashboard', //Yoast SEO
    'separator1', // --Space--
    'themes.php', // Appearance
    'edit-comments.php', // Comments
    'plugins.php', // Plugins
    'tools.php', // Tools
    'options-general.php', // Settings
    'edit.php?post_type=acf', //Custom Filed
    'duplicator-pro',
    'separator2', // --Space--
    );
}
add_filter( 'custom_menu_order', 'reorder_admin_menu' );
add_filter( 'menu_order', 'reorder_admin_menu' );



function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
}
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

/*
* Remove top level and sub menu admin menus
*/
function remove_admin_menus() {
    // remove_menu_page( 'index.php' ); // Dashboard
    // remove_menu_page( 'edit.php' ); // Posts
    // remove_menu_page( 'upload.php' ); // Media
    // remove_menu_page( 'edit.php?post_type=page' ); // Pages
    // remove_menu_page( 'users.php' ); // Users
    
    
    // hidden
    remove_menu_page( 'edit-comments.php' ); // Comments
    // remove_menu_page( 'themes.php' ); // Appearance
    remove_menu_page( 'plugins.php' ); // Plugins
    remove_menu_page( 'tools.php' ); // Tools
    remove_menu_page( 'options-general.php' ); // Settings
    remove_menu_page( 'edit.php?post_type=acf' ); //Custom Filed
    remove_menu_page( 'duplicator-pro' ); //duplicator-pro
    remove_menu_page( 'wphpuw' ); //hide error report
}
add_action( 'admin_menu', 'remove_admin_menus', 999 );

// Remove sub level admin menus
function remove_admin_submenus() {
    remove_submenu_page( 'index.php', 'update-core.php' ); // Dashboard - Updates
    // remove_submenu_page( 'edit.php', 'post-new.php' ); // Posts - Add New Post
    // remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); // Posts - Categories
    // remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // Posts - Tags
    // remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' ); // Pages - Add New Page
    // remove_submenu_page ( 'upload.php', 'media-new.php'); // Media - Add New
    
    // remove_submenu_page( 'themes.php', 'themes.php' ); // Appearance - Themes
    
    //- Not working. Uses other code. See further below.
    // remove_submenu_page( 'themes.php', 'customize.php' ); // Appearance - Customize
    // remove_submenu_page( 'themes.php', 'widgets.php' ); // Appearance - Widgets
    // remove_submenu_page( 'themes.php', 'nav-menus.php' ); // Appearance - Menus
    
    //- Not working
    // remove_submenu_page( 'themes.php', 'customize.php' ); // Appearance - Header
    
    //- Not working
    // remove_submenu_page( 'themes.php', 'customize.php' ); // Appearance - Background
    // remove_submenu_page( 'themes.php', 'theme-editor.php' ); // Appearance - Editor
    
    // remove_submenu_page( 'plugins.php', 'plugin-install.php' ); // Plugins - Add New Plugins
    // remove_submenu_page( 'plugins.php', 'plugin-editor.php' ); // Plugins - Editor
    
    // remove_submenu_page( 'users.php', 'user-new.php' ); //Users - Add New User
    // remove_submenu_page( 'users.php', 'profile.php' ); //Users - Your Profile
    
    // remove_submenu_page( 'options-general.php', 'options-writing.php' ); // Settings - Writing
    // remove_submenu_page( 'options-general.php', 'options-reading.php' ); // Settings - Reading
    // remove_submenu_page( 'options-general.php', 'options-discussion.php' ); // Settings - Discussion
    // remove_submenu_page( 'options-general.php', 'options-media.php' ); // Settings - Media
    // remove_submenu_page( 'options-general.php', 'options-permalink.php' ); // Settings - Permalink
}
add_action( 'admin_init', 'remove_admin_submenus' );


//Hide admin footer from admin
function change_footer_admin () {return ' ';}
add_filter('admin_footer_text', 'change_footer_admin', 9999);
function change_footer_version() {return 'Development by ThuongDQ';}
add_filter( 'update_footer', 'change_footer_version', 9999);

// function my_footer_shh() {
//     remove_filter( 'update_footer', 'core_update_footer' );
// }
// add_action( 'admin_menu', 'my_footer_shh' );

// hide verision footer from everyone except admins:
// function my_footer_shh() {
//     if ( ! current_user_can('manage_options') ) { // 'update_core' may be more appropriate
//         remove_filter( 'update_footer', 'core_update_footer' );
//     }
// }
// add_action( 'admin_menu', 'my_footer_shh' );

