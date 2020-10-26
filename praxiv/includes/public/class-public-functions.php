<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Public_Functions' ) ) {

    class Public_Functions {

        public function __construct() {

        }

        public function woocommerce_house_data(){
            global $product;
            $product_id = $product->get_id();
            if ( $product->get_type() != 'grouped' && $product->get_type() != 'external' ) {    
                $house_distance = get_post_meta( $product_id, 'house_distance', true );
                $house_cost = get_post_meta( $product_id, 'house_cost', true );
                ?>
                <div id="house_div">
                    <div class="padding-10">
                        <label>
                        <?php esc_html_e( 'Enter Character (max-10)', 'praxiv' ); ?> : <input type="text" name="per_character" id="praxiv-per-char" maxlength="10">
                        </label>
                    </div>
                    <div  class="padding-10">
                        <label>
                            <?php esc_html_e( 'Select Distance', 'praxiv' ); ?> :
                            <select name="house_distance" id="house_distance">
                                <option value=""><?php esc_html_e( '--Choose Option--', 'praxiv' ); ?></option>
                                <?php
                                foreach ( $house_distance as $key => $value) {
                                    ?>
                                    <option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_attr( $value ) . 'cm -> ' . wc_price( $house_cost[ $key] ) ;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                    <input type="hidden" name="house_total_cost" id="house_total_cost">
                    <input type="hidden" value="<?php echo esc_attr( $product->get_price() ); ?>" id="pravix-product-price">
                </div>
                <?php
            }
            
        }

        public function public_script() {
            if ( is_product() ){
                wp_enqueue_style( 'praxiv-public-css', PRAXIV_PLUGIN_URL . 'assets/css/public.css', array(), PRAXIV_SCRIPT_VERSION );
                wp_enqueue_script( 'praxiv-public-js', PRAXIV_PLUGIN_URL . 'assets/js/public.js', [], PRAXIV_SCRIPT_VERSION, true );
                $product_id = get_the_ID();
                $house_distance = get_post_meta( $product_id, 'house_distance', true );
                $house_cost = get_post_meta( $product_id, 'house_cost', true );
                $product = wc_get_product( $product_id );

                wp_localize_script( 'praxiv-public-js', 'praxiv_obj', [
                    'ajax_url'       => admin_url( 'admin-ajax' ),
                    'product_id'     => $product_id,
                    'house_distance' => $house_distance,
                    'house_cost'     => $house_cost,
                    'per_char_price' => get_post_meta( $product_id, 'per_char_price', true ),
                    'price'          => $product->get_price(),
                ]);
            }
        }

        public function added_to_cart( $cart_obj ) {
            // This is necessary for WC 3.0+
			if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
                return;
            }

            // Avoiding hook repetition (when using price calculations for example)
            if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2) {
                return;
            }
            foreach( $cart_obj->get_cart() as $key => $item ) {
                
                if ( !empty($item['house_total_cost'] ) ) {

                    $price = (float)$item['house_total_cost'][0]['value'];

                    $item['data']->set_price($price );
                }
            }
        }

        public function add_cart_item_data_house_num( $cart_item ) {
            $data = array();

			if (empty($cart_item['house_total_cost'])) {
				$cart_item['house_total_cost'] = '';
			}
			if ( ! empty( $_REQUEST['house_total_cost']) ) {

				$data[] = array(
					'name' 	=> 'house_total_cost',
					'value' => $_REQUEST['house_total_cost'],
					'id' 	=> 'house_total_cost',
				);
                $cart_item['house_total_cost'] = $data; 
			}
			
            return $cart_item;
        }
    }

}