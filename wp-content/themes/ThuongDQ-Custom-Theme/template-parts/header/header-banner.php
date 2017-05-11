<header class="row page-header">
    <?php
    global $tp_options;
    if($tp_options['logo-on'] == 1){
        $logo = $tp_options['logo-image']['url'];
        $banner = $tp_options['banner-image']['url'];
    }else{
        $logo = $banner = $tp_options['default-image']['url'];
    }

    
    ?>
    <div class="logo">
        <?php
        if(is_single()){
        ?>
        <a href="<?php echo home_url('/'); ?>" title="Nấm">
            <img src="<?php echo $logo; ?>" alt="Nấm lim xanh" class="img-reponsive">
        </a>    
        <?php }else{ ?>
        <h1>
            <a href="<?php echo home_url('/'); ?>" title="Nấm">
                <img src="<?php echo $logo; ?>" alt="Nấm lim xanh" class="img-reponsive">
            </a> 
        </h1>
        <?php } ?>
    </div>
    <div class="banner">
        <a href="<?php echo home_url('/'); ?>" title="banner">
            <img src="<?php echo $banner; ?>" alt="banner nấm lim xanh">
        </a>
    </div>
</header>