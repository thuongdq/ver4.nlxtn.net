<aside>
    <div class="panel panel-primary menu">
        <span class="slogan">Nấm lim xanh Quảng Nam</span>
        <div class="panel-heading heading-left-border">
            <h3 class="panel-title title" style="">Trang chủ</h3>
        </div>
        <div class="panel-body none-padding">
            <?php 
            global $tp_options;
            wp_nav_menu(array("menu" => $tp_options['left-menu'], 'menu_class' => 'nav nav-left'));
            ?> 
        </div>
    </div>
</aside>