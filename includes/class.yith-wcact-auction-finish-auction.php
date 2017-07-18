<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'YITH_WCACT_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

/**
 *
 *
 * @class
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Your Inspiration Themes
 *
 */

if ( ! class_exists( 'YITH_Auction_Finish_Auction' ) ) {
    /**
     * Class YITH_Auction_Won_Auction
     *
     * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
     */

    class YITH_Auction_Finish_Auction
    {

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

            add_action('wp_loaded', array($this, 'pay_won_auction'), 90);
            add_action('woocommerce_order_status_completed', array($this, 'disable_pay_now_button'));
            add_action('woocommerce_order_status_processing', array($this, 'disable_pay_now_button'));

            add_action('woocommerce_login_form_end',array($this,'add_redirect_after_login'));


        }

        /**
         * Pay won auction
         * Add the auction product to cart
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0.2
         */
        public function pay_won_auction()
        {

            if (!empty($_REQUEST['yith-wcact-pay-won-auction']) && is_numeric($_REQUEST['yith-wcact-pay-won-auction'])) {

                $product_id = $_REQUEST['yith-wcact-pay-won-auction'];

                if (!is_user_logged_in()){

                    $account = wc_get_page_permalink( 'myaccount');
                    $url_to_redirect = add_query_arg('redirect_after_login',get_permalink($product_id),$account);
                    wp_safe_redirect($url_to_redirect);
                    exit;
                }
                $instance = YITH_Auctions()->bids;
                $max_bid = $instance->get_max_bid($product_id);

                $product = wc_get_product($product_id);

                $current_user_id = get_current_user_id();

                if ($current_user_id == $max_bid->user_id && $product->is_closed()) {  //check if you are the winner user and if the auction is finished


                    //empty cart
                    WC()->cart->empty_cart();
                    //add_to_cart
                    WC()->cart->add_to_cart($product_id, 1, 0, array(), array(
                        'yith_auction_data' => array(
                            'won-auction' => true
                        )
                    ));

                    //get_checkout_url
                    wp_safe_redirect(wc_get_checkout_url());
                    exit;
                } else {

                    if ($product->is_closed()) {

                        wc_add_notice(__('You cannot buy this product', 'yith-auctions-for-woocommerce'), 'error');

                    }

                }


            }
        }

        /**
         * disable pay now button
         * disable pay now button when a product is order processing or completed
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         */
        public function disable_pay_now_button($order_id)
        {
            $order = wc_get_order($order_id);
            foreach ($order->get_items() as $item) {
                $_product = $order->get_product_from_item($item);
                yit_save_prop( $_product, '_yith_auction_paid_order', 1 );
            }

        }

        /**
         * add_redirect_after_login
         * redirect after login if click in pay now email and the user is not logged in
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0.2
         */
        public function add_redirect_after_login(){

            ?>
            <?php if ( !empty($_GET['redirect_after_login'] ) ) : ?>
                <input type="hidden" name="redirect" value="<?php echo $_GET['redirect_after_login'] ?>" />
            <?php endif ?>
            <?php

        }
    }
}

return new YITH_Auction_Finish_Auction();