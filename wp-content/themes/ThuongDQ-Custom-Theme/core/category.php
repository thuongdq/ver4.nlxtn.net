<?php
function category_get_name_by_ID( $cat_ID ) {
    $cat_ID = (int) $cat_ID;
    $category = get_term( $cat_ID, 'category' );
 
    if ( is_wp_error( $category ) )
 
    return ( $category ) ? $category->name : '';
}

//config phân trang
function category_custom_pagination()
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
add_action('init', 'category_custom_pagination'); 