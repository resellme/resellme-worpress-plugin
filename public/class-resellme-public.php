<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://privyreza.co.zw
 * @since      1.0.0
 *
 * @package    Resellme
 * @subpackage Resellme/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Resellme
 * @subpackage Resellme/public
 * @author     privyreza <privyreza@gmail.com>
 */
class Resellme_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Resellme_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Resellme_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/resellme-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Resellme_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Resellme_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/resellme-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register Shortcodes
	 * 
	 */
	public function resellme_shortcodes() {
		// Shortcodes
        include plugin_dir_path(__FILE__) . 'partials/shortcodes/rm-search-domain.php';
        include plugin_dir_path(__FILE__) . 'partials/shortcodes/rm-contact-details.php';
        include plugin_dir_path(__FILE__) . 'partials/shortcodes/rm-nameservers.php';
        include plugin_dir_path(__FILE__) . 'partials/shortcodes/rm-register-domain.php';
        include plugin_dir_path(__FILE__) . 'partials/shortcodes/rm-domains.php';

        // Custom Ajax Actions
        include plugin_dir_path(__FILE__) . 'ajax/resellme.php';
        include plugin_dir_path(__FILE__) . 'ajax/paynow-express.php';
        include plugin_dir_path(__FILE__) . 'ajax/paynow.php';
	}

	public function rm_force_login() {
		$post = get_page_by_title( 'Search Domain', OBJECT );
	}

}
