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
			    <div class="first panel"><a href="#">&lt;&lt;First</a></div>
			    <div class="previous panel"><a href="#">&lt;Previous</a></div>
    			<div class="next panel"><a href="#">Next&gt;</a></div>
    			<div class="last panel"><a href="#">Last&gt;&gt;</a></div>
			</div>
        	<?php
        }
	}
}