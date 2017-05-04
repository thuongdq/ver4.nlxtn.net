<h1><?php the_title(); ?></h1>
<div class="content-detail">
    <?php the_content(); ?>

    <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

    <?php the_tags( 'Tags: ', ', ', ''); ?>
</div>
<div class="list-agency">
	<?php
    get_template_part( 'template-parts/content/embed', 'agency');
    ?>  
</div>