<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * WPML Auction Product Class
 *
 * @class   YITH_WCACT_WPML_Auction_Product
 * @package Yithemes
 * @since   1.0.3
 * @author  Yithemes
 *
 */
class YITH_WCACT_WPML_Auction_Product {
    /**
     * Single instance of the class
     *
     * @var \YITH_WCACT_WPML_Auction_Product
     */
    protected static $instance;

    /**
     * @var YITH_WCACT_WPML_Compatibility
     */
    public $wpml_integration;

    /**
     * Returns single instance of the class
     *
     * @param YITH_WCACT_WPML_Compatibility $wpml_integration
     *
     * @return YITH_WCACT_WPML_Auction_Product
     */
    public static function get_instance( $wpml_integration ) {
        if ( is_null( static::$instance ) ) {
            static::$instance = new static( $wpml_integration );
        }

        return static::$instance;
    }

    /**
     * Constructor
     *
     * @access protected
     *
     * @param YITH_WCACT_WPML_Compatibility $wpml_integration
     */
    protected function __construct( $wpml_integration ) {
        $this->wpml_integration = $wpml_integration;
        add_filter('woocommerce_get_price',array($this,'get_parent_price'),10,2);
        add_filter('yith_wcact_auction_product_id',array($this,'get_parent_id'));
        add_filter('yith_wcact_get_auction_product',array($this,'get_parent_product'));
    }


    /**
     * Get parent price
     *
     * @param $value
     * @param $key
     * @param $product
     *
     * @return mixed
     */
    public function get_parent_price($price,$product) {
        global $wpml_post_translations;
        $id = $product->get_id();
        if ( $wpml_post_translations && $parent_id = $wpml_post_translations->get_original_element( $id ) ) {
            $parent_product = wc_get_product($parent_id);
            return $parent_product->get_price();
        }
        return $price;
    }
    /**
     * Get parent product id
     *
     * @param $value
     * @param $key
     * @param $product
     *
     * @return mixed
     */
    public function get_parent_id($product_id) {
        global $wpml_post_translations;
        if ( $wpml_post_translations && $parent_id = $wpml_post_translations->get_original_element( $product_id ) ) {
            return $parent_id;
        }
        return $product_id;
    }

    public function get_parent_product( $product ) {
        global $wpml_post_translations;
        $id = $product->get_id();
        if ( $wpml_post_translations && $parent_id = $wpml_post_translations->get_original_element( $id ) ) {
            $parent_product = wc_get_product($parent_id);
            return $parent_product;
        }
        return $product;
    }


}