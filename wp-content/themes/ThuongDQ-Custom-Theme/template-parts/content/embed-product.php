<?php
$args = array(
    'posts_per_page'   => 3,
    'post_type'        => 'product'
);
$list_product = get_posts( $args ); ?>
<div class="panel product">
    <div class="panel-heading">
        Nấm lim xanh thiên nhiên Quảng Nam
    </div>
    <div class="panel-body">
        <?php
        for($i=0; $i<3; $i++){
        ?>
        <div class="col-md-4 item">
            <a href="<?php echo get_permalink($list_product[1]->ID); ?>" title="<?php echo $list_product[1]->post_title;?>">
                <?php
                echo media_view_image($list_product[$i]->ID, $list_product[$i]->post_title, $list_product[$i]->post_content,'thumbnail');
                ?>
            </a>
            <a href="<?php echo get_permalink($list_product[1]->ID); ?>" title="<?php echo $list_product[1]->post_title;?>">
                <?php echo $list_product[$i]->post_title; ?>
            </a>
            <div class="desc">
                <?php
                $price = get_post_meta($list_product[$i]->ID, 'price', true );
                if(empty($price)){
                    $price = "Liên hệ";
                }else{
                    $price = number_format($price);
                }
                ?>
                <span class="price">Giá: <?php echo $price;?> Đ/hộp</span>
                <p>
                    Nấm lim xanh tự nhiên Tiên Phước loại Nguyên cây có công dụng bồi bổ cơ thể, dưỡng sinh,...
                </p>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>