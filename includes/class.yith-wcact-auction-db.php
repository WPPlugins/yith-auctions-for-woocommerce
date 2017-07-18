<?php
/**
 * DB class
 *
 * @author  Yithemes
 * @package YITH WooCommerce Booking
 * @version 1.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YITH_WCACT_DB' ) ) {
    /**
     * YITH WooCommerce Booking Database
     *
     * @since 1.0.0
     */
    class YITH_WCACT_DB {

        /**
         * DB version
         *
         * @var string
         */
        public static $version = '1.0.0';

        public static $auction_table = 'yith_wcact_auction';


        /**
         * Constructor
         *
         * @return YITH_WCBK_DB
         */
        private function __construct() {
        }

        public static function install() {
            self::create_db_table();
        }

        /**
         * create table for Notes
         *
         * @param bool $force
         */
        public static function create_db_table( $force = false ) {
            global $wpdb;

            $current_version = get_option( 'yith_wcact_db_version' );

            if ( $force || $current_version != self::$version ) {
                $wpdb->hide_errors();

                $table_name      = $wpdb->prefix . self::$auction_table;
                $charset_collate = $wpdb->get_charset_collate();

                $sql
                    = "CREATE TABLE $table_name (
                    `id` bigint(20) NOT NULL AUTO_INCREMENT,
                    `user_id` bigint(20) NOT NULL,
                    `auction_id` bigint(20) NOT NULL,
                    `bid` varchar(255) NOT NULL,
                    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                    ) $charset_collate;";

                if ( !function_exists( 'dbDelta' ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                }
                dbDelta( $sql );
                update_option( 'yith_wcact_db_version', self::$version );
            }
        }

    }
}