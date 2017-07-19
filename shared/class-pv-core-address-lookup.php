<?php
/**
 * Shared validator class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Core
 * @subpackage Pv_Core/shared
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Address_Lookup' ) ) {

	/**
	 * Shared simple division lookup class
	 */
	class Pv_Core_Address_Lookup {

		/**
		 * Local copy of the data.
		 *
		 * @var mixed $data
		 **/
		public $data;

		/**
		 * Local copy of the data.
		 *
		 * @var string $key
		 **/
		public $key = 'f2e3e82987f8a1ef78ca9d9d3cfc7f1d';

		/**
		 * Which feature.
		 *
		 * @var int $index
		 **/
		public $index;

		/**
		 * Return from $service_url
		 *
		 * @var mixed $results
		 */
		public $results;

		/**
		 * Url for looking up Divisions
		 *
		 * @var string $service_url
		 */
		public $service_url = 'https://api.phila.gov/ais/v1/search/%s?gatekeeperKey=%s';

		/**
		 * Setup.
		 *
		 * @param      mixed $data   The data.
		 */
		public function set_data( $data ) {
			$this->data = &$data;
			$this->process_address();
		}

		/**
		 * Gets the coordinates.
		 *
		 * @return     mixed $this->results The division.
		 */
		public function get_coords() {
			return array(
				'lng' => $this->results->features[ $this->index ]->geometry->coordinates[0],
				'lat' => $this->results->features[ $this->index ]->geometry->coordinates[1],
			);
		}

		/**
		 * Gets the division.
		 *
		 * @return     mixed $this->results The division.
		 */
		public function get_division() {
			return $this->results->features[ $this->index ]->properties->election_precinct;
		}

		/**
		 * Gets the whole ($index) record.
		 *
		 * @return     mixed $this->results The division.
		 */
		public function get_all() {
			return $this->results->features[ $this->index ];
		}

		/**
		 * Gets the division.
		 *
		 * @return     mixed $this->results The division.
		 */
		public function is_success() {
			if ( isset( $this->results->status ) ) {
				return false;
			}

			if ( ! count( $this->results->features ) ) {
				return false;
			}

			return true;
		}

		/**
		 * Does the actual work.
		 */
		public function process_address() {
			$payload = wp_remote_get(
				sprintf(
					$this->service_url,
					rawurlencode( $this->data['address1'] ),
					$this->key
				)
			);

			if ( isset( $payload['response'] ) && 200 == $payload['response']['code'] ) {
				$this->results = json_decode( $payload['body'] );
			}

			$this->index = 0;
			if ( isset( $this->results->features[1] ) && 'exact' === $this->results->features[1]->match_type ) {
				$this->index = 1;
			}

		}

		/**
		 * Sets the key.
		 *
		 * @param      string $value  The key.
		 */
		public function set_key( $value ) {
			$this->key = $value;
		}
	}
}
