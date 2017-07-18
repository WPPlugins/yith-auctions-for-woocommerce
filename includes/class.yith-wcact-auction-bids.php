<?php
/**
 * Notes class
 *
 * @author  Yithemes
 * @package YITH WooCommerce Auctions
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCACT_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}


if ( !class_exists( 'YITH_WCACT_Bids' ) ) {
    /**
     * YITH_WCACT_Bids
     *
     * @since 1.0.0
     */
    class YITH_WCACT_Bids {

        /**
         * Single instance of the class
         *
         * @var \YITH_WCACT_Bids
         * @since 1.0.0
         */
        protected static $instance;

        public $table_name = '';


        /**
         * Returns single instance of the class
         *
         * @return \YITH_WCACT_Bids
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
         * Constructor
         *
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function __construct() {
            global $wpdb;
            $this->table_name = $wpdb->prefix . YITH_WCACT_DB::$auction_table;
        }

        /**
         * @param        $user_id
         * @param        $auction_id
         * @param        $bid
         * @param        $date
         */
        public function add_bid( $user_id, $auction_id, $bid, $date) {
            global $wpdb;

            $insert_query = "INSERT INTO $this->table_name (`user_id`, `auction_id`, `bid`, `date`) VALUES ('" . $user_id . "', '" . $auction_id . "', '" . $bid . "' , '" . $date . "' )";
            $wpdb->query( $insert_query );
        }

        /**
         * @param $auction_id
         *
         * @return array|null|object
         */
        public function get_bids_auction( $auction_id ) {
            global $wpdb;

            $query   = $wpdb->prepare( "SELECT * FROM $this->table_name WHERE auction_id = %d ORDER by CAST( bid AS decimal(50,5)) DESC, date ASC", $auction_id );
            $results = $wpdb->get_results( $query );

            return $results;
        }

        /**
         * @param $auction_id
         *
         * @return array|null|object
         */
        public function get_tab_bid( $product_id, $current_bid ) {
            global $wpdb;

            $query   = $wpdb->prepare( "SELECT * FROM $this->table_name WHERE auction_id = %d AND bid >= %d ORDER by date ASC", $product_id, $current_bid );
            $results = $wpdb->get_results( $query );

            return $results;
        }



        /**
         * @param $auction_id
         *
         * @return array|null|object
         */
        public function get_max_bid($product_id){
            global $wpdb;

            $query   = $wpdb->prepare( "SELECT * FROM $this->table_name WHERE auction_id = %d ORDER by CAST(bid AS decimal(50,5)) DESC, date ASC LIMIT 1", $product_id );
            $results = $wpdb->get_row( $query );

            return $results;
        }

        /**
         * @param $auction_id
         *
         * @return array|null|object
         */
        public function get_last_two_bids($product_id){
            global $wpdb;

            $bids = array();
            $first_bid = $this->get_max_bid($product_id);
            if($first_bid){
                $bids[] = $first_bid;
                if ( isset($first_bid->user_id) ) {
                    $query = $wpdb->prepare( "SELECT * FROM $this->table_name WHERE auction_id = %d AND user_id <> %d ORDER by CAST(bid AS decimal(50,5)) DESC, date ASC LIMIT 1",$product_id,$first_bid->user_id);
                    $second_bid = $wpdb->get_row( $query );
                    if($second_bid){
                        $bids[] = $second_bid;
                    }
                }
            }

            return $bids;
        }

        /**
         * @param $auction_id
         *
         * @return null|object
         */
        public function get_last_bid_user( $user_id, $auction_id ) {
            global $wpdb;

            $query   = $wpdb->prepare( "SELECT bid FROM $this->table_name WHERE user_id = %d AND auction_id = %d ORDER by date DESC LIMIT 1", $user_id, $auction_id );
            $results = $wpdb->get_var( $query );

            return $results;
        }

        /**
         * @param $product_id
         *
         * @return null|object
         */
        public function get_users( $product_id ) {
            global $wpdb;

            $query   = $wpdb->prepare( "SELECT DISTINCT  user_id FROM $this->table_name WHERE auction_id = %d ", $product_id );
            $results = $wpdb->get_results( $query );

            return $results;
        }

        /**
         * @param $product_id
         *
         * @return null|object
         */
        public function get_auctions_by_user( $user_id ) {
            global $wpdb;

            $query   = $wpdb->prepare( "SELECT auction_id FROM $this->table_name WHERE user_id = %d GROUP by auction_id ORDER by date DESC", $user_id);
            $results = $wpdb->get_results( $query );

            foreach ($results as &$valor) {
                $query   = $wpdb->prepare( "SELECT bid FROM $this->table_name WHERE auction_id = %d AND user_id = %d ORDER by CAST(bid AS decimal(50,5)) DESC, date ASC LIMIT 1", $valor->auction_id, $user_id );
                $result = $wpdb->get_var( $query );
                $valor->max_bid = $result;
            }

            return $results;
        }

        /**
         * @param $auction_id
         *
         * @return null|object
         */
        public function reshedule_auction($auction_id){
            global $wpdb;
            $query = $wpdb->prepare("DELETE FROM $this->table_name WHERE auction_id=%d",$auction_id);
            $results = $wpdb->get_results($query);
            return $results;
        }
    }
}