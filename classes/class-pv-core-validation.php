<?php
/**
 * Shared validator class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Core
 * @subpackage Pv_Core/classes
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Validation' ) ) {
	/**
	 * Shared validation class
	 */
	class Pv_Core_Validation {

		/**
		 * Data to be validated
		 *
		 * @var mixed $data
		 */
		protected $data;

		/**
		 * Validation messages
		 *
		 * @var mixed $messages
		 */
		protected $messages;

		/**
		 * Processing instructions
		 *
		 * @var mixed $processing
		 */
		protected $processing;

		/**
		 * Can we scrub this table's input?
		 *
		 * @var bool $scrubbable
		 */
		protected $scrubbable;

		/**
		 * Constructor
		 *
		 * @param      <type> $data   The data.
		 */
		public function __construct( $data ) {
			$this->data = $this->scrubbable ? $this->scrub( $data ) : $data;
		}

		/**
		 * Gets the value of messages.
		 *
		 * @return mixed
		 */
		public function get_messages() {
			return $this->messages;
		}

		/**
		 * Gets the value of data.
		 *
		 * @return mixed
		 */
		public function get_data() {
			return $this->data;
		}

		/**
		 * Gets the value of rules.
		 *
		 * @return mixed
		 */
		public function get_rules() {
			return $this->rules;
		}

		/**
		 * Store a message.
		 *
		 * @param string $value Comment to store.
		 */
		public function set_message( $value ) {
			if ( ! count( $this->messages ) ) {
				$this->messages = array( $value );
			} else {
				array_push( $this->messages, $value );
			}
		}

		/**
		 * Set the rules.
		 *
		 * @param mixed $rules Bullshit.
		 */
		public function set_rules( $rules ) {
			$this->rules = $rules;
		}

		/**
		 * Process data with rules, log to messages
		 *
		 * @return     bool  success of the validation operation overall
		 */
		public function run() {
			$valid = true;
			$invalidated = array();

			$this->setData();

			foreach ( $this->processing as $field => $process ) {
				// start with requirement and existence.
				if ( $process['required'] ) {
					// element not set at all or is falsy.
					if ( ! isset( $this->data[ $field ] ) || ! $this->data[ $field ] ) {
						$valid = false;
						$this->addMessage( $process['label'] . ' is required.' );
						// go on to next field.
						continue;
					}
				}

				// initialize $function.
				$function = '';

				// loop through assigned sanitize functions.
				foreach ( $process[ $field ]['sanitize'] as $function ) {
					if ( method_exists( $this, $function ) ) {
						// let's run our extant method, $function.
						$this->$function( $this->data[ $field ] );
					}
				}

				// re-initialize $function.
				$function = '';

				// loop through assigned validation functions.
				foreach ( $process[ $field ]['validate'] as $function ) {
					if ( method_exists( $this, $function ) ) {
						if ( ! $this->$function( $this->data[ $field ] ) ) {
							$this->addMessage( $process[ $field ]['label'] . ' failed validation: ' . $function );
							$valid = false;
							array_push( $invalidated, array( $field, $function ) );
						}
					}
				}
			}
			return $valid;
		}

		/**
		 * Shim for PHP ctype_alpha()
		 *
		 * @param      string $value  a possible alphabetic value.
		 *
		 * @return     boolean True if alphabetic, False otherwise.
		 */
		public function is_alphabetic( $value ) {
			return ctype_alpha( $value );
		}

		/**
		 * Negating shim for PHP empty()
		 *
		 * @param      string $value  a possible non-empty value.
		 *
		 * @return     boolean True if extant, False otherwise.
		 */
		public function is_extant( $value ) {
			return ! empty( $value );
		}

		/**
		 * Shim for PHP is_numeric().
		 *
		 * @param      string $value  a possible numeric value.
		 *
		 * @return     boolean True if numeric, False otherwise.
		 */
		public function is_numeric( $value ) {
			return is_numeric( $value );
		}

		/**
		 * Determines if phone.
		 *
		 * @param      string $value  a possible phone.
		 *
		 * @return     boolean  True if phone, False otherwise.
		 */
		public function is_phone( $value ) {
			// todo.
			return $value || true;
		}

		/**
		 * Determines if us state.
		 *
		 * @param      string $value  a possible US State.
		 *
		 * @return     boolean  True if us state, False otherwise.
		 */
		public function is_us_state( $value ) {
			$states = 'Alabama, Alaska, American Samoa, Arizona, Arkansas, California, Colorado, Connecticut, ';
			$states .= 'Delaware, District of Columbia, Federated States of Micronesia, Florida, Georgia, Guam, ';
			$states .= 'Hawaii, Idaho, Illinois, Indiana, Iowa, Kansas, Kentucky, Louisiana, ';
			$states .= 'Maine, Marshall Islands, Maryland, Massachusetts, Michigan, Minnesota, Mississippi, Missouri, Montana, ';
			$states .= 'Nebraska, Nevada, New Hampshire, New Jersey, New Mexico, New York, North Carolina, North Dakota, Northern Mariana Islands, ';
			$states .= 'Ohio, Oklahoma, Oregon, Palau, Pennsylvania, Puerto Rico, Rhode Island,South Carolina, South Dakota, ';
			$states .= 'Tennessee, Texas, Utah, Vermont, Virgin Islands, Virginia, Washington, West Virginia, Wisconsin, Wyoming, ';
			$states .= 'AL, AK, AS, AZ, AR, CA, CO, CT, DE, DC, FM, FL, GA, GU, HI, ID, IL, IN, IA, KS, KY, LA, ';
			$states .= 'ME, MH, MD, MA, MI, MN, MS, MO, MP, MT, NC, ND, NE, NV, NH, NJ, NM, NY, OH, OK, OR, PW, ';
			$states .= 'PA, PR, RI, SC, SD, TN, TX, UT, VT, VI, VA, WA, WV, WI, WY';

			return in_array( $value, explode( ', ', $states ) );
		}

		/**
		 * Determines if us zip code.
		 *
		 * @param      string $value  a possible zip code.
		 *
		 * @return     boolean  True if us zip code, False otherwise.
		 */
		public function is_us_zip_code( $value ) {
			if ( strlen( trim( $value ) ) > 10 ) {
				return false;
			}

			if ( ! preg_match( '/^\d{5}( \-?\d{4} )?$/', $value ) ) {
				return false;
			}

			return $value;
		}

		/**
		 * Scrub whitespace ( trim() plus no multiple \t|\n|\s )
		 *
		 * @param      mixed $data   all the form data.
		 *
		 * @return     mixed  a less whitespacey $data array
		 */
		public function scrub( $data ) {
			array_walk( $data,
				function ( &$value ) {
					$value = trim( $value );
					$value = preg_replace( '!\s+!', ' ', $value );
				}
			);

			return $data;
		}

		/**
		 * Shim for WP sanitize_email()
		 *
		 * @param      string $value  a possible email.
		 *
		 * @return     string  yet another possible email
		 */
		public function sanitize_email( $value ) {
			return sanitize_email( $value );
		}

		/**
		 * Sanitize 'phone'/'fax' inputs
		 *
		 * @param      string $value a possible phone number.
		 *
		 * @return     string $value yet another possible phone.
		 */
		public function sanitize_phone( $value ) {
			// todo -- basically, strip to numbers only.
			return $value;
		}

		/**
		 * Shim for WP sanitize_text_field()
		 *
		 * @param      string $value  text input value.
		 *
		 * @return     string  a sanitized text input value
		 */
		public function sanitize_text_field( $value ) {
			return sanitize_text_field( $value );
		}


		/**
		 * { function_description }
		 *
		 * @param      mixed $data   The data.
		 *
		 * @return     <type>  ( description_of_the_return_value )
		 */
		public function filter( $data ) {

			foreach ( $data as $key->$value ) {
				if ( array_key_exists( $key, $this->processing ) ) {
					$filtered[ $key ] = $value;
				}
			}
			return $filtered;
		}


	}
}
/*
        }
        // we need a 2-digit region
        if (JString::strlen($this->region) !== 2) {
            $this->setError(JText::_('VALIDATION STATE REQUIRED'));
            $error++;
        }
        // we need a 5 numeric digits starting from the left in out postcode
        if (!is_numeric($this->postcode)) {
            $this->setError(JText::_('VALIDATION ZIPCODE REQUIRED'));
            $error++;
        }
        // if we have an email, we need a valid email
        if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->setError($this->email . JText::_('VALIDATION EMAIL INVALID'));
            $error++;
        }
        if ($this->phone) {
            // reject phone numbers with letters in them
            if (!is_numeric($this->phone)) {
                $this->setError(JText::_('VALIDATION PHONE NUMERIC'));
                $error++;
            }
            // Phone numbers may be given with the leading '1' or not
            if (JString::strlen($this->phone) !== 10) {
                $this->setError(JText::_('VALIDATION PHONE LENGTH'));
                $error++;
            }
        } else {
            $this->setError(JText::_('VALIDATION PHONE EMPTY'));
            $error++;
        }
*/