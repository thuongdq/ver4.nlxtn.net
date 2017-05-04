<?php get_header(); ?>
<?php

$tag = get_term_by('slug', $wp_query->query['tag'], 'post_tag');

?>
<div class="content">
    <?php
    if ( have_posts() ) {
    ?>
    <section class="panel category other search">
        <div class="panel-heading">
        <div class="breadcrumb no-childen">
            <!-- <span>
                    <a href="<?php echo home_url('/'); ?>" title="#" class="home">Home</a>
                </span>
                <span>
                        <a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php echo $tag->name; ?>">
                        Tag: <?php echo $tag->name; ?>
                    </a>
                </span>
                </div> -->
            <?php if ( function_exists('yoast_breadcrumb') ) {
              yoast_breadcrumb('<div id="breadcrumbs" class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular" > ','</div>');
            } ?>
        </div>
        <div class="panel-body">
            <?php
            $content = '';
            $contentOther = '';
            while ( have_posts() ) : the_post();
                $count++;
            
                    // if($count == 2){
                    //  echo '<div class="post-other">';
                    // }
                    $image = get_the_post_thumbnail();
                    if($image == ''){
                        $image = ' 
                            <img src="'.get_path_image_first_content_post().'" class="img-responsive" alt="">
                        ';                                   
                    }
                    $item = '
                    <div class="item-post">
                        <div class="image">
                            <a href="'.esc_url( get_permalink()).'" title="'.get_the_title().'">
                                '.$image.'
                            </a>
                        </div>
                        <div class="info">
                            <a href="'.esc_url( get_permalink()).'" title="'.get_the_title().'">
                                <h3>'.sub_excerpt(get_the_title(),90).'</h3>
                            </a>
                            <div class="sumary">
                                '.sub_excerpt(get_the_excerpt(),130).'
                                 <a href="'.esc_url( get_permalink()).'" title="'.get_the_title().'"  class="read-more">Xem thêm...</a>
                            </div>
                        </div>
                    </div>
                    ';

                    
                    if($count <= 5){
                        $content .= $item;
                    }else{
                        $contentOther .= $item;
                    }
                
            endwhile;
            ?>
            <div class="post-other">
                <?php
                    echo $content;
                ?>
            </div>
            <?php
                if($contentOther == ''){
                    get_template_part('pagination');  
                }
            ?>
        </div>
    </section>

    <?php
    get_template_part( 'template-parts/post/content', 'postSpecial' );
    ?>

    <?php
    if($contentOther != ''){
    ?>
    <section class="panel category part">
        <div class="panel-body">
            <div class="post-other">
                <?php
                    echo $contentOther;
                    get_template_part('pagination');  
                ?>
            </div>
        </div>
    </section>
    <?php
    }
    get_template_part( 'template-parts/advertisement/content', 'category485x93');
    }else{
    ?>
    <section class="panel category">
        <div class="panel-heading">
            <div class="breadcrumb">
                <span>
                    <a href="#" title="#" class="home">Home</a>
                </span>
                <span>
                    <a href="<?php echo get_term_link( $parent->term_id ); ?>" title="<?php echo $parent->name; ?>">
                        <?php echo $parent->name; ?>
                    </a>
                </span>
                <span>
                    <a href="<?php echo get_term_link( $category->term_id ); ?>" title="<?php echo $category->name; ?>">
                        <?php echo $category->name; ?>
                    </a>
                </span>
            </div>
        </div>
        <div class="panel-body">
            <h4>Nội dung đang được cập nhật....</h4>
        </div>
    </section>
    <?php
    get_template_part( 'template-parts/post/content', 'postSpecial' );
    echo '<aside>';
            wpse_show_widget( 'left', 'widget_sp_image-13');
        echo '</aside>';
    }
    ?>

</div>
<?php 
get_sidebar();
get_sidebar("second");
get_footer(); ?>