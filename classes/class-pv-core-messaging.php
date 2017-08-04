<?php
/**
 * Shared root Model
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Core
 * @subpackage Pv_Core/classes
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Messaging' ) ) {

	/**
	 * Shared automated messaging object
	 */
	class Pv_Core_Messaging {

		/**
		 * Message to schedule
		 *
		 * @var        string
		 */
		protected $message = '';

		/**
		 * Format of messages
		 *
		 * @var        string
		 */
		protected $format = '<div class="%1$s"><p>%2$s</p></div>';

		/**
		 * Construct auto-runs queue()
		 */
		public function __construct() {

			$this->queue();

		}

		/**
		 * Write out an error message
		 */
		public function error() {

			$class = 'notice notice-error is-dismissible';

			printf( $this->format, esc_attr( $class ), esc_html( $this->message ) );

		}

		/**
		 * Write out an info message
		 */
		public function info() {

			$class = 'notice notice-info is-dismissible';

			printf( $this->format, esc_attr( $class ), esc_html( $this->message ) );

		}

		/**
		 * Write out a success message
		 */
		public function success() {

			$class = 'notice notice-success is-dismissible';

			printf( $this->format, esc_attr( $class ), esc_html( $this->message ) );

		}

		/**
		 * Write out a warning message
		 */
		public function warning() {

			$class = 'notice notice-warning is-dismissible';

			printf( $this->format, esc_attr( $class ), esc_html( $this->message ) );

		}

		/**
		 * Queue a 'pvmessage' based on param 'pvstatus'
		 */
		public function queue() {

			if ( isset( $_REQUEST['pvstatus'] ) ) {

				$this->message = isset( $_REQUEST['pvmessage'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['pvmessage'] ) ) : '' ;
				switch ( $_REQUEST['pvstatus'] ) {
					case 'error':
						add_action( 'admin_notices', array( $this, 'error' ), 10, 0 );
						break;
					case 'info':
						add_action( 'admin_notices', array( $this, 'info' ), 10, 0 );
						break;
					case 'success':
						add_action( 'admin_notices', array( $this, 'success' ), 10, 0 );
						break;
					case 'warning':
						add_action( 'admin_notices', array( $this, 'warning' ), 10, 0 );
						break;
				}
			}

		}

	}

}
