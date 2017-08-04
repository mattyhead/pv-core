<?php
/**
 * Shared html helper class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Core
 * @subpackage Pv_Core/helpers
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Helper_Html' ) ) {
	/**
	 * Class for pv core paginator helper.
	 */
class Pv_Core_Helper_Html extends Pv_Core_Helper {

	/**
	 * { function_description }
	 *
	 * @param      string  $text     The text
	 * @param      <type>  $url      The url
	 * @param      array   $options  The options
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	public static function link( $text, $url, $options = array() ) {
		if ( is_array( $url ) ) {
			$url = MvcRouter::public_url( $url );
		}
		$defaults = array(
			'href' => $url,
			'title' => $text,
		);
		$options = array_merge( $defaults, $options );
		$attributes_html = self::attributes_html( $options, 'a' );
		$html = '<a' . $attributes_html . '>' . $text . '</a>';
		return $html;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $object   The object
	 * @param      array   $options  The options
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function object_url( $object, $options = array() ) {
		$defaults = array(
			'id' => $object->__id,
			'action' => 'show',
			'object' => $object,
		);
		$options = array_merge( $defaults, $options );
		$url = MvcRouter::public_url( $options );
		return $url;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $object   The object
	 * @param      array   $options  The options
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function object_link( $object, $options = array() ) {
		$url = self::object_url( $object, $options );
		$text = empty( $options['text'] ) ? $object->__name : $options['text'];
		return self::link( $text, $url, $options );
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $object   The object
	 * @param      array   $options  The options
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function admin_object_url( $object, $options = array() ) {
		$defaults = array(
			'id' => $object->__id,
			'object' => $object,
		);
		$options = array_merge( $defaults, $options );
		$url = MvcRouter::admin_url( $options );
		return $url;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $object   The object
	 * @param      array   $options  The options
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function admin_object_link( $object, $options = array() ) {
		$url = self::admin_object_url( $object, $options );
		$text = empty( $options['text'] ) ? $object->__name : $options['text'];
		return self::link( $text, $url );
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $method  The method
	 * @param      <type>  $args    The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function __call( $method, $args ) {
		if ( property_exists( $this, $method ) ) {
			if ( is_callable( $this->$method ) ) {
				return call_user_func_array( $this->$method, $args );
			}
		}
	}
}
