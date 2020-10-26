<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Praxiv' ) ) {

    class Praxiv {

        /**
         * Variable Stores Plugin Version.
         *
         * @var string
         */
        public $version = '1.0.0';

         /**
         * The single instance of the class.
         *
         * @var Praxiv
         * @since 1.0.0
         */
        protected static $_instance = null;

        public function __construct() {
            $this->define_constant();
            $this->intailize_hooks();
        }

         /**
         * Main Praxiv Instance.
         *
         * Ensures only one instance of Praxiv is loaded or can be loaded.
         *
         * @return Praxiv - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * This function will Define Constant Variable
         */
        public function define_constant() {
            defined( 'PRAXIV_PLUGIN_FILE' ) || define( 'PRAXIV_PLUGIN_FILE', plugin_dir_path( PRAXIV_FILE ) );
            defined( 'PRAXIV_PLUGIN_URL' ) || define( 'PRAXIV_PLUGIN_URL', plugin_dir_url( PRAXIV_FILE ) );
            defined( 'PRAXIV_SCRIPT_VERSION' ) || define( 'PRAXIV_SCRIPT_VERSION', '1.1.0' );
            defined( 'PRAXIV_PLUGIN_BASENAME' ) || define( 'PRAXIV_PLUGIN_BASENAME', plugin_basename( PRAXIV_FILE ) );
        }

        public function intailize_hooks() {
            add_action( 'plugins_loaded', [$this, 'load_textdomain' ] );
        }

        public function load_textdomain() {
            // Load Text domain
            load_plugin_textdomain( 'wk-multi-share-cart', false, basename( dirname( APPFOSTER_FILE ) ) . '/languages' );
            $this->check_dependency();
        }

        private function check_dependency() {
            if ( ! function_exists( 'WC' ) ) {
                // Add WooCommerce dependency Message
                add_action( 'admin_notices', [ $this, 'wc_dependency' ]);
            } else {
                $this->include_files();
            }
        }

        public function wc_dependency() {
            deactivate_plugins( basename( PRAXIV_FILE ), true );
            ?>
            <div class="error">
                <p><?php echo sprintf( esc_html__( 'Praxiv Wordpress Developer test Plugin Plugin require %s in order to work', 'praxiv' ), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">' . esc_html__( 'WooCommerce', 'praxiv' ) . '</a>' ) ?></p>
            </div>
            <?php
        }

        public function include_files() {
            if ( is_admin() ) {
                include_once PRAXIV_PLUGIN_FILE . 'includes/admin/class-admin-hooks.php';
            } else {
                include_once PRAXIV_PLUGIN_FILE . 'includes/public/class-public-hooks.php';
            }
        }
    }

}