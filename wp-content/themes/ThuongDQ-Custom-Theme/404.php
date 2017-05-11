<?php 
    get_header();
    get_template_part( 'template-parts/navigation/navigation', 'top');
?>
<div class="content page-agency">
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb('<div class="breadcrumbs">','</div>');
    }
    ?>
    <div class="info">
        <h4>
        Đường dẫn của bạn không đúng. hoặc bài viết không tồn tại.<br>
        Vui lòng kiểm tra lại!
        </h4>
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