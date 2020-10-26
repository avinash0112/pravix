<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Admin_Hooks' ) ) {

    class Admin_Hooks {

        public function __construct() {
            include_once 'class-admin-functions.php';
            $function_object = new Admin_Function();
            add_action( 'add_meta_boxes', [ $function_object, 'register_product_meta_box' ] );
            add_action( 'admin_enqueue_scripts', [ $function_object, 'admin_script' ] );
            add_action( 'save_post_product', [ $function_object, 'save_house_details' ] );
        }

    }

    new Admin_Hooks();

}