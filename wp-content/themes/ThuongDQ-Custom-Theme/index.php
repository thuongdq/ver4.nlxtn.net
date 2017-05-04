<?php 
    get_header();
    get_template_part( 'template-parts/navigation/navigation', 'top');
?>
<div class="content">
    <?php
    get_template_part( 'template-parts/content/home');
    get_template_part( 'template-parts/content/embed', 'postSpecial');
    get_template_part( 'template-parts/content/embed', 'product');
    get_template_part( 'template-parts/sidebar/postHot');
    get_template_part( 'template-parts/sidebar/postNew');
    ?>
</div>
<?php 
get_sidebar("second");
get_sidebar();
get_footer(); ?>