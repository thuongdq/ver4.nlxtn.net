<?php
    $list_post_hot =  get_posts(array(
        'post_type'    => 'post',
        'posts_per_page'  => 6,                         
        'post_status'  => 'publish',  
        'meta_key'           => 'post_views_count',
        'orderby'    => 'meta_value_num',
        'order'    => 'DESC'
    ));
?>
<div class="panel panel-default post-hot">
    <div class="panel-heading">
        Bài viết được quan tâm
    </div>
    <div class="panel-body">
        <ul>
             <?php
            foreach($list_post_hot as $post){
            ?>
            <li>
               <a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title;?>">
                    <?php
                    echo media_view_image($post->ID, $post->post_title, $post->post_content,'smaller');
                    ?>
                </a>
                <a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title;?>" class="title">
                    <?php echo post_sub_excerpt($post->post_title, 35) ?>                                        
                </a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>