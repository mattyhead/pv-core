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

if ( ! class_exists( 'Pv_Core_Paginator_Helper' ) ) {
	/**
	 * Class for pv core paginator helper.
	 */
	class Pv_Core_Paginator_Helper {

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
		public function __construct( $pagination ) {
			$this->pagination = $pagination;
		}

		/**
		 * Gets the list footer.
		 */
		public function get_list_footer() {
			?>
			<div class="navigation">
				<div class="first panel left"><a href="#">&lt;&lt;First</a></div>
				<div class="previous panel left"><a href="#">&lt;Previous</a></div>
				<div class="next panel right"><a href="#">Next&gt;</a></div>
				<div class="last panel right"><a href="#">Last&gt;&gt;</a></div>
			</div>
			<?php
		}
	}
}
