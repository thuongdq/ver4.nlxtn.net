<?php
// Register sidebar
add_action('widgets_init', 'widget_theme_register_sidebar');
function widget_theme_register_sidebar() {
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

/**
* Show a given widget based on it's id and it's sidebar index
*
* Example: widget_get_item_show( 'sidebar-1', 'calendar-2' )
*
* @param string $index. Index of the sidebar where the widget is placed in.
* @param string $id. Id of the widget.
* @return boolean. TRUE if the widget was found and called, else FALSE.
*/
function widget_get_item_show( $index, $id )
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

//chạy lệnh php trong text của widget
function widget_php_text($text) {
    if (strpos($text, '<' . '?') !== false) {
        ob_start();
        eval('?' . '>' . $text);
        $text = ob_get_contents();
        ob_end_clean();
    }
    return $text;
}
add_filter('widget_text', 'widget_php_text', 99);