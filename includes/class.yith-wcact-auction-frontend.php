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
 * @class      YITH_Auctions_Frontend
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
 *
 */
if ( !class_exists( 'YITH_Auction_Frontend' ) ) {



    /**
     * Class YITH_Auctions_Frontend
     *
     * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
     */
    class YITH_Auction_Frontend
    {
        /**
         * Single instance of the class
         *
         * @var \YITH_Auction_Admin
         * @since 1.0.0
         */
        protected static $instance;

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
            add_action('woocommerce_auction_add_to_cart', array($this, 'print_add_to_cart_template'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
            add_filter('woocommerce_product_tabs', array($this, 'create_bid_tab'), 999);

            add_action('woocommerce_after_shop_loop_item', array($this, 'auction_end_start'), 8);
            add_filter('woocommerce_product_add_to_cart_text', array($this, 'change_button_auction_shop'), 10, 2);
            add_filter('woocommerce_get_price_html', array($this, 'change_product_price_display'), 10, 2);
            add_filter('woocommerce_empty_price_html', array($this, 'set_empty_product_price'), 10, 2);
            add_filter('woocommerce_free_price_html', array($this, 'set_empty_product_price'), 10, 2);

            add_action('woocommerce_before_shop_loop_item_title', array($this, 'auction_badge_shop'), 10);
            
            if ( version_compare( WC()->version , '2.7.0', '>=' ) ) {
                add_filter('woocommerce_single_product_image_thumbnail_html', array($this,'add_badge_single_product'));
            } else {
                add_filter('woocommerce_single_product_image_html', array($this, 'add_badge_single_product'));
            }

            add_action('woocommerce_login_form_end', array($this, 'add_redirect_after_login'));
            add_action('yith_wcact_auction_before_set_bid',array($this,'add_auction_timeleft'));


            add_action('yith_wcact_auction_end',array($this,'auction_end'));
        }

        /**
         * Enqueue Scripts
         *
         * Register and enqueue scripts for Frontend
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0.0
         * @return void
         */
        public function enqueue_scripts()
        {

            wp_register_style('yith-wcact-frontend-css', YITH_WCACT_ASSETS_URL . 'css/frontend.css');

            /* === Script === */
            wp_register_script('yith-wcact-frontend-js', YITH_WCACT_ASSETS_URL . 'js/frontend.js', array('jquery', 'jquery-ui-datepicker'), '1.0.0', 'true');

            //Localize scripts for ajax call
            wp_localize_script('yith-wcact-frontend-js', 'object', array(
                'ajaxurl' => admin_url('admin-ajax.php')
            ));

            if (apply_filters('yith_wcact_load_script_everywhere', false) || is_shop() || is_archive()) {
                /* === CSS === */
                wp_enqueue_style('yith-wcact-frontend-css');

                /* === Script === */

                wp_enqueue_script('yith_wcact_frontend_shop', YITH_WCACT_ASSETS_URL . '/js/frontend_shop.js', array('jquery', 'jquery-ui-sortable'), YITH_WCACT_VERSION, true);
                wp_localize_script('yith_wcact_frontend_shop', 'object', array(
                    'ajaxurl' => admin_url('admin-ajax.php')
                ));
            }

            if (is_product()) {
                /* === CSS === */
                wp_enqueue_style('yith-wcact-frontend-css');
                /* === Script === */
                wp_enqueue_script('yith-wcact-frontend-js');
            }

            do_action('yith_wcact_enqueue_fontend_scripts');

        }

        /**
         * Auction template
         *
         * Add the auction template
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return void
         */
        public function print_add_to_cart_template()
        {

            wc_get_template('single-product/add-to-cart/auction.php', array(), '', YITH_WCACT_TEMPLATE_PATH . 'woocommerce/');
        }
        /**
         * Bid tab
         *
         * Create the "Bid" tab to show the all bids of the product
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0.0
         * @return void
         */
        public function create_bid_tab($tabs)
        {
            global $product;
            if ('auction' == $product->get_type()) {
                // Adds the new tab
                $tabs['Mytab'] = array(
                    'title' => __('Bids', 'yith-auctions-for-woocommerce'),
                    'priority' => 1,
                    'callback' => array($this, 'bids_content')
                );
                // set "tab bid" at the first tab in product tabs
                $priority = array();
                foreach ($tabs as $clave => $valor) {
                    $priority[] = $valor['priority'];
                }
                array_multisort($priority, SORT_ASC, $tabs);
                array_multisort($priority, SORT_DESC);

                $size = 0;
                foreach ($tabs as $clave => $valor) {
                    $tabs[$clave]['priority'] = $priority[$size];

                    $size++;
                }
            }
            return $tabs;

        }

        public function bids_content()
        {
            global $product;
            $args = array(
                'product' =>$product
            );
            wc_get_template('list-bids.php', $args, '', YITH_WCACT_TEMPLATE_PATH . 'frontend/');
        }





        /**
         * Auction end
         *
         * ​Show the Auction end or show the auction start if the auction start after today's date (in shop page)
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return void
         */
        public function auction_end_start()
        {
            global $product;

            if ('auction' == $product->get_type()) {

                $auction_start = yit_get_prop($product, '_yith_auction_for', true);
                $auction_end = yit_get_prop($product, '_yith_auction_to', true);
                $date = strtotime('now');

                if ($date < $auction_start) {
                    echo '<div id="auction_end_start">';
                    echo sprintf(_x('Auction start:', 'Auction end: 10 Jan 2016 10:00', 'yith-auctions-for-woocommerce'));
                    echo '<p class="date_auction" data-yith-product="' . $product->get_id() . '">' . $auction_start . '</p>';
                    echo '</div>';
                } else {
                    if (!empty($auction_end) && !$product->is_closed()) {
                        echo '<div id="auction_end_start">';
                        echo sprintf(_x('Auction end:', 'Auction end: 10 Jan 2016 10:00', 'yith-auctions-for-woocommerce'));
                        echo '<p class="date_auction" data-yith-product="' . $product->get_id() . '">' . $auction_end . '</p>';
                        echo '</div>';
                    }
                }

            }
        }

        /**
         * Change text button
         *
         * Change text Auction button (in shop page)
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         */
        public function change_button_auction_shop($text, $product)
        {

            if ('auction' == $product->get_type() && !$product->is_closed()) {
                return __('Bid now', 'yith-auctions-for-woocommerce');
            }

            return $text;
        }


        /**
         * Change display product
         *
         * Change text product price in shop and cart item
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0.11
         */
        public function change_product_price_display($price, $product)
        {
            if (is_shop() || is_product()) {
                if ('auction' == $product->get_type()) {
                    if ($product->is_start()) {
                        $price_html = sprintf(__('Current bid: %s', 'yith-auctions-for-woocommerce'), $price);
                    } else {
                        $price_html = "";
                    }
                    $price = apply_filters('yith_wcact_auction_price_html', $price_html, $product, $price);
                }

            }

            return $price;
        }

        /**
         *  Show auction timeleft
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0.14
         */
        public function add_auction_timeleft( $product ) {
            $args = array(
                'product' =>$product,
            );
            wc_get_template('auction-timeleft.php', $args, '', YITH_WCACT_TEMPLATE_PATH . 'frontend/');
        }

        /**
         * Change empty product price
         *
         * If not product price, set product price = 0
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return void
         */

        public function set_empty_product_price($price, $product)
        {
            if ('auction' == $product->get_type()) {
                $price = wc_price(0);
            }

            return $price;
        }

        /**
         * Badge Shop
         *
         * Add a badge if product type is: auction (in shop page)
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return void
         */

        public function auction_badge_shop()
        {
            global $product;
            $img = YITH_WCACT_ASSETS_URL . '/images/badge.png';
            if ('auction' == $product->get_type() && $img) {
                echo '<span class="yith-wcact-aution-badge"><img src="' . $img . '"></span>';
            }
        }

        /**
         * Badge single product
         *
         * Add a badge if product type is: auction (in simple product)
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         * @return void
         */
        public function add_badge_single_product($output)
        {
            global $product;
            $img = YITH_WCACT_ASSETS_URL . '/images/badge.png';
            if ('auction' == $product->get_type() && $img) {
                $output .= '<span class="yith-wcact-aution-badge"><img src="' . $img . '"></span>';
            }

            return $output;
        }

        /**
         *  add_redirect_after_login
         *  add custom $_GET parameters in form for redirect to single product page
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         */
        public function add_redirect_after_login()
        {

            ?>
            <?php if (!empty($_GET['redirect_after_login'])) : ?>
            <input type="hidden" name="redirect" value="<?php echo $_GET['redirect_after_login'] ?>"/>
        <?php endif ?>
            <?php

        }

        public function auction_end($product) {

            $instance = YITH_Auctions()->bids;
            $max_bid = $instance->get_max_bid($product->get_id());

            $current_user = wp_get_current_user();

            if ($max_bid && $current_user->ID == $max_bid->user_id) {

                ?>
                <div id="Congratulations">
                    <h2><?php _e('Congratulations, you won this auction', 'yith-auctions-for-woocommerce') ?></h2>
                </div>
                <form class="cart" method="get" enctype='multipart/form-data'>
                    <input type="hidden" name="yith-wcact-pay-won-auction"
                           value="<?php echo esc_attr($product->get_id()); ?>"/>
                    <?php
                    if (!$product->is_paid() && ('yes' == get_option('yith_wcact_settings_tab_auction_show_button_pay_now'))) {
                        ?>
                        <button type="submit" class="auction_add_to_cart_button button alt"
                                id="yith-wcact-auction-won-auction">
                            <?php echo sprintf(__('Pay now', 'yith-auctions-for-woocommerce')); ?>
                        </button>
                        <?php
                    }
                    ?>
                </form>
                <?php
            }
        }


    }
}