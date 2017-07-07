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
        protected $message = "your message here";

        public function __construct( ) {

            $this->queue( );

        }

        public function success( ) {

            $class = "notice notice-success";

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $this->message ) ); 

        }

        public function failure( ) {

            $class = "notice notice-failure";

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $this->message ) ); 

        }

        public function notice( ) {

            $class = "notice notice-info";

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $this->message ) ); 

        }

        public function queue( ) {

            if ( isset( $_REQUEST['pvstatus'] ) ) {

                $this->message = isset( $_REQUEST['pvmessage'] ) ? $_REQUEST['pvmessage'] : '' ;
                switch ( $_REQUEST['pvstatus'] ) {
                    case 'success':
                        add_action( 'admin_notices', $this->success( ), 10, 0 );
                    break;
                    case 'failure':
                        add_action( 'admin_notices', $this->failure( ), 10, 0 );
                    break;
                }

            }

        }

    }

}