<nav class="navbar navbar-default menu-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- <a class="navbar-brand" href="#">Brand</a> -->
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" aria-expanded="false" style="height: 1px;">
            <?php  
            global $tp_options;
            wp_nav_menu(array("menu" => $tp_options['main-menu'], 'container'=>"", 'menu_class' => 'nav navbar-nav '));
            // wp_nav_menu(array("menu" => "contact", 'container'=>"", 'menu_class' => 'nav navbar-nav navbar-right'));
             ?>
             <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?php echo get_page_link($tp_options['main-contact']); ?>">
                    Liên hệ với chúng tôi
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
