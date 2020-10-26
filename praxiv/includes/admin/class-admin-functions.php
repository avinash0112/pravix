<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Admin_Function' ) ) {

    class Admin_Function {

        public function __construct() {

        }

        public function register_product_meta_box() {
            add_meta_box( 'praxiv-house-metabox', esc_html__( 'House Number Settings', 'praxiv' ), [$this, 'product_meta_box_seting'], 'product', 'side', 'high' );
        }

        public function admin_script() {
            wp_enqueue_style( 'praxiv-admin-css', PRAXIV_PLUGIN_URL . 'assets/css/admin.css', array(), PRAXIV_SCRIPT_VERSION );
            wp_enqueue_script( 'praxiv-admin-js', PRAXIV_PLUGIN_URL . 'assets/js/admin.js', array(), PRAXIV_SCRIPT_VERSION,true );
        }

        public function product_meta_box_seting() {
            global $post;
            $id      = $post->ID;
            $enable  = get_post_meta( $id, 'house_number', true );
            $house_distance = get_post_meta( $id, 'house_distance', true );
            $house_cost = get_post_meta( $id, 'house_cost', true );

            $checked = 'checked';
            $class   = '';
            if ( 'enable' !== $enable ) {
                $class   = 'display-none';
                $checked = '';
            }
            
            ?>
            <p>
                <input type="checkbox" name="house_number" id="house_number" value="enable" <?php echo esc_attr( $checked ); ?>>
                <label for="house_number"><?php esc_html_e( 'House number product', 'praxiv' ); ?></label>
            </p>
            <p class="per_char_price <?php echo esc_attr( $class ); ?>">
                <label for="per_char_price"><?php esc_html_e( 'Per Charater Price', 'praxiv' ); ?> : </label>
                <input type="text" name="per_char_price" id="per_char_price" value="<?php echo esc_attr( get_post_meta( $id, 'per_char_price', true ) );?>">
            </p>
            <p>
                <table id="praxiv-table" class="<?php echo esc_attr( $class ); ?>">
                    <thead>
                        <tr>
                            <th><?php esc_html_e( 'CM', 'praxiv' ); ?></th>
                            <th><?php esc_html_e( 'Cost', 'praxiv' ); ?></th>
                            <th><?php esc_html_e( 'Action', 'praxiv' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ( ! empty( $house_distance ) && ! empty( $house_cost ) ) { 
                            foreach ( $house_distance as $key => $value) { 
                            ?>
                            <tr>
                                <td>
                                    <input type="number" step="0.1" name="house_distance[]" value="<?php echo esc_attr( $value ); ?>">
                                </td>
                                <td>
                                    <input type="number" step="0.1" name="house_cost[]" value="<?php echo esc_attr( $house_cost[ $key ] ); ?>">
                                </td>
                                <td class="text-center">
                                    <span class="color-red dashicons dashicons-dismiss praxiv-remove"></span>
                                </td>
                            </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td>
                                    <input type="number" step="0.1" name="house_distance[]">
                                </td>
                                <td>
                                    <input type="number" step="0.1" name="house_cost[]">
                                </td>
                                <td class="text-center">
                                    <span class="color-red dashicons dashicons-dismiss praxiv-remove"></span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center">
                                <a href="javascript:void(0);" id="praxiv-add-more" class="button button-primary button-large"><?php esc_html_e( 'Add More', 'praxiv' ); ?></a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </p>
            <?php
        }

        public function save_house_details( $post_id ) {
            
            if ( isset( $_POST['house_number'] ) && 'enable' === $_POST['house_number'] ) {
                $house_distance = isset( $_POST['house_distance'] ) ? $_POST['house_distance'] : array();
                $house_cost     =  isset( $_POST['house_cost'] ) ? $_POST['house_cost'] : array();
                
                $house_distance = array_map( 'sanitize_text_field', $house_distance );
                $house_cost     = array_map( 'sanitize_text_field', $house_cost );
                update_post_meta( $post_id, 'house_number', 'enable' );
                update_post_meta( $post_id, 'house_distance', $house_distance );
                update_post_meta( $post_id, 'house_cost', $house_cost );
                if ( isset( $_POST['per_char_price'] ) && ! empty( (int)$_POST['per_char_price']  ) ) {
                    update_post_meta( $post_id, 'per_char_price', $_POST['per_char_price'] );
                } else {
                    update_post_meta( $post_id, 'per_char_price', 0 );
                }
            } else {
                update_post_meta( $post_id, 'house_number', 'disable' );
            }
        }
    }

}