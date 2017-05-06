<?php
/*------------------------------------*\
Theme option ShortCode Functions
\*------------------------------------*/
function theme_settings_page()
{
    ?>
  <div class="wrap">
    <h1>Theme Setting</h1>
    <form method="post" action="options.php">
      <?php
    settings_fields("section");
    do_settings_sections("theme-options");
    submit_button();
    ?>
    </form>
  </div>
  <?php
}

function add_theme_menu_item()
{
    add_menu_page("Theme setting", "Theme setting", "manage_options", "theme-setting", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");


function display_layer()
{
    $layer1 = get_option('layer1');
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục','hide_empty'=>0,'name'=>'layer1[0]','selected'=>$layer1[0]));
    
}

function display_layer_5()
{
    $layer5 = get_option('layer5');
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục','hide_empty'=>0,'name'=>'layer5[0]','selected'=>$layer5[0]));
    
}

function display_layer_2()
{
    $layer2 = get_option('layer2');
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục  1','hide_empty'=>0,'name'=>'layer2[0]','selected'=>$layer2[0]));
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục 2','hide_empty'=>0,'name'=>'layer2[1]','selected'=>$layer2[1]));
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục 3','hide_empty'=>0,'name'=>'layer2[2]','selected'=>$layer2[2]));
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục 4','hide_empty'=>0,'name'=>'layer2[3]','selected'=>$layer2[3]));
    
}

function display_layer_3()
{
    $layer3 = get_option('layer3');
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục','hide_empty'=>0,'name'=>'layer3[0]','selected'=>$layer3[0]));
}

function display_layer_4()
{
    $layer4 = get_option('layer4');
    wp_dropdown_categories(array('show_count'=>1,'hierarchical'=>1,'option_none_value'=>'','required'=>true,'show_option_none'=>'Chọn danh mục','hide_empty'=>0,'name'=>'layer4[0]','selected'=>$layer4[0]));
}

function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");
    add_settings_field("layer1", "Câu hỏi thường gặp  ", "display_layer", "theme-options", "section");
    register_setting("section", "layer1");
    
    add_settings_section("section", "All Settings", null, "theme-options");
    add_settings_field("layer5", "Sản phẩm", "display_layer_5", "theme-options", "section");
    register_setting("section", "layer5");
    
    add_settings_section("section", "All Settings", null, "theme-options");
    add_settings_field("layer2", "Danh sách danh mục <br>(Trang chủ) ", "display_layer_2", "theme-options", "section");
    register_setting("section", "layer2");
    
    add_settings_section("section", "All Settings", null, "theme-options");
    add_settings_field("layer3", "Video (slider-right) ", "display_layer_3", "theme-options", "section");
    register_setting("section", "layer3");
    
    add_settings_section("section", "All Settings", null, "theme-options");
    add_settings_field("layer4", "Báo chí (slider-right) ", "display_layer_4", "theme-options", "section");
    register_setting("section", "layer4");
}
add_action("admin_init", "display_theme_panel_fields");