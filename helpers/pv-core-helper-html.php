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
	 * Class for pv core helper html.
	 */
	class Pv_Core_Helper_Html {

		/**
		 * Cued nodes
		 *
		 * @var array $nodes
		 */
		private $nodes = array();

		/**
		 * Self-closing elements
		 *
		 * @var array $self_closers
		 */
		private $self_closers = array( 'area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr' );

		/**
		 * No-attribute
		 *
		 * @var array $no_attribute
		 */
		private $no_attribute = array( 'tag', 'children', 'text', 'random_id', 'parent_id', 'no_attribute', 'options', 'input_type' );

		/**
		 * No-tabulate
		 *
		 * @var array $no_tabulate
		 */
		private $no_tablulate = array( 'option', 'button', 'label', 'textarea' );

		/**
		 * Add nodes to html context.
		 *
		 * @param array $arr_prop Properties.
		 *
		 * @return integer id
		 */
		public function add( $arr_prop = array() ) {

			if ( ! count( $arr_prop ) ) {
				return false;
			}

			if ( ! isset( $arr_prop['id'] ) ) {
				$arr_prop['id'] = self::get_random_id();
				$arr_prop['random_id'] = true;
			}

			// adds children to parent node, from id of parent node.
			if ( isset( $arr_prop['parent_id'] ) ) {
				$this->nodes = $this->build_tree( $arr_prop );
			} else {
				if ( ! ( isset( $arr_prop['children'] ) ) ) {
					$arr_prop['children'] = array();
				}
				array_push( $this->nodes, $arr_prop );
			}

			return $arr_prop['id'];
		}


		/**
		 * Generates the html and returns a string with all the content previously built.
		 *
		 * @return string html
		 */
		public function get_html() {

			$arr_prop = func_get_args();

			$arr_tree = isset( $arr_prop[0] ) ? $arr_prop[0] : $this->nodes;
			$tree_level = isset( $arr_prop[1] ) ? $arr_prop[1] : 0;

			$html_return = '';

			foreach ( $arr_tree as $node ) {

				$html_return .= "\n" . str_repeat( "\t", $tree_level );

				if ( isset( $node['tag'] ) ) {
					$html_return .= '<' . $node['tag'] . ' ';
				}
				foreach ( $node as $attribute => $val ) {

					$no_attributes = $this->no_attribute;

					if ( isset( $node['no_attribute'] ) ) {
						$no_attributes = array_merge( $no_attributes, $node['no_attribute'] );
					}

					if ( ! in_array( $attribute, $no_attributes ) ) {
						if ( 'id' != $attribute || ( 'id' == $attribute && ! isset( $node['random_id'] ) ) ) {
							$html_return .= $attribute . '= "';
							if ( ! is_array( $val ) ) {
								$html_return .= $val . '" ';
							} elseif ( is_array( $val ) ) {
								foreach ( $val as $attr ) {
									$html_return .= $attr . ' ';
								}
								$html_return .= '"';
							}
						}
					}
				}

				if ( isset( $node['tag'] ) && ! in_array( $node['tag'], $this->self_closers ) ) {
					$html_return .= '>';
				}

				if ( isset( $node['text'] ) ) {
					$html_return .= $node['text'];
				}

				if ( isset( $node['children'] ) && $node['children'] ) {
					$html_return .= str_repeat( "\t", $tree_level );
					$html_return .= $this->get_html( $node['children'], ( $tree_level + 1 ) );
				}

				$no_tablulates = $this->no_tablulate;

				if ( isset( $node['no_tabulate'] ) ) {
					$no_tablulates = array_merge( $no_tablulates, $node['no_tabulate'] );
				}

				if ( isset( $node['tag'] ) && ! in_array( $node['tag'], $no_tablulates ) ) {
					$html_return .= "\n";
					$html_return .= str_repeat( "\t", $tree_level );
				}

				if ( isset( $node['tag'] ) && ! in_array( $node['tag'], $this->self_closers ) ) {
					$html_return .= '</' . $node['tag'] . '>';
				}

				if ( isset( $node['tag'] ) && in_array( $node['tag'], $this->self_closers ) ) {
					$html_return .= '/>';
				}
			}

			return $html_return;
		}

		/**
		 * Clear cued nodes
		 */
		public function reset_nodes() {
			unset( $this->nodes );
			$this->nodes = array();
		}

		/**
		 * Gets the random identifier.
		 *
		 * @param      integer $length  The length.
		 *
		 * @return     string  The random identifier.
		 */
		protected function get_random_id( $length = 8 ) {
			return substr( md5( rand() ), 0, $length );
		}

		/**
		 * Adds child nodes inside parent nodes to generate html
		 *
		 * @return array htmlTree
		 */
		private function build_tree() {

			$arr_prop = func_get_args();

			if ( isset( $arr_prop[1] ) ) {
				$arr_tree = $arr_prop[1];
			} else {
				$arr_tree = $this->nodes;
			}

			foreach ( $arr_tree as &$node ) {

				if ( isset( $node['id'] ) && $node['id'] == $arr_prop[0]['parent_id'] ) {
					if ( ! isset( $node['children'] ) ) {
						$node['children'] = array();
					}
					unset( $arr_prop[0]['parent_id'] );

					array_push( $node['children'], $arr_prop[0] );

				} elseif ( isset( $node['children'] ) && $node['children'] ) {
					$node['children'] = $this->build_tree( $arr_prop[0], $node['children'] );
				}
			}

			return $arr_tree;
		}
	}
}
