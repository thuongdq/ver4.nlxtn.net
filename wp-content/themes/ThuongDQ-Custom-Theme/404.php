<?php get_header(); 
$category_obj = get_the_category();
$current_cat_id = $category_obj[0]->cat_ID; // current category ID 
$parent = $category = get_category( $category_obj[0]->category_parent );
?>
<div class="content">
<section class="panel category details">
    <div class="panel-heading">
        <ul>
            <li>
                <a href="#" title="#" class="home">Home</a>
            </li>
            <li>
                <a href="<?php echo get_category_link($parent->term_id);?>" title="<?php echo $parent->name; ?>">
                    <?php echo $parent->name; ?>
                </a>
            </li>
        </ul>
    </div>
    <div id="details" class="panel-body">
        <h2>Dữ liệu không tồn tại hoặc đã bị xóa!</h2>
    </div>
</section>
<?php
get_template_part( 'template-parts/post/content', 'postSpecial' );
?>
</div>


<?php 
get_sidebar();
get_sidebar("second");
get_footer(); ?>