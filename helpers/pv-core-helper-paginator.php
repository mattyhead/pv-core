<?php
/**
 * Shared validator class
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
		 * Constructor
		 *
		 * @param      mixed $pagination  The pagination.
		 */
		public function setup( $pagination ) {
			$this->pagination = $pagination;
		}

		/**
		 * Gets the list footer.
		 */
		public function get_list_footer() {

			$first = '&lt;&lt; first';
			$previous = '&lt; previous';
			$next = 'next &gt;';
			$last = 'last &gt;&gt;';

			$base_link = admin_url( 'admin.php?page=' . $this->plugin_name );

			if ( isset( $this->pagination->first ) && $this->pagination->first ) {
				$first = '<a href="' . esc_attr( $base_link . $this->pagination->first ) . '">' . $first . '</a>';
			}

			if ( isset( $this->pagination->previous ) && $this->pagination->previous ) {
				$previous = '<a href="' . esc_attr( $base_link . $this->pagination->previous ) . '">' . $previous . '</a>';
			}

			if ( isset( $this->pagination->next ) && $this->pagination->next ) {
				$next = '<a href="' . esc_attr( $base_link . $this->pagination->next ) . '">' . $next . '</a>';
			}

			if ( isset( $this->pagination->last ) && $this->pagination->last ) {
				$last = '<a href="' . esc_attr( $base_link . $this->pagination->last ) . '">' . $last . '</a>';
			}

			?>
			<div class="row-actions visible">
				<span class="first panel left"><?php echo $first; ?> |</span>
				<span class="previous panel left"><?php echo $previous; ?> |</span>>
				<span class="next panel right"><?php echo $next; ?> |</span>
				<span class="last panel right"><?php echo $last; ?></span>
			</div>
			<?php
		}
	}
}
