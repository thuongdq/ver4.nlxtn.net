<?php get_header(); ?>
<?php
// echo $wp_query->query['category_name'];
$category_slugs_array = explode("/",esc_attr($wp_query->query['category_name']));
$parent = get_category_by_slug( $category_slugs_array[0] );
$category = get_category_by_slug( $category_slugs_array[1] );
// echo '<pre>';
// print_r($category);
// echo '</pre>';
?>
<div class="content">
    <section class="panel category">
        <div class="panel-heading">
            <ul>
                <li>
                    <a href="#" title="#" class="home">Home</a>
                </li>
                <li>
                    <a href="<?php echo get_term_link( $parent->term_id ); ?>" title="<?php echo $parent->name; ?>">
                    	<?php echo $parent->name; ?>
                    </a>
                </li>
                <li>
					<a href="<?php echo get_term_link( $category->term_id ); ?>" title="<?php echo $category->name; ?>">
                    	<?php echo $category->name; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
         		<?php
         		global $wp_query;
                if ( have_posts() ) : 
                	$total =   $wp_query->post_count;
                	?>
                <?php
                	$count = 0;
                	$content = '';
                    while ( have_posts() ) : the_post();
	                    $count++;
                        if($count == 1){
                        ?>
                        <div class="post-main">
			                <div class="image">
			                    <a  href="<?php echo esc_url( get_permalink()) ?>" title="<?php echo get_the_title()?>">
					                        <!-- .post-thumbnail -->
					                <?php if ( '' !== get_the_post_thumbnail()) : ?>
					                    <?php the_post_thumbnail( 'image' ); ?>
					                <?php else : ?> 
					                    <img src="<?php echo get_path_image_first_content_post()?>" alt="<?php echo get_the_title()?>">
					                <?php endif; ?>
					                <!-- .post-thumbnail -->
					            </a>
			                </div>
			                <div class="post-content">
			                    <div class="info">
			                        <a  href="<?php echo esc_url( get_permalink()) ?>" title="<?php echo get_the_title()?>">
							            <h2><?php echo get_the_title() ?></h2>
							        </a>
			                        <div class="sumary">
			                            <?php
					                    echo sub_excerpt(get_the_excerpt(),50);       
					                    ?>   
			                             <a  href="<?php echo esc_url( get_permalink()) ?>" title="<?php echo get_the_title()?>" class="read-more">Xem thêm...</a>
			                        </div>
			                    </div>
			                    <div class="other">
			                        <ul>
			                            <li>
			                                <a href="" title="">
			                                    Chìa khóa giúp phòng ngừa và kiểm soát bệnh huyết áp cao
			                                </a>
			                            </li>
			                            <li>
			                                <a href="" title="">
			                                    7 cách phòng ngừa tăng huyết áp đột ngột là chìa khóa an toàn cho sức khỏe
			                                </a>
			                            </li>
			                        </ul>
			                    </div>
			                </div>
			            </div>
                        <?php
                        }else{
                        	// if($count == 2){
                        	// 	echo '<div class="post-other">';
                        	// }
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
			                            <a href="#" title="#" class="read-more">Xem thêm...</a>
			                        </div>
			                    </div>
			                </div>
                        	';
              //           	if($count == 2){
              //           		echo '</div></div></section>';
              //           		echo 'other----';
              //           		echo '<section class="panel category part">
						        // <div class="panel-body">
						        //     <div class="post-other">';
              //           	}
              //           	if($count == $total){
              //           		echo '</div>';
              //           	}
                        }
                    endwhile;
                    ?>
            <?php
	            get_template_part('pagination'); 
	            else :
	                get_template_part( 'template-parts/post/content', 'none' );
	            endif; 
	        ?>
	        </div>
        </div>
    </section>






    


    <section class="panel category post-hot">
        <div class="panel-heading">
            <a href="" title="">
                <h2>TIN BÀI ĐẶC BIẾT</h2>
            </a>
        </div>
        <div class="panel-body">
            <div class="item-post-hot">
                <div class="image">
                    <a href="#" title="#" ><img src="../design/img/post-main.png" alt=""></a>
                </div>
                <div class="info">
                    <a href="#" title="#" ><h3>7 cách chữa huyết áp cao nhanh chóng, hiệu quả</h3></a>
                    <div class="sumary">
                        Chất lượng sống ngày càng tăng...
                        <a href="#" title="#" class="read-more">Xem tiếp...</a>
                    </div>
                </div>
            </div>
            <div class="item-post-hot">
                <div class="image">
                    <a href="#" title="#" ><img src="../design/img/post-main.png" alt=""></a>
                </div>
                <div class="info">
                    <a href="#" title="#" ><h3>7 cách chữa huyết áp cao nhanh chóng, hiệu quả</h3></a>
                    <div class="sumary">
                        Chất lượng sống ngày càng tăng...
                        <a href="#" title="#" class="read-more">Xem tiếp...</a>
                    </div>
                </div>
            </div>
            <div class="item-post-hot">
                <div class="image">
                    <a href="#" title="#" ><img src="../design/img/post-main.png" alt=""></a>
                </div>
                <div class="info">
                    <a href="#" title="#" ><h3>7 cách chữa huyết áp cao nhanh chóng, hiệu quả</h3></a>
                    <div class="sumary">
                        Chất lượng sống ngày càng tăng...
                        <a href="#" title="#" class="read-more">Xem tiếp...</a>
                    </div>
                </div>
            </div>
        </div>
    </section>














    

    <section class="panel category part">
        <div class="panel-body">
            <div class="post-other">
                <div class="item-post">
                    <div class="image">
                        <img src="../design/img/post-main.png" alt="">
                    </div>
                    <div class="info">
                        <h3>Những phương pháp chữa bệnh huyết áp cao bằng tỏi bạn nên biết</h3>
                        <div class="sumary">
                            Không chỉ được biết đến là loại gia vị quen thuộc trong đời sống hằng ngày, tỏi còn là vị thuốc quý trong điều trị bệnh cao huyết áp. “Bỏ túi” những cách chữa bệnh...
                            <a href="#" title="#" class="read-more">Xem thêm...</a>
                        </div>
                    </div>
                </div>

                <div class="item-post">
                    <div class="image">
                        <img src="../design/img/post-main.png" alt="">
                    </div>
                    <div class="info">
                        <h3>Những phương pháp chữa bệnh huyết áp cao bằng tỏi bạn nên biết</h3>
                        <div class="sumary">
                            Không chỉ được biết đến là loại gia vị quen thuộc trong đời sống hằng ngày, tỏi còn là vị thuốc quý trong điều trị bệnh cao huyết áp. “Bỏ túi” những cách chữa bệnh...
                            <a href="#" title="#" class="read-more">Xem thêm...</a>
                        </div>
                    </div>
                </div>

                <div class="item-post">
                    <div class="image">
                        <img src="../design/img/post-main.png" alt="">
                    </div>
                    <div class="info">
                        <h3>Những phương pháp chữa bệnh huyết áp cao bằng tỏi bạn nên biết</h3>
                        <div class="sumary">
                            Không chỉ được biết đến là loại gia vị quen thuộc trong đời sống hằng ngày, tỏi còn là vị thuốc quý trong điều trị bệnh cao huyết áp. “Bỏ túi” những cách chữa bệnh...
                            <a href="#" title="#" class="read-more">Xem thêm...</a>
                        </div>
                    </div>
                </div>
                <div class="item-post">
                    <div class="image">
                        <img src="../design/img/post-main.png" alt="">
                    </div>
                    <div class="info">
                        <h3>Những phương pháp chữa bệnh huyết áp cao bằng tỏi bạn nên biết</h3>
                        <div class="sumary">
                            Không chỉ được biết đến là loại gia vị quen thuộc trong đời sống hằng ngày, tỏi còn là vị thuốc quý trong điều trị bệnh cao huyết áp. “Bỏ túi” những cách chữa bệnh...
                            <a href="#" title="#" class="read-more">Xem thêm...</a>
                        </div>
                    </div>
                </div>
                <div class="item-post">
                    <div class="image">
                        <img src="../design/img/post-main.png" alt="">
                    </div>
                    <div class="info">
                        <h3>Những phương pháp chữa bệnh huyết áp cao bằng tỏi bạn nên biết</h3>
                        <div class="sumary">
                            Không chỉ được biết đến là loại gia vị quen thuộc trong đời sống hằng ngày, tỏi còn là vị thuốc quý trong điều trị bệnh cao huyết áp. “Bỏ túi” những cách chữa bệnh...
                            <a href="#" title="#" class="read-more">Xem thêm...</a>
                        </div>
                    </div>
                </div>
                <div class="item-post">
                    <div class="image">
                        <img src="../design/img/post-main.png" alt="">
                    </div>
                    <div class="info">
                        <h3>Những phương pháp chữa bệnh huyết áp cao bằng tỏi bạn nên biết</h3>
                        <div class="sumary">
                            Không chỉ được biết đến là loại gia vị quen thuộc trong đời sống hằng ngày, tỏi còn là vị thuốc quý trong điều trị bệnh cao huyết áp. “Bỏ túi” những cách chữa bệnh...
                            <a href="#" title="#" class="read-more">Xem thêm...</a>
                        </div>
                    </div>
                </div>
                <nav aria-label="...">
                    <ul class=" pagination pagination-sm page-numbers">
                        <li>
                            <a class="prev page-numbers " href="#">Trang trước</a>
                        </li>
                        <li>
                            <a class="page-numbers" href="#">1</a>
                        </li>
                        <li>
                            <span class="page-numbers current">2</span>
                        </li>
                        <li>
                            <a class="page-numbers" href="#">3</a>
                        </li>
                        <li>
                            <a class="page-numbers" href="#">4</a>
                        </li>
                        <li>
                            <a class="next page-numbers" href="#">Trang sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <article>
        <a href="#" title="#">
            <img src="../design/img/qc485x93.png" alt="" class="img-responsive">
        </a>
    </article>
</div>
<?php 
get_sidebar();
get_sidebar("second");
get_footer(); ?>