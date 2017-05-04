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
                    $image = get_the_post_thumbnail($post->ID, 'smallest', array( 'class' => 'img-responsive' ));
                    if($image == ''){
                        $image = ' 
                            <img src="'.get_path_image_first_content_post('smallest', $post->post_content).'" class="img-responsive" alt="">
                        ';                                   
                    }
                    echo $image;
                    ?>
                </a>
                <a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title;?>" class="title">
                    <?php echo sub_excerpt($post->post_title, 35) ?>                                        
                </a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>