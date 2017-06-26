<?php
/**
 * Shared validator class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Elections_Core
 * @subpackage Pv_Elections_Core/db
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Pagination' ) ) {
	class Pv_Core_Pagination {
		protected $plugin_name;
		protected $version;

        public function __construct( $plugin_name, $version ) {
            $this->plugin_name = $plugin_name;
            $this->version = $version;
        }
	}
}