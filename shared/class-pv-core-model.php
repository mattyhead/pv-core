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
        protected $db;

        /**
         * The pagination array
         *
         * @since    1.0.0
         * @access   public
         * @var      mixed     start / stop
         */
        protected $pagination;

        public function __construct( ) {
            global $wpdb;

            $this->db = &$wpdb;

            $this->pagination = ( object ) array( 
                'start' => ( isset( $_REQUEST['start'] ) ? ( int ) $_REQUEST['start'] : 0 ),
                'range' => ( isset( $_REQUEST['range'] ) ? ( int ) $_REQUEST['range'] : 20 ),
                'total' => '',
            );
        }

        /**
         * return a wp-prefixed table name
         *
         * @return     string  table name
         */
        private function _table( ) {
            return $this->db->prefix . $this->tablename;
        }

        /**
         * Fetches a sql fpr a single row.
         *
         * @param      int  $value  (an ID)
         *
         * @return     string  WP perpared sql
         */
        private function _fetch_row_sql( $value ) {
            if ( !( int ) $value ) {
                return false;
            }
            $sql = sprintf( ' SELECT * FROM `%s` WHERE `%s` = %%s ', $this->_table( ), $this->primary_key );
            return $this->db->prepare( $sql, ( int ) $value );
        }

        /**
         * Fetches sql for a full table dump
         *
         * @return     string    WP prepared sql
         */
        private function _fetch_all_sql( ) {
            $sql = sprintf( ' SELECT * FROM `%s` ', $this->_table( ) );
            return $this->db->prepare( $sql );
        }

        /**
         * fetches sql for pagination
         *
         * @return     string    WP prepared sql
         */
        private function _fetch_paged_sql( ) {
            $sql = sprintf( ' SELECT * FROM `%s` LIMIT %%d, %%d ', $this->_table( ) );
            return $this->db->prepare( $sql, $this->pagination->start, $this->pagination->range );
        }

        /**
         * Gets a row.
         *
         * @param      int    $value   (an ID)
         *
         * @return     mixed    result row
         */
        public function get_row( $value ) {
            return $this->db->get_row( $this->_fetch_row_sql( $value ) );
        }

        /**
         * Gets all rows.
         *
         * @return     mixed   all rows
         */
        public function get_all( ) {
            return $this->db->get_results( $this->_fetch_all_sql( ) );
        }

        /**
         * Gets paged results
         *
         * @return     mixed    paged result rows
         */
        public function get_paged( ) {
            return $this->db->get_results( $this->_fetch_paged_sql( ) );
        }

        /**
         * Gets paged results
         *
         * @return     mixed    paged result rows
         */
        public function get_pagination( ) {
            return $this->pagination;
        }

        /**
         * Gets the tablename w/o WP prefix
         *
         * @return     string  The tablename.
         */
        public function get_tablename( ) {
            return $this->tablename;
        }

        /**
         * Insert a row
         *
         * @param      mixed  $data   The data
         */
        public function insert( $data ) {
            $this->db->insert( $this->_table( ), $data );
        }

        /**
         * update a row
         *
         * @param      mixed  $data   The data
         */
        public function update( $data, $where = null ) {
            if ( !isset( $where ) ) {
                // it's item on the outsied, data on the inside
                $where = array( 'id'=>( int )$data['item'] );
            }
            unset($data['item'], $data['action'], $data['submit']);
            $data['updated'] = $this->now();
            $this->db->update( $this->_table( ), $data, $where );
        }

        /**
         * Delete a row
         *
         * @param      int  $value  The value
         *
         * @return     bool  result of delete query
         */
        public function delete( $value ) {
            $sql = sprintf( ' DELETE FROM `%s` WHERE `%s` = %%s ', $this->_table( ), $this->primary_key );
            return $this->db->query( $this->db->prepare( $sql, $value ) );
        }

        /**
         * Retrieve the last ID
         *
         * @return     <type>  ( description_of_the_return_value )
         */
        public function insert_id( ) {
            return $this->db->insert_id;
        }

        /**
         * Format a date/time string
         *
         * @param      timestamp  $time   The time
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
        public function now( ) {
            return $this->time_to_date( time( ) );
        }

        /**
         * Get a timestamp from datetime
         *
         * @param      string  $date   The date
         *
         * @return     timestamp
         */
        public function date_to_time( $date ) {
            return strtotime( $date . ' GMT' );
        }

    }
}