<aside>
    <?php
    global $tp_options;
    foreach ($tp_options['left-agency'] as $key => $value) {
      $menu_object = wp_get_nav_menu_object( $value );
    ?>
    <div class="panel panel-primary menu-left-agency">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $menu_object->name?></h3>
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
</aside>