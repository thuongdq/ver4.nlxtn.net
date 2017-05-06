<?php
/**
@ Khai bao hang gia tri
@ THEME_URL = lay duong dan thu muc theme
@ CORE = lay duong dan cua thu muc /core
**/
define( 'THEME_URL', get_stylesheet_directory() );
define ( 'CORE', THEME_URL . "/core" );
/**
@ Nhung file /core/init.php
**/
require_once( CORE . "/lib/init.php" );
require_once( CORE . "/post.php" );
require_once( CORE . "/category.php" );
require_once( CORE . "/menu.php" );
require_once( CORE . "/media.php" );
require_once( CORE . "/post-type.php" );
require_once( CORE . "/admin.php" );
require_once( CORE . "/client.php" );
require_once( CORE . "/widget.php" );
