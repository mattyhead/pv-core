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

        public function success( ) {
            d('in success');
            $class = "notice notice-success";
            $message = __( $this->$message, $plugin_name );

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
        }

        public function failure( ) {
            d('in failure');
            $class = "notice notice-failure";
            $message = __( $this->$message, $plugin_name );

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
        }

        public function notice( ) {
            d('in notice');
            $class = "notice notice-info";
            $message = __( $this->$message, $plugin_name );

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
        }

        public function queue( $message, $type ) {
            d('in queue');
            $this->message = $message;
            switch ( $type ) {
                case 'error':
                break;
                case 'notice':
                break;
                default: // 'success'
                    add_action( 'admin_notices', $this->success(), 10 );
                break;
            }

        }

    }
}