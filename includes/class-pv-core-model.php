<?php
/**
 * Shared root Model
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Core
 * @subpackage Pv_Core/includes
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Model' ) ) {
	/**
	 * Parent model
	 */
	class Pv_Core_Model {

		/**
		 * The plugin config
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      mixed     The config object.
		 */
		protected $config;

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      string    The PK of this plugin.
		 */
		protected $primary_key = 'id';

		/**
		 * The tablename
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      string    The name of the instanced table
		 */
		protected $tablename;

		/**
		 * The database object
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      mixed     The WBDB object.
		 */
		protected $dbase;

		/**
		 * The pagination array
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      mixed     start / stop
		 */
		protected $pagination;

		/**
		 * Setup!
		 *
		 * @param   mixed $config (the config object).
		 */
		public function __construct( $config ) {
			global $wpdb;

			$this->config = $config;
			$this->dbase = &$wpdb;
		}

		/**
		 * Gets a row.
		 *
		 * @param      int $value  (an ID).
		 *
		 * @return     mixed result row
		 */
		public function get_row( $value ) {
			if ( ! (int) $value ) {
				return false;
			}
			$sql = sprintf( ' SELECT * FROM `%s` WHERE `%s` = %%s ', $this->dbase->prefix . $this->tablename, $this->primary_key );
			$prepared = $this->dbase->prepare( $sql, (int) $value );
			return $this->dbase->get_row( $prepared );
		}

		/**
		 * Gets all rows.
		 *
		 * @return     mixed  all rows
		 */
		public function get_all() {
			$sql = sprintf( ' SELECT * FROM `%s` WHERE %%s ', $this->dbase->prefix . $this->tablename );
			$prepared = $this->dbase->prepare( $sql, 1 );

			return $this->dbase->get_results( $prepared );
		}

		/**
		 * Gets paged results
		 *
		 * @return     mixed paged result rows
		 */
		public function get_paged() {
			// Set pagination property.
			if ( ! $this->pagination ) {
				$this->set_pagination();
			}

			// Get results based on pagination property.
			$sql = sprintf( ' SELECT * FROM `%s` LIMIT %%d, %%d ', $this->dbase->prefix . $this->tablename );
			$prepared = $this->dbase->prepare( $sql, $this->pagination->start, $this->pagination->limit );

			return $this->dbase->get_results( $prepared );
		}

		/**
		 * Gets paged results
		 *
		 * @return     mixed paged result rows
		 */
		public function get_pagination() {
			// Set pagination property.
			if ( ! $this->pagination ) {
				$this->set_pagination();
			}

			return $this->pagination;
		}

		/**
		 * Gets the total.
		 *
		 * @return     int  The total.
		 */
		public function get_total() {
			$sql = sprintf( ' SELECT COUNT(`id`) AS `total` FROM  `%s` WHERE %%d ', $this->dbase->prefix . $this->tablename );
			$prepared = $this->dbase->prepare( $sql, 1 );

			return $this->dbase->get_var( $prepared );
		}

		/**
		 * Sets pagination
		 */
		public function set_pagination() {
			// pagination setup.
			$current = isset( $_REQUEST['current'] ) ? (int) $_REQUEST['current'] : 1 ;
			$limit = $this->config->page_limit;

			$total = $this->get_total();
			$last = ceil( $total / $limit );

			$pagination['last'] = $current == $last ? false : $last ;
			$pagination['first'] = 1 == $current ? false : 1 ;
			$pagination['previous'] = 1 == $current ? false : $current - 1 ;
			$pagination['next'] = $current == $last ? false : $current + 1 ;
			$pagination['start'] = ( $current - 1 ) * $limit;
			$pagination['limit'] = $limit;
			$pagination['current'] = $current;

			// assign pagination.
			$this->pagination = (object) $pagination;
		}

		/**
		 * Insert a row
		 *
		 * @param      mixed $data   The data.
		 *
		 * @return     <type>  ( description_of_the_return_value )
		 */
		public function insert( &$data ) {

			$data['created'] = $this->now();
			return $this->dbase->insert( $this->dbase->prefix . $this->tablename, $data );
		}

		/**
		 * Update a row
		 *
		 * @param      mixed $data   The data.
		 * @param      array $where  The where.
		 *
		 * @return     bool   result of the update query.
		 */
		public function update( &$data, $where = null ) {

			$data['updated'] = $this->now();

			return $this->dbase->update( $this->dbase->prefix . $this->tablename, $data, $where );
		}

		/**
		 * Delete a row
		 *
		 * @param      int $value  Id of the row to delete.
		 *
		 * @return     bool  result of delete query.
		 */
		public function delete( $value ) {
			if ( ! (int) $value ) {
				return false;
			}

			$sql = sprintf( ' DELETE FROM `%s` WHERE `%s` = %%s ', $this->dbase->prefix . $this->tablename, $this->primary_key );
			return $this->dbase->query( $this->dbase->prepare( $sql, $value ) );
		}

		/**
		 * Delete all rows
		 *
		 * @return     bool  result of delete query.
		 */
		public function delete_all() {

			$sql = sprintf( ' DELETE FROM %s WHERE %%s ', $this->dbase->prefix . $this->tablename );
			return $this->dbase->query( $this->dbase->prepare( $sql, 1 ) );
		}

		/**
		 * Retrieve the last ID
		 *
		 * @return     <type>  ( description_of_the_return_value )
		 */
		public function insert_id() {
			return $this->dbase->insert_id;
		}

		/**
		 * Format a date/time string
		 *
		 * @param      timestamp $time   The time.
		 *
		 * @return     datetime
		 */
		public function time_to_date( $time ) {
			return gmdate( 'Y-m-d H:i:s', $time );
		}

		/**
		 * Retrieve a current datetime
		 *
		 * @return     datetime
		 */
		public function now() {
			return $this->time_to_date( time() );
		}

		/**
		 * Get a timestamp from datetime
		 *
		 * @param      string $date   The date.
		 *
		 * @return     timestamp
		 */
		public function date_to_time( $date ) {
			return strtotime( $date . ' GMT' );
		}
	}
}
