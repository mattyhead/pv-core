<?php
/**
 * Shared root Model
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Elections_Core
 * @subpackage Pv_Elections_Core/db
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Messaging' ) ) {
	/**
	 * Parent model
	 */
	class Pv_Core_Model {

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
		 */
		public function __construct() {
			global $wpdb;

			$this->dbase = &$wpdb;

			$this->pagination = ( object ) array(
				'start' => ( isset( $_REQUEST['start'] ) ? ( int ) $_REQUEST['start'] : 0 ),
				'range' => ( isset( $_REQUEST['range'] ) ? ( int ) $_REQUEST['range'] : 20 ),
				'total' => '',
			);
		}

		/**
		 * Gets a row.
		 *
		 * @param      int $value   (an ID).
		 *
		 * @return     mixed    result row
		 */
		public function get_row( $value ) {
			if ( ! ( int ) $value ) {
				return false;
			}
			$sql = sprintf( ' SELECT * FROM `%s` WHERE `%s` = %%s ', $this->dbase->prefix . $this->tablename, $this->primary_key );
			$prepared_sql = $this->dbase->prepare( $sql, ( int ) $value );
			return $this->dbase->get_row( $prepared_sql );
		}

		/**
		 * Gets all rows.
		 *
		 * @return     mixed   all rows
		 */
		public function get_all() {
			$sql = sprintf( ' SELECT * FROM `%s` ', $this->dbase->prefix . $this->tablename );
			$prepared_sql = $this->dbase->prepare( $sql );

			return $this->dbase->get_results( $prepared_sql );
		}

		/**
		 * Gets paged results
		 *
		 * @return     mixed    paged result rows
		 */
		public function get_paged() {
			$sql = sprintf( ' SELECT * FROM `%s` LIMIT %%d, %%d ', $this->dbase->prefix . $this->tablename );
			$prepare_sql = $this->dbase->prepare( $sql, $this->pagination->start, $this->pagination->range );

			return $this->dbase->get_results( $prepare_sql );
		}

		/**
		 * Gets paged results
		 *
		 * @return     mixed    paged result rows
		 */
		public function get_pagination() {
			return $this->pagination;
		}

		/**
		 * Insert a row
		 *
		 * @param      mixed $data   The data.
		 */
		public function insert( $data ) {
			unset( $data['action'] );
			dd( $this->dbase->insert( $this->dbase->prefix . $this->tablename, $data ) );
		}

		/**
		 * Update a row
		 *
		 * @param      mixed $data   The data.
		 * @param      array $where  The where.
		 *
		 * @return     <type>  ( description_of_the_return_value )
		 */
		public function update( $data, $where = null ) {
			if ( ! isset( $where ) ) {
				// it's item on the outsied, data on the inside.
				$where = array( 'id' => ( int ) $data['item'] );
			}
			unset( $data['item'], $data['action'], $data['submit'] );
			$data['updated'] = $this->now();
			return $this->dbase->update( $this->dbase->prefix . $this->tablename, $data, $where );
		}

		/**
		 * Delete a row
		 *
		 * @param      int $value  The value.
		 *
		 * @return     bool  result of delete query
		 */
		public function delete( $value ) {
			if ( ! ( int ) $value ) {
				return false;
			}

			$sql = sprintf( ' DELETE FROM `%s` WHERE `%s` = %%s ', $this->dbase->prefix . $this->tablename, $this->primary_key );
			return $this->dbase->query( $this->dbase->prepare( $sql, $value ) );
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
