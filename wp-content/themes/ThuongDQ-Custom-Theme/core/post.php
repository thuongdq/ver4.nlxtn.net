<?php
// Add it to a column Views in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Views');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo post_get_views(get_the_ID());
    }
}

// function to display number of posts.
function post_get_views($postID){
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
function post_set_views($postID) {
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


//Cắt đoạn văn bản bất kỳ
function post_sub_excerpt($str, $len, $more = ' ...', $charset = 'UTF-8'){
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