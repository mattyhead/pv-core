<?php
/**
 * Shared paginator helper class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Core
 * @subpackage Pv_Core/helpers
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Helper_Paginator' ) ) {
	/**
	 * Class for pv core paginator helper.
	 */
	class Pv_Core_Helper_Paginator {

		/**
		 * Pagination
		 *
		 * @var mixed $pagination
		 */
		protected $pagination;

		/**
		 * Plugin name
		 *
		 * @var mixed $plugin_name
		 */
		protected $plugin_name;

		/**
		 * Constructor
		 *
		 * @param      mixed  $plugin_name  Plugin name.
		 * @param      mixed  $pagination   The pagination.
		 */
		public function setup( $plugin_name, $pagination ) {

			$this->pagination = $pagination;
			$this->plugin_name = $plugin_name;
		}

		/**
		 * Gets the list footer.
		 */
		public function get_list_footer() {

			$first = '&lt;&lt;first';
			$previous = '&lt;previous';
			$next = 'next&gt;';
			$last = 'last&gt;&gt;';

			$base_link = admin_url( 'admin.php?page=' . $this->plugin_name );
			d( $this->pagination, $_REQUEST );
			if ( isset( $this->pagination->first ) && $this->pagination->first ) {
				$first = '<a href="' . esc_attr( $base_link . '&current=' . $this->pagination->first ) . '">' . $first . '</a>';
			}

			if ( isset( $this->pagination->previous ) && $this->pagination->previous ) {
				$previous = '<a href="' . esc_attr( $base_link . '&current=' . $this->pagination->previous ) . '">' . $previous . '</a>';
			}

			if ( isset( $this->pagination->next ) && $this->pagination->next ) {
				$next = '<a href="' . esc_attr( $base_link . '&current=' . $this->pagination->next ) . '">' . $next . '</a>';
			}

			if ( isset( $this->pagination->last ) && $this->pagination->last ) {
				$last = '<a href="' . esc_attr( $base_link . '&current=' . $this->pagination->last ) . '">' . $last . '</a>';
			}

			?>
			<div class="row-actions visible col-left">
				<span><?php echo $first ; ?></span>
				<span>|</span>
				<span><?php echo $previous ; ?></span>
				<span>|</span>
				<span><?php echo $next ; ?></span>
				<span>|</span>
				<span><?php echo $last ; ?></span>
			</div>
			<?php
		}
	}
}
