<?php
/**
 * Shared helper class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Core
 * @subpackage Pv_Core/helpers
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Helper' ) ) {
	/**
	 * Class for pv core helper.
	 */
	class Pv_Core_Helper {

		protected $file_includer ;

		/**
		 * { function_description }
		 */
		public function __construct() {
			$this->file_includer = new MvcFileIncluder();
			$this->init();
		}

		/**
		 * { function_description }
		 */
		public function init() {
		}

		/**
		 * { function_description }
		 *
		 * @param      string  $path       The path
		 * @param      array   $view_vars  The view variables
		 */
		public function render_view( $path, $view_vars = array() ) {
			extract( $view_vars );
			$filepath = $this->file_includer->find_first_app_file_or_core_file( 'views/' . $path . '.php' );
			if ( ! $filepath ) {
				$path = preg_replace( '/admin\/(?!layouts)([\w_]+)/', 'admin', $path );
				$filepath = $this->file_includer->find_first_app_file_or_core_file( 'views/' . $path . '.php' );
				if ( ! $filepath ) {
					MvcError::warning( 'View "' . $path . '" not found.' );
				}
			}
			require $filepath;
		}

		/**
		 * { function_description }
		 *
		 * @param      <type>  $string  The string
		 *
		 * @return     <type>  ( description_of_the_return_value )
		 */
		public static function esc_attr( $string ) {
			return esc_attr( $string );
		}

		/**
		 * { function_description }
		 *
		 * @param      <type>  $attributes                     The attributes
		 * @param      <type>  $valid_attributes_array_or_tag  The valid attributes array or tag
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		public static function attributes_html( $attributes, $valid_attributes_array_or_tag ) {
			$event_attributes = array(
				'standard' => array(
					'onclick', 'ondblclick', 'onkeydown', 'onkeypress', 'onkeyup', 'onmousedown',
					'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup',
				),
				'form' => array(
					'onblur', 'onchange', 'onfocus', 'onreset', 'onselect', 'onsubmit',
				),
			);

			// To do: add on* event attributes.
			$valid_attributes_by_tag = array(
				'a' => array(
					'accesskey', 'charset', 'class', 'dir', 'coords', 'href', 'hreflang',
					'id', 'lang', 'name', 'rel', 'rev', 'shape', 'style', 'tabindex',
					'target', 'title', 'xml:lang',
				),
				'input' => array(
					'accept', 'access_key', 'align', 'alt', 'autocomplete', 'checked',
					'class', 'dir', 'disabled', 'id', 'lang', 'maxlength', 'name',
					'placeholder', 'readonly', 'required', 'size', 'src', 'style',
					'tabindex', 'title', 'type', 'value', 'xml:lang', $event_attributes['form'],
				),
				'textarea' => array(
					'access_key', 'class', 'cols', 'dir', 'disabled', 'id', 'lang', 'maxlength',
					'name', 'readonly', 'required', 'rows', 'style', 'tabindex', 'title',
					'xml:lang', $event_attributes['form'],
				),
				'select' => array(
					'class', 'dir', 'disabled', 'id', 'lang', 'multiple', 'name', 'required',
					'size', 'style', 'tabindex', 'title', 'xml:lang', $event_attributes['form'],
				),
			);

			foreach ( $valid_attributes_by_tag as $key => $valid_attributes ) {
				$valid_attributes = array_merge( $event_attributes['standard'], $valid_attributes );
				$valid_attributes = self::array_flatten( $valid_attributes );
				$valid_attributes_by_tag[ $key ] = $valid_attributes;
			}

				$valid_attributes = is_array( $valid_attributes_array_or_tag ) ? $valid_attributes_array_or_tag : $valid_attributes_by_tag[ $valid_attributes_array_or_tag ];

				$attributes = array_intersect_key( $attributes, array_flip( $valid_attributes ) );

				$attributes_html = '';
			foreach ( $attributes as $key => $value ) {
				$attributes_html .= ' ' . $key . '="' . esc_attr( $value ) . '"';
			}
				return $attributes_html;
		}

		/**
		 * { function_description }
		 *
		 * @param      <type>  $controller  The controller
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		public function admin_header_cells( $controller ) {
			$html = '';
			foreach ( $controller->default_columns as $key => $column ) {
				$html .= $this->admin_header_cell( $column['label'] );
			}
			$html .= $this->admin_header_cell( '' );
			return '<tr>' . $html . '</tr>';
		}

		/**
		 * { function_description }
		 *
		 * @param      string  $label  The label
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		public function admin_header_cell( $label ) {
			return '<th scope="col" class="manage-column">' . $label . '</th>';
		}

		/**
		 * { function_description }
		 *
		 * @param      <type>  $controller  The controller
		 * @param      <type>  $objects     The objects
		 * @param      array   $options     The options
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		public function admin_table_cells( $controller, $objects, $options = array() ) {
			$html = '';
			foreach ( $objects as $object ) {
				$html .= '<tr>';
				foreach ( $controller->default_columns as $key => $column ) {
					$html .= $this->admin_table_cell( $controller, $object, $column, $options );
				}
				$html .= $this->admin_actions_cell( $controller, $object, $options );
				$html .= '</tr>';
			}
			return $html;
		}

		/**
		 * { function_description }
		 *
		 * @param      <type>  $controller  The controller
		 * @param      <type>  $object      The object
		 * @param      <type>  $column      The column
		 * @param      array   $options     The options
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		public function admin_table_cell( $controller, $object, $column, $options = array() ) {
			if ( ! empty( $column['value_method'] ) ) {
				$value = $controller->{$column['value_method']}($object);
			} else {
				$value = $object->{$column['key']};
			}
			return '<td>' . $value . '</td>';
		}

		/**
		 * { function_description }
		 *
		 * @param      <type>  $controller  The controller
		 * @param      <type>  $object      The object
		 * @param      array   $options     The options
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		public function admin_actions_cell( $controller, $object, $options = array() ) {
			$default = array(
				'actions' => array(
					'edit' => true,
					'view' => true,
					'delete' => true,
				),
			);

				$options = array_merge( $default, $options );

				$links = array();
			$object_name = empty( $object->__name ) ? 'Item #' . $object->__id : $object->__name;
			$encoded_object_name = $this->esc_attr( $object_name );

			if ( $options['actions']['edit'] ) {
				$links[] = '<a href="' . MvcRouter::admin_url(
					array(
						'object' => $object,
						'action' => 'edit',
					)
				) . '" title="Edit ' . $encoded_object_name . '">Edit</a>';
			}

			if ( $options['actions']['view'] ) {
				$links[] = '<a href="' . MvcRouter::public_url(
					array(
						'object' => $object,
					)
				) . '" title="View ' . $encoded_object_name . '">View</a>';
			}

			if ( $options['actions']['delete'] ) {
				$links[] = '<a href="' . MvcRouter::admin_url(
					array(
						'object' => $object,
						'action' => 'delete',
					)
				) . '" title="Delete ' . $encoded_object_name . '" onclick="return confirm(&#039;Are you sure you want to delete ' . $encoded_object_name . '?&#039;);">Delete</a>';
			}

				$html = implode( ' | ', $links );
				return '<td>' . $html . '</td>';
		}

		/**
		 * { function_description }
		 *
		 * @param      array   $array  The array
		 *
		 * @return     <type>  ( description_of_the_return_value )
		 */
		public static function array_flatten( $array ) {
			foreach ( $array as $key => $value ) {
				$array[ $key ] = (array) $value;
			}

				return call_user_func_array( 'array_merge', $array );
		}

	}

}
