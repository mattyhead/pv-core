<?php
/**
 * Shared combo data class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Core
 * @subpackage Pv_Core/includes
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Combo_Data' ) ) {

	/**
	 * Pv_Core_Combo_Data provides some static arrays useful in rendering UI combo boxes
	 * and standardizing some elements of form data
	 */
	class Pv_Core_Combo_Data {
		/**
		 * LinkTypes indexed by an arbitrary index.
		 *
		 * @var array
		 */
		public static $phone_type_long = array(
			'2' => 'home',
			'3' => 'cell',
			'4' => 'fax',
			'5' => 'pager',
		);

		/**
		 * Phone functions by an arbitrary index.
		 *
		 * @var array
		 */
		public static $phone_type_short = array(
			'1' => 'home',
			'2' => 'cell',
		);

		/**
		 * Prefixes by an arbitrary index ( with null element ).
		 *
		 * @var array
		 */
		public static $prefix = array(
			'1' => '',
			'2' => 'Mr',
			'3' => 'Mrs',
			'4' => 'Ms',
			'5' => 'Miss',
			'6' => 'Mx',
			'7' => 'Dr',
		);

		/**
		 * Genders ( dupes OK ) indexed by conclusive prefix.
		 *
		 * @var array
		 */
		public static $prefix_gender = array(
			'Mr'   => 'M',
			'Ms'   => 'F',
			'Miss' => 'F',
			'Mrs'  => 'F',
			'Mx'   => 'N',
		);

		/**
		 * Marital statuses indexed by conclusive prefix.
		 *
		 * @var array
		 */
		public static $prefix_marital = array(
			'Miss' => 'S',
			'Mrs'  => 'M',
		);

		/**
		 * States indexed by abbreviations.
		 *
		 * @var array
		 */
		public static $state = array(
			'AL' => 'Alabama',
			'AK' => 'Alaska',
			'AS' => 'American',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DE' => 'Delaware',
			'DC' => 'Dist. of Columbia',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'GU' => 'Guam',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MH' => 'Marshall',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'FM' => 'Micronesia',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NE' => 'Nebraska',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'MP' => 'Northern',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PW' => 'Palau',
			'PA' => 'Pennsylvania',
			'PR' => 'Puerto Rico',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VT' => 'Vermont',
			'VA' => 'Virginia',
			'VI' => 'Virgin Islands',
			'WA' => 'Washington',
			'WV' => 'West Virginia',
			'WI' => 'Wisconsin',
			'WY' => 'Wyoming',
		);

		/**
		 * Suffixes by an arbitrary index.
		 *
		 * @var array
		 */
		public static $suffix = array(
			'1' => '',
			'2' => 'Jr',
			'3' => 'Sr',
			'4' => 'II',
			'5' => 'III',
			'6' => 'Esq',
		);

		/**
		 * Forms property ( an indexed array ) into something
		 * joomla.html.select.genericlist can use.
		 *
		 * @param      array $array    Static property array.
		 *
		 * @return     array  usable by joomla.html.select.genericlist
		 */
		public static function set_combo_data( $array ) {
			foreach ( $array as $idx => $value ) {
				$return[] = (object) array(
					'idx' => $idx,
					'value' => $value,
				);
			}

			return $return;
		}

		/**
		 * Agnostic call to get combo-friendly data.
		 *
		 * @param string $prop_name name of property.
		 *
		 * @return method returns conbo-friendly data
		 */
		public static function gets( $prop_name ) {
			return self::set_combo_data( self::$$prop_name );
		}

		/**
		 * Agnostic call to get a specific property element.
		 *
		 * @param string $prop_name propery name.
		 * @param string $idx      index to call.
		 *
		 * @return string desired element of called property
		 */
		public static function get( $prop_name, $idx = null ) {
			if ( $idx ) {
				return isset( self::${$prop_name} ) && isset( self::${$prop_name}[ $idx ] ) ? self::${$prop_name}[ $idx ] : null;
			}

			return self::$$prop_name;
		}

		/**
		 * Lookup key from value, again agnostically.
		 *
		 * @param string $prop_name property name.
		 * @param string $value    value on the property.
		 *
		 * @return string desired element key from specified property
		 */
		public static function key_search( $prop_name, $value = null ) {
			if ( $value ) {
				return isset( self::${$prop_name} ) ? array_search( $value, self::${$prop_name} ) : null;
			}

			return;
		}

		/**
		 * Take an object and indecis and return a combo-ready array.
		 *
		 * @param mixed  $object  data source.
		 * @param string $key     key index.
		 * @param string $value   value index.
		 * @param string $first   optional first element.
		 *
		 * @return mixed combo-ready array
		 */
		public static function gets_from_object( $object, $key, $value, $first = false ) {
			$tmp = array();
			if ( $first ) {
				$tmp[] = $first;
			}
			foreach ( $object as $item ) {
				$tmp[ $item->$key ] = (string) $item->$value;
			}

			return self::set_combo_data( $tmp );
		}
	}
}
