<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/flashxyz/BookMe/wiki
 * @since      1.0.0
 *
 * @package    Wp_book_me
 * @subpackage Wp_book_me/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_book_me
 * @subpackage Wp_book_me/public
 * @author     nirbm, hudeda, rotemsd, flashxyz, liorsap1 <flashxyz@gmail.com>
 */
class Wp_book_me_Public {

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
		 * defined in Wp_book_me_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_book_me_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp_book_me-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery.timepicker', plugin_dir_url( __FILE__ ) . 'css/jquery.timepicker.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-datepicker', plugin_dir_url( __FILE__ ) . 'css/bootstrap-datepicker.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-ui.min', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'fullcalendar.min', plugin_dir_url( __FILE__ ) . 'css/fullcalendar.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap.min', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );

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
		 * defined in Wp_book_me_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_book_me_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp_book_me-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-2.2.4.min', plugin_dir_url( __FILE__ ) . 'js/jquery-2.2.4.min.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script(  'jquery-ui.min', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script(  'query.timepicker.min', plugin_dir_url( __FILE__ ) . 'js/jquery.timepicker.min.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script(  'moment.min', plugin_dir_url( __FILE__ ) . 'js/moment.min.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script( 'fullcalendar.min', plugin_dir_url( __FILE__ ) . 'js/fullcalendar.min.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script( 'lang-all', plugin_dir_url( __FILE__ ) . 'js/lang-all.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script( 'calendar', plugin_dir_url( __FILE__ ) . 'js/calendar.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script(  'bootstrap.min', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script(  'bootstrap-datepicker', plugin_dir_url( __FILE__ ) . 'js/bootstrap-datepicker.js', array( 'jquery'), $this->version, false);
		wp_enqueue_script(  'datepair', plugin_dir_url( __FILE__ ) . 'js/datepair.js', array( 'jquery'), $this->version, false);
		
//		wp_enqueue_script(  $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jquery.datepair.js', array( 'jquery'), $this->version, false);
//		wp_enqueue_script(  $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jquery.timepicker.min.js', array( 'jquery'), $this->version, false);
		
//		wp_enqueue_script(  $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array( 'jquery'), $this->version, false);
//		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lang-all.js', array( 'jquery'), $this->version, false);
		

		


	}




}

include_once('partials/wp_book_me-public-display.php');

?>
