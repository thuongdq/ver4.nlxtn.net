<h2 class="title_agency_global">DANH SÁCH ĐẠI LÝ NẤM LIM XANH TOÀN QUỐC</h2>
<?php
    global $tp_options;
    foreach ($tp_options['left-agency'] as $key => $value) {
      $menu_object = wp_get_nav_menu_object( $value );
    ?>
    <div class="panel panel-primary menu-right list-agency">
        <div class="panel-heading">
            <?php echo str_replace( 'Đại lý', '', $menu_object->name );?>
        </div>
        <div class="panel-body none-padding">
           <?php 
              wp_nav_menu(array("menu" => $value, 'menu_class' => 'nav menu-agency'));
              ?>
        </div>
    </div>
    <?php
    }
    ?>