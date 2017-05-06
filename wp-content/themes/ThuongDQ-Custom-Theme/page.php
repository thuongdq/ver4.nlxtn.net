<?php 
    get_header();
    get_template_part( 'template-parts/navigation/navigation', 'top');
?>
<div class="content page-detail">
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb('<div class="breadcrumbs">','</div>');
    }
    ?>
    <div class="content-detail">
    <?php 
    if (have_posts()) { 
        while (have_posts()) : the_post(); 
        post_set_views(get_the_ID());
        ?>
        <h1><?php the_title(); ?></h1>
        <div class="detail">
            <?php the_content(); ?>
            <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
            <?php the_tags( 'Tags: ', ', ', ''); ?>
        </div>
        <?php
        get_template_part( 'template-parts/content/embed', 'connect'); 
        endwhile;  
    }else{
        echo '<h2>Nội dung đang được cập nhật.</h2>';
        } ?>
    </div>

<?php
    get_template_part( 'template-parts/content/embed', 'product');
    get_template_part( 'template-parts/sidebar/postHot');
    get_template_part( 'template-parts/sidebar/postNew');
    ?>
</div>
<?php 
get_sidebar("second");
get_sidebar();
get_footer(); ?>