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
		 * Plugin name
		 *
		 * @var mixed $plugin_name
		 */
		protected $exportable;

		/**
		 * Constructor
		 *
		 * @param  mixed $plugin_name  Plugin name.
		 * @param  mixed $pagination   The pagination.
		 * @param  mixed $exportable  Plugin name.
		 * @param  mixed $deletable  Plugin name.
		 */
		public function setup( $plugin_name, $pagination, $exportable = false, $deletable = false ) {

			$this->deletable = $deletable;
			$this->exportable = $exportable;
			$this->pagination = $pagination;
			$this->plugin_name = $plugin_name;
		}

		/**
		 * Gets the list navigation.
		 */
		public function get_footer() {

			$first = '&lt;&lt;first';
			$previous = '&lt;previous';
			$next = 'next&gt;';
			$last = 'last&gt;&gt;';

			$base_link = admin_url( 'admin.php?page=' . $this->plugin_name );

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
				<span class="alignleft row-actions visible">
					<span>page <?php echo esc_html( $this->pagination->current ); ?> of <?php echo esc_html( $this->pagination->last ? $this->pagination->last : $this->pagination->current ); ?></span>
					<span>|</span>
					<span><?php echo $first ; ?></span>
					<span>|</span>
					<span><?php echo $previous ; ?></span>
					<span>|</span>
					<span><?php echo $next ; ?></span>
					<span>|</span>
					<span><?php echo $last ; ?></span>
				</span>
				<span class="alignright row-actions visible">
					<?php
					if ( $this->exportable ) :
					?>
					<span><a target="_blank" href="<?php echo esc_attr( WP_PLUGIN_URL . '/' . $this->plugin_name . '/admin/export.php?&current=' . $this->pagination->current . '&_wpnonce=' . wp_create_nonce( 'pv_admin_export' ) ); ?>" >export all</a></span>
					<?php
					endif;
					if ( $this->exportable && $this->deletable ) :
					?>
					<span>|</span>
					<?php
					endif;
					if ( $this->deletable ) :
					?>
					<span class="trash"><a href="<?php echo esc_attr( admin_url( 'admin-post.php?action=pvmi_admin_delete_all&current=' . $this->pagination->current . '&_wpnonce=' . wp_create_nonce( $this->plugin_name . '_admin_delete_all' ) ) ); ?>" >delete all</a></span>
					<?php
					endif;
					?>
				</span>
			<?php
		}

	}

}


