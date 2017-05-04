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
        <h1>Uống nấm lim xanh là sự lựa chọn hoàn hảo</h1>
        <div class="intro">
            Nấm lim xanh của Công ty đang ngày càng khẳng định được vị trí nhờ hiệu quả chữa bệnh hiệu quả. Để tránh mua phải hàng giả, hàng kém chất lượng, Quý khách hàng lưu ý tới đúng địa chỉ Công ty ủy quyền.
        </div>
        <div class="content-agency">
            <p>
                Khi thu hái Nấm lim xanh từ rừng nguyên sinh phải trải qua công đoạn sơ chế, chế biến bằng biện pháp gia truyền của Công ty TNHH Nấm lim xanh thiên nhiên Quảng Nam, để loại bỏ độc tố, làm giàu dược chất, mang lại hiệu quả chữa bệnh cao nhất.Công ty đã
                có 63 đại lý ủy quyền phân phối nấm lim xanh trên toàn quốc. Quý khách hàng muốn tìm mua sản phẩm Nấm lim xanh của Công ty, vui lòng đến trực tiếp tại các đại lý dưới đây:
            </p>
            <?php
            get_template_part( 'template-parts/content/embed', 'agency');
            ?>  
        </div>
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