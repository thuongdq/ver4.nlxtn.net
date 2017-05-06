<aside class="video">
    <h2 class="btn btn-primary title-video">Video về "Nấm lim xanh"</h2>
    <div id="category-posts-6" class="widget cat-post-widget">
        <?php
        global $tp_options;
        $list_video =  get_posts(array(
            'numberposts'   => 1, // get all posts.
            'tax_query'     => array(
                array(
                    'taxonomy'  => 'category',
                    'field'     => 'id',
                    'terms'     => $tp_options['right-video'],
                ),
            ),
        ));
        ?>
        <h2>VIDEO</h2>
        <a class="cat-post-thumbnail cat-post-none" href="<?php echo get_post_permalink($list_video[0]->ID); ?>" title="video nấm lim xanh">
            <?php
            echo media_view_image($list_video[0]->ID, $list_video[0]->post_title, $list_video[0]->post_content,'medium', "");
            ?>
        </a>
    </div>
</aside>