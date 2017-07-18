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
 * @class      YITH_AUCTIONS
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Your Inspiration Themes
 *
 */

if ( ! class_exists( 'WC_Product_Auction' ) ) {
    /**
     * Class WC_Product_Auction
     *
     * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
     */
    class WC_Product_Auction extends WC_Product {
        /**
         * Constructor gets the post object and sets the ID for the loaded product.
         *
         * @param int|WC_Product|object $product Product ID, post object, or product object
         */

        protected $status = false;

        public function __construct( $product ) {
            //Compatibility between 2.6 and 2.7
            yit_set_prop($this,'manage_stock','yes');
            
            if ( $this instanceof WC_Data ) {
                $this->set_stock_quantity(1);
            } else {
                $this->stock = 1;
                $this->product_type = 'auction';
            }
            parent::__construct( $product );
        }
        /**
         * Get internal type.
         *
         * @since 2.7.0
         * @return string
         */
        public function get_type() {
            return 'auction';
        }
        /**
         *  Get current bid of the product.
         *
         */
        public function get_price( $context = 'view' ) {
            if ( $this instanceof WC_Data ) {
                $price = $this->get_prop( 'price', $context );

                return '' !== $price ? $price : $this->get_current_bid();
            } else {
                return apply_filters( 'woocommerce_get_price', isset( $this->price ) ? $this->price : $this->get_current_bid(), $this );
            }
        }

        public function get_current_bid() {
            $bids    = YITH_Auctions()->bids;
            $current_bid = yit_get_prop($this,'_yith_auction_start_price');
            $max_bid = $bids->get_max_bid($this->get_id());

            if ($max_bid && isset($max_bid->bid) && $max_bid->bid >= $current_bid) {

                $current_bid = $max_bid->bid;
            }
            $the_current_bid = apply_filters( 'yith_wcact_get_current_bid', $current_bid, $this );
            yit_set_prop($this,'current_bid',$the_current_bid);

            return $the_current_bid;
        }



        /**
         *  Get start price of the product.
         *
         */
        public function get_start_price() {
            $start_price = yit_get_prop($this,'_yith_auction_start_price');
            return isset( $start_price ) ? $start_price : false;
        }


        /**
         *  Check if the auction is start.
         *
         */
        public function is_start() {
            $start_time = yit_get_prop($this,'_yith_auction_for');
            if ( isset($start_time) && $start_time ){

                $date_for = $start_time;
                $date_now = strtotime('now');

                if( $date_for <= $date_now){

                    return TRUE;

                } else{

                    return FALSE;
                }

            } else {

                return TRUE;
            }
        }

        /**
         *  Check if the auction is close.
         *
         */
        public function is_closed() {
            $end_time = yit_get_prop($this,'_yith_auction_to');
            if ( isset($end_time) && $end_time ) {
                $date_to = $end_time;
                $date_now = strtotime('now');

                if ( $date_to <= $date_now){

                    return TRUE;
                } else {
                    return FALSE;
                }


            } else {
                return TRUE;
            }
        }


        /**
         *  Check if the auction is paid
         *
         */
        public function is_paid(){
            $is_paid = yit_get_prop($this,'_yith_auction_paid_order');
            if (isset($is_paid) && $is_paid ) {

                return TRUE;

            } else {

                return FALSE;
            }
        }

        /**
         *  return status of auction
         *
         */
        public function get_auction_status(){

            if ( $this->is_start() && !$this->is_closed() ) {
                return 'started';

            } elseif ( $this->is_closed() ) {
                return 'finished';

            } else {
                return 'non-started';
            }
        }

    }

}




