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
 * WPML Integration Class
 *
 * @class      YITH_WCACT_WPML_Compatibility
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Your Inspiration Themes
 *
 */
if ( ! class_exists( 'YITH_WCACT_WPML_Compatibility' ) ) {

    class YITH_WCACT_WPML_Compatibility
    {
        /**
         * Single instance of the class
         *
         * @var \YITH_WCACT_WPML_Compatibility
         */
        protected static $instance;

        /**
         * @var SitePress
         */
        public $sitepress;

        /**
         * @var string
         */
        public $current_language;

        /**
         * @var string
         */
        public $default_language;

        /**
         * Constructor
         *
         * @param bool $plugin_active
         * @param bool $integration_active
         *
         * @access protected
         */
        public function __construct( ) {
            if ( $this->is_active() ) {
                $this->_init_wpml_vars();
                $this->_load_classes();
            }
        }

        /**
         * init the WPML vars
         */
        protected function _init_wpml_vars() {
            if ( $this->is_active() ) {
                global $sitepress;
                $this->sitepress        = $sitepress;
                $this->current_language = $this->sitepress->get_current_language();
                $this->default_language = $this->sitepress->get_default_language();
            }
        }

        /**
         * get the class name from slug
         *
         * @param $slug
         *
         * @return string
         */
        public function get_class_name_from_slug( $slug ) {
            $class_slug = str_replace( '-', ' ', $slug );
            $class_slug = ucwords( $class_slug );
            $class_slug = str_replace( ' ', '_', $class_slug );

            return 'YITH_WCACT_WPML_' . $class_slug;
        }

        /**
         * init the WPML vars
         */
        protected function _load_classes() {
            $utils = array(
                'auction-product',
            );

            foreach ( $utils as $util ) {
                $filename  = YITH_WCACT_PATH . '/includes/compatibility/wpml/class.yith-wcact-wpml-' . $util . '.php';
                $classname = $this->get_class_name_from_slug( $util );

                $var = str_replace( '-', '_', $util );
                if ( file_exists( $filename ) && !class_exists( $classname ) ) {
                    require_once( $filename );
                }

                if ( method_exists( $classname, 'get_instance' ) ) {
                    $this->$var = $classname::get_instance( $this );
                }
            }
        }

        /**
         * return true if WPML is active
         *
         * @return bool
         */
        public function is_active() {
            global $sitepress;

            return !empty( $sitepress );
        }

        /**
         * restore the current language
         */
        public function restore_current_language() {
            $this->sitepress->switch_lang( $this->current_language );
        }

        /**
         * Set the current language to default language
         */
        public function set_current_language_to_default() {
            $this->sitepress->switch_lang( $this->default_language );
        }


    }
    return new YITH_WCACT_WPML_Compatibility();
}