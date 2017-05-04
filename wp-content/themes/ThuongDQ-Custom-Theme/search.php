<?php get_header(); ?>
	<div class="content">
	<section class="panel category other search">
		<div class="panel-heading">
			<?php if ( function_exists('yoast_breadcrumb') ) {
		      yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		    } ?>
		</div>
		<div class="panel-body">
		<div class="post-other">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php
					$image = get_the_post_thumbnail();
					if($image == ''){
                        $image = ' 
                            <img src="'.get_path_image_first_content_post().'" class="img-responsive" alt="">
                        ';                                   
                    }
					echo '
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
					?>
				<?php endwhile; ?>

				<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

			<?php else : ?>

				<h2>Không tìm thấy kết quả phù hợp.</h2>

			<?php endif; ?>
		</div>
		</div>
	</section>
	</div>
<?php 
get_sidebar();
get_sidebar("second");
get_footer(); ?>