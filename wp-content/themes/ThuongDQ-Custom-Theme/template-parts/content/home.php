<?php
global $tp_options;
// echo '<pre>';
// print_r($tp_options);
// echo '</pre>';
foreach($tp_options['home-categories'] as $key => $category) {
    $list_post =  get_posts(array(
        'numberposts'   => 4, // get all posts.
        'tax_query'     => array(
            array(
                'taxonomy'  => 'category',
                'field'     => 'id',
                'terms'     => $category,
            ),
        ),
    ));
  
?>
<div class="panel category">
    <a title="<?php echo $list_post[0]->post_title;?>" href="<?php echo get_permalink($list_post[0]->ID); ?>">
        <h2 class="post-list-title"><?php echo $list_post[0]->post_title;?></h2>
    </a>
    <div class="main-view">
        <a title="<?php echo $list_post[0]->post_title;?>" href="<?php echo get_permalink($list_post[0]->ID); ?>">
            <?php
            echo media_view_image($list_post[0]->ID, $list_post[0]->post_title, $list_post[0]->post_content,'thumbnail');
            ?>
        </a>
        <div class="info">
            <?php echo post_sub_excerpt($list_post[0]->post_content, 220) ?>    
            <a title="<?php echo $list_post[0]->post_title;?>" href="<?php echo get_permalink($list_post[0]->ID); ?>" class="pull-right btn btn-primary read-more" >Xem thêm</a>
        </div>
    </div>
    <ul class="nav nav-left post-other" style="margin-top: 5px;">
        <?php
            for($i = 1; $i<4; $i++){
                echo '
                    <li role="presentation">
                        <a title="'.$list_post[$i]->post_title.'" href="'.get_permalink($list_post[$i]->ID).'">
                            '.$list_post[$i]->post_title.'
                        </a>
                    </li>
                ';
            }
        ?>
    </ul>
    <?php
    get_template_part( 'template-parts/content/embed', 'connect');
    ?>
</div>
<?php
}
?>