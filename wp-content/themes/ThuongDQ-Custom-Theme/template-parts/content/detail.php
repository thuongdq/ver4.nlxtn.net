<h1><?php the_title(); ?></h1>
<div class="intro">
    <?php //the_excerpt(); ?> 
</div>
<ul class="post-other">
    <?php
    $args = array( 
        'post_type' => 'post',
        'posts_per_page' => 3,
        'category' => $current_cat_id,
        'orderby'  => 'post_date',
        'order'    => 'DESC',
        'post__not_in' => array($post_id)
    );
    $posts = get_posts( $args );
    // get IDs of posts retrieved from get_posts
    $ids = array();
    $count = 0;
    foreach ( $posts as $itemPost ) {
        if($itemPost->ID != $post_id){
           echo '
            <li>
                <a href="'.get_permalink($itemPost->ID).'" title="'.$itemPost->post_title.'">'.$itemPost->post_title.'</a>
            </li>';
        }
    }
    ?>
</ul>
<div class="content-detail">
    <?php the_content(); ?>

    <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

    <?php the_tags( 'Tags: ', ', ', ''); ?>
</div>
<div class="social">
    <a href="#" title="Vào facebook">
        <span class="facebook">Vào facebook</span>
    </a>
    <a href="#" title="Xem video">
        <span class="video">Xem video</span>
    </a>
    <a class="video" href="#" title="Tìm đại lý">
        <span class="agency">Tìm đại lý</span>
    </a>
    <a href="#" title="Liên hệ công ty">
        <span class="contact">Liên hệ công ty</span>
    </a>
</div>
