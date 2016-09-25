<?php
/*
Plugin Name: Whale Admin Crud
Description: Admin Crud for cutom tables
Version: 0.9
Author: Shahroq
Author URI: 
Text Domain: whale_admin_crud
Main Author: http://projects.tareq.co/wp-generator/index.php
*/

add_action( 'init' , function(){
    include dirname(__FILE__) . '/includes/class-admin-menu.php';
    new Forms_Admin_Menu();
});