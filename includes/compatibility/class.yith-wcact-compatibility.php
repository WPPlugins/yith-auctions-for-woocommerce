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
 * @class      YITH_WCACT_Compatibility
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Your Inspiration Themes
 *
 */
if ( ! class_exists( 'YITH_WCACT_Compatibility' ) ) {

    class YITH_WCACT_Compatibility
    {

        protected static $instance;

        protected $_plugins = array();

        public static function get_instance()
        {
            $self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

            if ( is_null( $self::$instance ) ) {
                $self::$instance = new $self;
            }

            return $self::$instance;
        }

        public function __construct()
        {
            $this->_plugins = array(
                'wpml' => 'WPML',
            );
            $this->_load();
        }

        private function _load()
        {
            foreach ($this->_plugins as $slug => $class_slug) {
                $filename = YITH_WCACT_PATH . 'includes/compatibility/class.yith-wcact-' . $slug . '-compatibility.php';
                $classname = 'YITH_WCACT_' . $class_slug . '_Compatibility';
              
                $var = str_replace('-', '_', $slug);
                if ($this::has_plugin($slug) && file_exists($filename) && !function_exists($classname)) {
                    require_once($filename);
                }

                if (function_exists($classname)) {
                    $this->$var = $classname();
                }
            }
        }

        public static function has_plugin($slug)
        {
            switch ($slug) {
                case 'wpml':
                    global $sitepress;
                    return !empty( $sitepress );
                    break;
                default:
                    return false;
            }
        }
    }
}