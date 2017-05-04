<!DOCTYPE html>
<html lang="lang=" vi " prefix="og: http://ogp.me/ns# "">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#ffffff">
    <title>Nấm Lim Xanh - Một trang web mới sử dụng WordPress</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/asset/app/css/app.bundle.min.css">
    <?php wp_head(); ?>
</head>

<body class="home blog">
    <div class="container">
        <?php
            get_template_part( 'template-parts/header/header', 'banner' );
        ?>
        <div class="row page-content">
            <div class="main">