<?php
/**
 * Shared validator class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Elections_Core
 * @subpackage Pv_Elections_Core/db
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

if ( ! class_exists( 'Pv_Core_Paginator_Helper' ) ) {
	class Pv_Core_Paginator_Helper {

		/**
		 * Pagination
		 */
		protected $pagination;

        public function __construct( $pagination ) {
            $this->pagination = $pagination;
        }

        public function get_list_footer ( ) {
        	?>
        	<div class="navigation">
			    <div class="first panel">First Page</div>
			    <div class="previous panel">Previous Page</div>
    			<div class="next panel">Next Page</div>
    			<div class="last panel">Last Page</div>
			</div>
        	<?php
        }
	}
}