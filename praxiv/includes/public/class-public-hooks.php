<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Public_Hooks' ) ) {

    class Public_Hooks {

        public function __construct() {

            include_once 'class-public-functions.php';
            $function_object = new Public_Functions();
            add_action( 'woocommerce_after_add_to_cart_button', [ $function_object, 'woocommerce_house_data' ] );
            add_action( 'wp_enqueue_scripts', [ $function_object, 'public_script' ] );
            add_action( 'woocommerce_before_calculate_totals', [ $function_object, 'added_to_cart' ] );
            add_filter( 'woocommerce_add_cart_item_data',  [ $function_object, 'add_cart_item_data_house_num' ]);
        }

    }

    new Public_Hooks();

}