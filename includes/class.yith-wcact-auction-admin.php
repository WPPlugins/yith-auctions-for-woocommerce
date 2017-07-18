<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( !defined( 'YITH_WCACT_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

/**
 *
 *
 * @class      YITH_Auctions_Admin
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
 *
 */

if ( !class_exists( 'YITH_Auction_Admin' ) ) {
    /**
     * Class YITH_Auctions_Admin
     *
     * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
     */
    class YITH_Auction_Admin
    {

        /**
         * @var Panel object
         */
        protected $_panel = null;


        /**
         * @var Panel page
         */
        protected $_panel_page = 'yith_wcact_panel_product_auction';

        /**
         * @var bool Show the premium landing page
         */
        public $show_premium_landing = true;

        /**
         * @var string Official plugin documentation
         */
        protected $_official_documentation = 'http://yithemes.com/docs-plugins/yith-woocommerce-auctions/';

        /**
         * @var string
         */
        protected $_premium_landing_url = 'http://yithemes.com/themes/plugins/yith-woocommerce-auctions/';

        /**
         * Single instance of the class
         *
         * @var \YITH_Auction_Admin
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Booking Product Type Name
         *
         * @type string
         */
        public static $prod_type = 'auction';

        public $product_meta_array = array();

        /**
         * Returns single instance of the class
         *
         * @return \YITH_Auction_Admin
         * @since 1.0.0
         */
        public static function get_instance() {
            $self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

            if ( is_null( $self::$instance ) ) {
                $self::$instance = new $self;
            }

            return $self::$instance;
        }


        /**
         * Construct
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         */
        public function __construct()
        {
            /* === Register Panel Settings === */
            add_action('admin_menu', array($this, 'register_panel'), 5);
            /* === Premium Tab === */
            add_action( 'yith_wcact_premium_tab', array( $this, 'show_premium_landing' ) );
            
            // Enqueue Scripts
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

            // Add Auction product to WC product type selector
            add_filter('product_type_selector', array($this, 'product_type_selector'));

            // Add tabs for product auction
            add_filter('woocommerce_product_data_tabs', array($this, 'product_auction_tab'));

            // Add options to general product data tab
            add_action('woocommerce_product_data_panels', array($this, 'add_product_data_panels'));
            // Save data product
            add_action('woocommerce_process_product_meta_' . self::$prod_type, array($this, 'save_auction_data'));

            //product columns
            add_filter('manage_product_posts_columns', array($this, 'product_columns'));
            add_action('manage_product_posts_custom_column', array($this, 'render_product_columns'), 10, 2);

            add_filter('woocommerce_free_price_html', array($this, 'change_free_price_product'), 10, 2);

            //order columns
            add_filter('woocommerce_admin_order_item_count', array($this, 'order_item_count'), 10, 2);
            add_filter('woocommerce_order_item_name', array($this, 'order_item_name'), 10, 2);

        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @use     /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function register_panel()
        {

            if (!empty($this->_panel)) {
                return;
            }

            $admin_tabs = apply_filters('yith_wcact_admin_tabs', array(
                    'settings' => __('Settings', 'yith-auctions-for-woocommerce'),
                )
            );

            if( $this->show_premium_landing ){
                $admin_tabs['premium'] = __( 'Premium Version', 'yith-auctions-for-woocommerce' );
            }

            $args = array(
                'create_menu_page' => true,
                'parent_slug' => '',
                'page_title' => _x('Auctions', 'plugin name in admin page title', 'yith-auctions-for-woocommerce'),
                'menu_title' => _x('Auctions', 'plugin name in admin WP menu', 'yith-auctions-for-woocommerce'),
                'capability' => 'manage_options',
                'parent' => '',
                'parent_page' => 'yit_plugin_panel',
                'page' => $this->_panel_page,
                'admin-tabs' => $admin_tabs,
                'options-path' => YITH_WCACT_OPTIONS_PATH,
                'links' => $this->get_sidebar_link()
            );


            /* === Fixed: not updated theme/old plugin framework  === */
            if (!class_exists('YIT_Plugin_Panel_WooCommerce')) {
                require_once('plugin-fw/lib/yit-plugin-panel-wc.php');
            }


            $this->_panel = new YIT_Plugin_Panel_WooCommerce($args);

            add_action('woocommerce_admin_field_yith_auctions_upload', array($this->_panel, 'yit_upload'), 10, 1);
        }

        /**
         * Show the premium landing
         *
         * @author Carlos Rodriguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0.0
         * @return void
         */
        public function show_premium_landing(){
            if( file_exists( YITH_WCACT_TEMPLATE_PATH . 'premium/premium.php' )&& $this->show_premium_landing ){
                require_once( YITH_WCACT_TEMPLATE_PATH . 'premium/premium.php' );
            }
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri()
        {
            return defined('YITH_REFER_ID') ? $this->_premium_landing_url . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing_url.'?refer_id=1030585';
        }

        /**
         * Sidebar links
         *
         * @return   array The links
         * @since    1.2.1
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function get_sidebar_link()
        {
            $links = array(
                array(
                    'title' => __('Plugin documentation', 'yith-auctions-for-woocommerce'),
                    'url' => $this->_official_documentation,
                ),
                array(
                    'title' => __('Help Center', 'yith-auctions-for-woocommerce'),
                    'url' => 'http://support.yithemes.com/hc/en-us/categories/202568518-Plugins',
                ),
                array(
                    'title' => __('Support platform', 'yith-auctions-for-woocommerce'),
                    'url' => 'https://yithemes.com/my-account/support/dashboard/',
                ),
                array(
                    'title' => sprintf('%s (%s %s)', __('Changelog', 'yith-auctions-for-woocommerce'), __('current version', 'yith-auctions-for-woocommerce'), YITH_WCACT_VERSION),
                    'url' => 'https://yithemes.com/docs-plugins/yith-woocommerce-auctions/changelog',
                ),
            );

            return $links;
        }


        /**
         * Enqueue Scripts
         *
         * Register and enqueue scripts for Admin
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return void
         */

        public function enqueue_scripts()
        {

            $screen = get_current_screen();
            $is_product = $screen->id === 'product';
            global $post;
            /* === CSS === */
            wp_register_style('yith-wcact-admin-css', YITH_WCACT_ASSETS_URL . 'css/admin.css');
            wp_register_style('yith-wcact-timepicker-css', YITH_WCACT_ASSETS_URL . 'css/timepicker.css');
            /* === Script === */
            wp_register_script('yith-wcact-datepicker', YITH_WCACT_ASSETS_URL . 'js/datepicker.js', array('jquery', 'jquery-ui-datepicker'), YITH_WCACT_VERSION, 'true');
            wp_register_script('yith-wcact-timepicker', YITH_WCACT_ASSETS_URL . 'js/timepicker.js', array('jquery', 'jquery-ui-datepicker'), YITH_WCACT_VERSION, 'true');

            $premium_suffix = defined( 'YITH_WCACT_PREMIUM' ) && YITH_WCACT_PREMIUM ? '-premium' : '';
            wp_register_script( 'yith-wcact-admin', YITH_WCACT_ASSETS_URL . 'js/admin' . $premium_suffix . '.js', array( 'jquery' ), YITH_WCACT_VERSION, true );

            wp_localize_script('yith-wcact-admin', 'object', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'id' => $post,
            ));
            wp_enqueue_style('yith-wcact-auction-font', YITH_WCACT_ASSETS_URL . '/fonts/icons-font/style.css');

            if ($is_product) {
                /* === CSS === */
                wp_enqueue_style('yith-wcact-timepicker-css');

                /* === Script === */

                wp_enqueue_script('yith-wcact-datepicker');
                wp_enqueue_script('yith-wcact-timepicker');
                wp_enqueue_script('yith-wcact-admin');
                wp_deregister_script('acf-timepicker');


            }
            wp_enqueue_style('yith-wcact-admin-css');

            do_action('yith_wcact_enqueue_scripts');

        }


        /**
         * Add Auction Product type in product type selector [in product wc-metabox]
         *
         * @access   public
         * @since    1.0.0
         * @return   array
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function product_type_selector($types)
        {
            $types['auction'] = _x('Auction', 'Admin: product type', 'yith-auctions-for-woocommerce');

            return $types;
        }


        /**
         * Add tab for auction products
         *
         * @param $tabs
         *
         * @return array
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function product_auction_tab($tabs)
        {
            $tabs['general']['class'][] = 'hide_if_auction';
            $tabs['inventory']['class'][] = 'show_if_auction';
            $new_tabs = array(
                'yith_Auction' => array(
                    'label' => __('Auction', 'yith-auctions-for-woocommerce'),
                    'target' => 'yith_auction_settings',
                    'class' => array('show_if_auction active'),
                ),
            );
            $tabs = array_merge($new_tabs, $tabs);

            return $tabs;
        }


        /**
         * Add panels for auction products
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function add_product_data_panels()
        {
            global $post;
            $tabs = array(
                'auction' => 'yith_auction_settings',

            );

            foreach ($tabs as $key => $tab_id) {

                echo "<div id='{$tab_id}' class='panel woocommerce_options_panel'>";
                include(YITH_WCACT_TEMPLATE_PATH . 'admin/product-tabs/' . $key . '-tab.php');
                echo '</div>';
            }
        }

        /**
         * Save the data input into the auction product box
         * @param $post_id
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since    1.0.6
         */
        public function save_auction_data($post_id)
        {

            $product_type = empty($_POST['product-type']) ? 'simple' : sanitize_title(stripslashes($_POST['product-type']));
            if ('auction' == $product_type) {

                $auction_product = wc_get_product($post_id);

                if (isset($_POST['_yith_auction_for'])) {
                    $my_date = $_POST['_yith_auction_for'];
                    $gmt_date = get_gmt_from_date($my_date);
                    yit_save_prop($auction_product, '_yith_auction_for', strtotime($gmt_date),true);
                }
                if (isset($_POST['_yith_auction_to'])) {
                    $my_date = $_POST['_yith_auction_to'];
                    $gmt_date = get_gmt_from_date($my_date);
                    yit_save_prop($auction_product, '_yith_auction_to', strtotime($gmt_date),true);
                }
                // Prevent issue with stock managing
                yit_save_prop($auction_product, 'manage_stock', 'yes');
                yit_update_product_stock($auction_product,1,'set');

                if (isset($_POST['_stock_status'])) {
                    yit_save_prop($auction_product, '_stock_status', $_POST['_stock_status']);
                }

                //Prevent issues with orderby in shop loop
                $bids = YITH_Auctions()->bids;
                $exist_auctions = $bids->get_max_bid($post_id);
                if (!$exist_auctions) {
                    yit_save_prop($auction_product, '_yith_auction_start_price',0);
                    yit_save_prop($auction_product, '_price',0);
                }
            }
        }

        /**
         * Add columns product datatable
         *
         * Add columns Start Date and close Date in Products datatable
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return array
         */
        public function product_columns($existing_columns)
        {
            $existing_columns['yith_auction_start_date'] = __('Start Date', 'yith-auctions-for-woocommerce');
            $existing_columns['yith_auction_end_date'] = __('End Date', 'yith-auctions-for-woocommerce');
            $existing_columns['yith_auction_status'] = '<span class="yith-wcact-auction-status yith-auction-status-column tips" data-tip="' . esc_attr__('Auction status', 'yith-auctions-for-woocommerce') . '"></span>';

            return $existing_columns;
        }


        /**
         * render products columns
         *
         * Add content to Start date and Close date
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return void
         */
        public function render_product_columns($column, $product_id)
        {
            $terms = get_the_terms($product_id, 'product_type');
            $product_type = !empty($terms) && isset(current($terms)->name) ? sanitize_title(current($terms)->name) : 'simple';
            $auction_product = wc_get_product($product_id);
            if ('auction' === $product_type) {
                switch ($column) {
                    case 'yith_auction_start_date' :
                        $dateinic = yit_get_prop($auction_product, '_yith_auction_for', true);
                        if ($dateinic) {
                            echo date(wc_date_format() . ' ' . wc_time_format(), $dateinic);
                        }

                        break;
                    case 'yith_auction_end_date' :
                        $dateclose = yit_get_prop($auction_product, '_yith_auction_to', true);
                        if ($dateclose) {
                            echo date(wc_date_format() . ' ' . wc_time_format(), $dateclose);
                        }
                        break;
                    case 'yith_auction_status':
                        $type = $auction_product->get_auction_status();
                        switch ($type) {
                            case 'non-started' :
                                echo '<span class="yith-wcact-auction-status yith-auction-non-start tips" data-tip="' . esc_attr__('Not Started', 'yith-auctions-for-woocommerce') . '"></span>';
                                break;
                            case 'started' :
                                echo '<span class="yith-wcact-auction-status yith-auction-started tips" data-tip="' . esc_attr__('Started', 'yith-auctions-for-woocommerce') . '"></span>';
                                break;
                            case 'finished' :
                                echo '<span class="yith-wcact-auction-status yith-auction-finished tips" data-tip="' . esc_attr__('Finished', 'yith-auctions-for-woocommerce') . '"></span>';
                                break;
                        }
                        do_action('yith_wcact_render_product_columns_auction_status',$column,$type,$auction_product);
                        break;
                    default :
                        break;
                }
            }

        }

        /**
         * Change price product
         *
         * Change price Free to 0.00 in admin product datatable
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return $price
         */
        public function change_free_price_product($price, $product)
        {
            if ('auction' == $product->get_type()) {
                $price = wc_price(0);
            }

            return $price;
        }

        /**
         * Order_item_count
         *
         * Show in Order datatable in purchased the items and the auction items
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return string
         */
        public function order_item_count($count, $order)
        {

            $auction = 0;
            foreach ($order->get_items() as $item) {
                $product = $order->get_product_from_item($item);
                if ($product && 'auction' == $product->get_type()) {
                    $auction++;
                }
            }
            if ($auction > 0) {
                $count .= ' ' . sprintf(_n('[%s auction]', '[%s auctions]', (int)$auction, 'yith-auctions-for-woocommerce'), (int)$auction);
            }

            return $count;
        }

        /**
         * Order item name
         *
         * Show purchase items if the product item = auction, show item_name + "Auction element" in order datatable
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return string
         */

        public function order_item_name($item_name, $item)
        {
            $product = wc_get_product($item['product_id']);
            if ($product && 'auction' == $product->get_type()) {
                $item_name = $item_name . __(' [Auction element]', 'yith-auctions-for-woocommerce');
            }

            return $item_name;
        }
        

        /**
         * Create link that regenerate auction prices
         *
         * @return void
         * @since    1.0.11
         * @author   Carlos Rodríguez <carlos.rodriguez@youirinspiration.it>
         */
        public function yith_regenerate_prices($value)
        {
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr($value['id']); ?>"><?php echo esc_html($value['title']); ?></label>
                </th>
                <td class="forminp forminp-<?php echo sanitize_title($value['type']) ?>">
                    <?php echo $value['html'] ?>
                    <span>
                        <?php echo $value['desc'] ?>
                    </span>
                </td>
            </tr>
            <?php
        }

        /**
         * Regenerate auction prices
         *
         * regenerate auction prices for each product
         *
         * @return void
         * @since    1.0.11
         * @author   Carlos Rodríguez <carlos.rodriguez@youirinspiration.it>
         */
        public function regenerate_auction_prices()
        {
            if (current_user_can('manage_options')) {
                if ($auction_term = get_term_by('slug', 'auction', 'product_type')) {
                    $auction_ids = array_unique((array)get_objects_in_term($auction_term->term_id, 'product_type'));
                    if ($auction_ids) {
                        foreach ($auction_ids as $auction_id) {
                            $auction_product = wc_get_product($auction_id);
                            $actual_price = $auction_product->get_current_bid();
                            yit_save_prop($auction_product, 'price', $actual_price);
                        }
                    }
                }
            }
        }
    }
}