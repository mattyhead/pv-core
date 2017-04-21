<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Elections_Core_Ui
 * @subpackage Pv_Elections_Core_Ui/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pv_Elections_Core_Ui
 * @subpackage Pv_Elections_Core_Ui/admin
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */
class Pv_Elections_Core_Ui_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pv_Elections_Core_Ui_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pv_Elections_Core_Ui_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pv-elections-core-ui-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pv_Elections_Core_Ui_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pv_Elections_Core_Ui_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pv-elections-core-ui-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_parent_menus()
    {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        
        add_manu_page(__('Phillyvotes', $this->plugin_name),'Phillyvotes','manage_options','phillyvotes', array($this, 'display_candidates_and_offices_page'));
        add_submenu_page('phillyvotes', __('Candidates & Offices', $this->plugin_name), 'Candidates & Offices', 'manage_options', 'candidates-and-offices', array($this, 'display_candidates_and_offices_page'));
        add_submenu_page('phillyvotes', __('Department', $this->plugin_name), 'Department', 'manage_options', 'department', array($this, 'display_department_page'));
        add_submenu_page('phillyvotes', __('Offices', $this->plugin_name), 'Offices', 'manage_options', 'officers', array($this, 'display_officers_page'));
        add_suubmenu_page('phillyvotes', __('Results', $this->plugin_name), 'Results', 'manage_options', 'results', array($this, 'display_results_page'));
        add_submenu_page('phillyvotes', __('Voters', $this->plugin_name), 'Voters', 'manage_options', 'voters', array($this, 'display_voters_page'));
    
    }

}
