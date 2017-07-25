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

/*
 * EXAMPLE:
 *
 * - Include the library file
 * include ("htmlselectlist.class.php");
 *
 * - Create the object and supply the name of the SELECT, the size, and
 * - any additional tag information (like style information)
 * $list = new HTMLSelectList('myList2', 0, 'style="font-size:24px"');
 *
 * - Add list items
 * $list->add_item('Red', 'Color1');
 * $list->add_item('Blue', 'Color2', true);    // This will be the selected item
 * $list->add_item('Yellow', 'Color3');
 * $list->add_item('Green', 'Color4');
 *
 * - Show the SELECT
 * echo $list->getHTML();
 *
 * echo "\n<br /><br />\n";
 *
 * - Remove the style information and change the size.
 * $list->optional_attrs = '';
 * $list->select_size = 4;
 * $list->select_item_by_display('Yellow');
 * $list->select_item_by_value('Color3'); // You can also select by value.
 *
 * - Show another SELECT
 * echo $list->getHTML();
 */

if ( ! class_exists( 'Pv_Core_Helper_Select' ) ) {
	/**
	 * HTMLSelectList Class for PHP5
	 * creates SELECT dropdown tag HTML
	 *
	 * @version 1.1
	 * @author Jeff L. Williams - later mangled by Matthew Murphy
	 */
	class Pv_Core_Helper_Select {

		/**
		 * Combo data
		 *
		 * @var mixed $combo_data
		 */
		public  $combo_data;

		/**
		 * Item information
		 *
		 * @var array $item_array
		 */
		private $item_array;

		/**
		 * Number of items
		 *
		 * @var int $item_count
		 */
		private $item_count;

		/**
		 * Additional tag information
		 *
		 * @var string $optional_attrs
		 */
		public  $optional_attrs;

		/**
		 * Name of select
		 *
		 * @var string $select_name
		 */
		public  $select_name;

		/**
		 * Size of select
		 *
		 * @var int $select_size
		 */
		public  $select_size;

		/**
		 * Index of default item
		 *
		 * @var int $selected_index
		 */
		public  $selected_index;

		/**
		 * Constructor: Sets parameters for the class on create
		 *
		 * @param String  $select_name the name of the select.
		 * @param String  $selected 'display' of the selected option.
		 * @param Integer $select_size the numbers of rows for the select.
		 * @param String  $optional_attrs additional tag information.
		 */
		public function setup( $select_name, $selected, $select_size = 0, $optional_attrs = '' ) {
			$this->selected = $selected;
			$this->select_name = $select_name;
			$this->select_size = $select_size;
			$this->optional_attrs = $optional_attrs;
			$this->item_count = 0;
		}

		/**
		 * Adds an item and its value to the list
		 *
		 * @param String  $item_display the text to display in an item.
		 * @param String  $item_value the value to send on form submit.
		 * @param Boolean $selected true if this item is the default.
		 * @return Integer the item index.
		 */
		public function add_item( $item_display, $item_value, $selected = false ) {
			$this->item_array[ $this->item_count ][0] = $item_display;
			$this->item_array[ $this->item_count ][1] = $item_value;

			if ( $selected ) {
				$this->selected_index = $this->item_count;
			}

			$this->item_count++;
			return $this->item_count;
		}

		/**
		 * Adds an item and its value to the list
		 *
		 * @param  String $items_array the text to display in an item.
		 */
		public function add_items( $items_array ) {
			dd($this->selected, $items_array);
			foreach ( $items_array as $item ) {
				$this->add_item( $item->value, $item->idx, ( $this->selected == $item->idx ? true : false ) );
			}
		}

		/**
		 * Returns the count of list items
		 *
		 * @return Integer
		 */
		public function item_count() {
			return $this->item_count;
		}

		/**
		 * Selects an item in the list based on the value
		 * and makes it the default selected item
		 *
		 * @param String  $value The value.
		 * @param Boolean $ignore_case (optional).
		 */
		public function select_item_by_value( $value, $ignore_case = false ) {
			if ( $ignore_case ) {
				for ( $i = 0; $i < $this->item_count; $i++ ) {
					if ( $this->item_array[ $i ][1] == $value ) {
						$this->selected_index = $i;
						break;
					}
				}
			} else {
				for ( $i = 0; $i < $this->item_count; $i++ ) {
					if ( strtoupper( $this->item_array[ $i ][1] ) == strtoupper( $value ) ) {
						$this->selected_index = $i;
						break;
					}
				}
			}
		}

		/**
		 * Selects an item in the list based on the display
		 * and makes it the default selected item
		 *
		 * @param String  $display  value.
		 * @param Boolean $ignore_case (optional).
		 */
		public function select_item_by_display( $display, $ignore_case = false ) {
			if ( $ignore_case ) {
				for ( $i = 0; $i < $this->item_count; $i++ ) {
					if ( $this->item_array[ $i ][0] == $display ) {
						$this->selected_index = $i;
						break;
					}
				}
			} else {
				for ( $i = 0; $i < $this->item_count; $i++ ) {
					if ( strtoupper( $this->item_array[ $i ][0] ) == strtoupper( $display ) ) {
						$this->selected_index = $i;
						break;
					}
				}
			}
		}

		/**
		 * Returns HTML code for a SELECT list control
		 *
		 * @return String
		 */
		public function get_html() {

			// Create the opening tag.
			$html = '<select name="' . $this->select_name . '"';

			if ( $this->select_size > 0 ) {
				$html .= ' size="' . $this->select_size . '"';
			}

			if ( strlen( $this->optional_attrs ) > 0 ) {
				$html .= ' ' . $this->optional_attrs;
			}

			$html .= '>';

			// create the list tags.
			$index = 0;
			while ( $index < $this->item_count ) {

				$html .= "\n\t" . '<option value="' . $this->item_array[ $index ][1];

				if ( $index == $this->selected_index ) {
					$html .= '" selected="selected">';
				} else {
					$html .= '">';
				}

				$html .= htmlspecialchars( $this->item_array[ $index ][0] ) . '</option>';
				$index++;
			}

			// create the closing tag.
			$html .= "\n" . '</select>';

			return $html;
		}

		/**
		 * Gets the combo data.
		 *
		 * @param      String $prop_name  The property name.
		 */
		public function get_combo_data( $prop_name ) {
			require_once WP_PLUGIN_DIR . '/pv-core/classes/class-pv-core-combo-data.php';

			$this->add_items( Pv_Core_Combo_Data::gets( $prop_name ) );
		}
	}
}
