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
        <a class="cat-post-thumbnail cat-post-none" href="#" title="video nấm lim xanh">
            <?php
            $image = get_the_post_thumbnail($list_video[0]->ID, 'thumbnail', array( 'class' => '' ));
            if($image == ''){
                $image = ' 
                    <img src="'.get_path_image_first_content_post('thumbnail', $list_video[0]->post_content).'" class="" alt="'.$list_video[0]->post_title.'">
                ';                                   
            }
            echo $image;
            ?>
        </a>
    </div>
</aside>