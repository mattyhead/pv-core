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
class Pv_Core_Static_Messaging {

    public function success( $array ) {
        $class = "notice notice-success";
        $message = __( $array['message'], $array['plugin_name'] );

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
    }

    public function failure( $array ) {
        $class = "notice notice-failure";
        $message = __( $array['message'], $array['plugin_name'] );

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
    }

    public function notice( $array ) {
        $class = "notice notice-info";
        $message = __( $array['message'], $array['plugin_name'] );

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
    }

}