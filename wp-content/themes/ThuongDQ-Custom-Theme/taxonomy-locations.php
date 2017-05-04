<?php get_header(); ?>
<?php
$category = get_the_category(); 
$taxonomy = wp_get_post_terms( $post->ID, 'locations' );
?>
<!-- begin main-content -->
<div class="col-xs-12 col-sm-8 content">
    <section>
		<ol class="nav-breadcrumb bg-gradian">
            <li><a href="<?php echo home_url('/'); ?>" title="logo">Nấm lim xanh</a></li>
            <!-- <li><a href="#">Library</a></li> -->
            <li><span><?php echo $taxonomy[0]->name;?></span></li>
        </ol>
        <div class="panel category">

            <div class="panel-body main-post">
                <?php
                 // The Query
                    query_posts( array( 'post_type'    => 'post',
                         'posts_per_page'  => 4,            

                         'post_status'  => 'publish',                    
                         'cat'   => $category[0]->cat_ID,
                         'meta_key'           => 'post_views_count',
                         'orderby'    => 'meta_value_num',
                         'order'    => 'DESC'
                    ) );

                    // The Loop
                    $count =0;
                    $firstPostHot = '';
                    $secondPostHot = '';
                    while ( have_posts() ) : the_post();
                    $count++;
                    if($count == 1){
                        ?>
                         <div class="post-main">
                            <div class="post-main-show">
                                <div class="image">
                                    <!-- .post-thumbnail -->
                                    <?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
                                            <a href="<?php the_permalink(); ?>" title="<?php echo get_the_title()?>">
                                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                                            </a>
                                    <?php else : ?>                 
                                            <a href="<?php the_permalink(); ?>" title="<?php echo get_the_title()?>">
                                                <img src="<?php echo get_path_image_first_content_post()?>" alt="<?php echo get_the_title()?>">
                                            </a>
                                    <?php endif; ?>
                                    <!-- .post-thumbnail -->
                                </div>
                                <div class="content">
                                    <a  href="<?php echo esc_url( get_permalink()) ?>" title="<?php echo get_the_title()?>">
                                        <h1 class="product-name"><?php echo get_the_title() ?></h1>
                                    </a>
                                    <span class="info">
                                    <?php
                                        echo contentan_and_more(sub_excerpt(get_the_excerpt(),120,'...'), esc_url( get_permalink()));       
                                    ?>   
                                    </span>
                                </div>
                            </div>
                        </div>

                        <?php
                    }else{
                        $secondPostHot .= '<li><a href="'.esc_url( get_permalink()).'" title="'.get_the_title().'">'.sub_excerpt(get_the_title(),50).'</a></li>';
                    } 
                    endwhile;
                    // Reset Query
                    wp_reset_query();
                ?>
                <div class="post-hot">
                    <h2>Bài viết nổi bật</h2>
                    <ul>
                        <?php echo $secondPostHot; ?>
                    </ul>
                </div>
            </div>






            <div class="list-post">
                <?php
                if ( have_posts() ) : ?>
                <?php
                /* Start the Loop */
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/post/content', 'category' );
                    endwhile;
                    get_template_part('pagination'); 
                else :
                    get_template_part( 'template-parts/post/content', 'none' );

                endif; ?>
            
            </div>
        </div>





        <?php
        get_template_part( 'template-parts/post/content', 'productShow' );
        ?>
        <div class="hidden-md hidden-lg">
            <?php
        get_template_part( 'template-parts/post/content', 'event' );
        ?>
        </div>
        <!-- end post by category -->
    </section>
    <figure>
        <div class="f-support">
            <div class="hidden-xs col-sm-4 title">
                <span>Đường dây nóng:</span>
                <span>Tư vấn miễn phí</span>
            </div>
            <div class="col-xs-6 col-sm-4 info-1">
                <div class="supporter-w">
                    <div class="supporter">
                        <span>Tư vấn viên</span>
                        <span>0986.123.456</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 info-2">
                <div class="supporter-w">
                    <div class="supporter">
                        <span>Tư vấn viên</span>
                        <span>0986.123.456</span>
                    </div>
                </div>
            </div>
        </div>
    </figure>
</div>
<!-- end main-content -->
<?php 
get_sidebar();
get_sidebar("second");
get_footer(); ?>