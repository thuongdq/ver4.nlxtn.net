<?php
    $list_post_hot =  get_posts(array(
        'post_type'    => 'post',
        'posts_per_page'  => 6, 
    ));
?>
<div class="panel panel-default post-hot">
    <div class="panel-heading">
        Bài viết mới nhât
    </div>
    <div class="panel-body">
        <ul>
             <?php
            foreach($list_post_hot as $post){
            ?>
            <li>
               <a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title;?>">
                    <?php
                    echo image_view($post->ID, $post->post_title, $post->post_content,'smaller');
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