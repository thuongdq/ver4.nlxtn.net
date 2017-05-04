<?php
$sticky = get_option( 'sticky_posts' );
$args_non_sticky = array(
    'showposts'     => -1,
    'post__not_in' => $sticky,
    );
$args_sticky = array(
    'posts_per_page' => -1,
    'post__in'  => $sticky
    );

$list_post =  get_posts($args_sticky);
$list_non_sticky =  get_posts($args_non_sticky);
?>
<div class="panel post-special">
    <div class="panel-heading">
        Bài viết nổi bật
    </div>
    <div class="panel-body none-padding">
        <?php
        if(empty($list_post) && empty($list_non_sticky)){
            echo "<h4>Nội dung đang được cập nhật</h4>";
        }else{
        ?>
        <ul class="nav">
            <?php
            if(!empty($list_post)){
                foreach ($list_post as $key => $post) {
                    $image = get_the_post_thumbnail($post->ID, 'smaller', array( 'class' => 'img-responsive' ));
                    if($image == ''){
                        $image = ' 
                            <img src="'.get_path_image_first_content_post('smaller', $post->post_content).'" class="img-responsive" alt="">
                        ';                                   
                    }
                    echo '
                    <li class="col-xs-6 col-sm-4">
                        <a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">
                           '.$image.'
                        </a>
                        <a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">
                            '.sub_excerpt($post->post_title, 40).'
                        </a>
                    </li>
                    ';
                }
            }
            ?>
        </ul>
        <?php
        }
        ?>
    </div>
</div>