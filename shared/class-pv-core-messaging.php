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

    class Pv_Core_Messaging {

        protected $plugin_name;
        protected $message;

        public function __construct( ) {

            $this->queue( );

        }

        public function success( ) {

            $class = "notice notice-success";
            $message = "Success :)";//__( $this->message, $this->plugin_name );

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 

        }

        public function failure( ) {

            $class = "notice notice-failure";
            $message = "Failure :(";//__( $this->message, $plugin_name );

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 

        }

        public function notice( ) {

            $class = "notice notice-info";
            $message = $this->message;//__( $this->message, $plugin_name );

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 

        }

        public function queue( ) {

            if ( isset( $_REQUEST['message'] ) ) {

                switch ( $_REQUEST['message'] ) {
                    case 'success':
                        add_action( 'admin_notices', $this->success(), 10, 0 );
                    break;
                    case 'failure':
                        add_action( 'admin_notices', $this->failure(), 10, 0 );
                    break;
                }

            }

        }

    }

}