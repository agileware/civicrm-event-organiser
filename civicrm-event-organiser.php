<?php /*
--------------------------------------------------------------------------------
Plugin Name: CiviCRM Event Organiser
Description: Sync Event Organiser Events with CiviCRM Events.
Version: 0.4.4-agileware-1
Author: Christian Wach
Author URI: http://haystack.co.uk
Plugin URI: https://github.com/agileware/civicrm-event-organiser
Text Domain: civicrm-event-organiser
Domain Path: /languages
Network: false
--------------------------------------------------------------------------------
*/



// Set our version here.
define( 'CIVICRM_WP_EVENT_ORGANISER_VERSION', '0.4.4' );

// Store reference to this file.
if ( ! defined( 'CIVICRM_WP_EVENT_ORGANISER_FILE' ) ) {
	define( 'CIVICRM_WP_EVENT_ORGANISER_FILE', __FILE__ );
}

// Store URL to this plugin's directory.
if ( ! defined( 'CIVICRM_WP_EVENT_ORGANISER_URL' ) ) {
	define( 'CIVICRM_WP_EVENT_ORGANISER_URL', plugin_dir_url( CIVICRM_WP_EVENT_ORGANISER_FILE ) );
}
// Store PATH to this plugin's directory.
if ( ! defined( 'CIVICRM_WP_EVENT_ORGANISER_PATH' ) ) {
	define( 'CIVICRM_WP_EVENT_ORGANISER_PATH', plugin_dir_path( CIVICRM_WP_EVENT_ORGANISER_FILE ) );
}



/**
 * CiviCRM Event Organiser Class.
 *
 * A class that encapsulates this plugin's functionality.
 *
 * @since 0.1
 */
class CiviCRM_WP_Event_Organiser {

	/**
	 * Admin/DB object.
	 *
	 * @since 0.1
	 * @access public
	 * @var object $db The admin/db object.
	 */
	public $db;

	/**
	 * CiviCRM utilities object.
	 *
	 * @since 0.1
	 * @access public
	 * @var object $civi The CiviCRM utilities object.
	 */
	public $civi;

	/**
	 * Event Organiser utilities object.
	 *
	 * @since 0.1
	 * @access public
	 * @var object $eo The Event Organiser utilities object.
	 */
	public $eo;

	/**
	 * Event Organiser venue utilities object.
	 *
	 * @since 0.1
	 * @access public
	 * @var object $eo_venue The Event Organiser venue utilities object.
	 */
	public $eo_venue;

	/**
	 * Taxonomy Sync object.
	 *
	 * @since 0.4.2
	 * @access public
	 * @var object $taxonomy The taxonomy sync object.
	 */
	public $taxonomy;

	/**
	 * Term Description object.
	 *
	 * @since 0.2.1
	 * @access public
	 * @var object $term_html The HTML term descriptions object.
	 */
	public $term_html;



	/**
	 * Initialises this object.
	 *
	 * @since 0.1
	 */
	public function __construct() {

		// Use translation files.
		add_action( 'plugins_loaded', array( $this, 'enable_translation' ) );

		// Initialise.
		add_action( 'plugins_loaded', array( $this, 'initialise' ) );

	}



	/**
	 * Do stuff on plugin init.
	 *
	 * @since 0.1
	 */
	public function initialise() {

		// Bail if Event Organiser plugin is not present.
		if ( ! defined( 'EVENT_ORGANISER_VER' ) ) return;

		// Bail if CiviCRM plugin is not present.
		if ( ! function_exists( 'civi_wp' ) ) return;

		// Include files.
		$this->include_files();

		// Set up objects and references.
		$this->setup_objects();

		/**
		 * Broadcast that this plugin is now loaded.
		 *
		 * This action is used internally by this plugin to initialise its objects
		 * and ensures that all includes and setup has occurred beforehand.
		 *
		 * @since 0.4.1
		 */
		do_action( 'civicrm_wp_event_organiser_loaded' );

	}



	/**
	 * Include files.
	 *
	 * @since 0.4
	 */
	public function include_files() {

		// Load our Term Description class.
		require( CIVICRM_WP_EVENT_ORGANISER_PATH . 'includes/civicrm-event-organiser-term-html.php' );

		// Load our Admin/DB class.
		require( CIVICRM_WP_EVENT_ORGANISER_PATH . 'includes/civicrm-event-organiser-admin.php' );

		// Load our CiviCRM class.
		require( CIVICRM_WP_EVENT_ORGANISER_PATH . 'includes/civicrm-event-organiser-civi.php' );

		// Load our Event Organiser class.
		require( CIVICRM_WP_EVENT_ORGANISER_PATH . 'includes/civicrm-event-organiser-eo.php' );

		// Load our Event Organiser Venue Sync class.
		require( CIVICRM_WP_EVENT_ORGANISER_PATH . 'includes/civicrm-event-organiser-eo-venue.php' );

		// Load our Taxonomy Sync class.
		require( CIVICRM_WP_EVENT_ORGANISER_PATH . 'includes/civicrm-event-organiser-taxonomy.php' );

		// Load our template functions.
		require( CIVICRM_WP_EVENT_ORGANISER_PATH . 'includes/civicrm-event-organiser-functions.php' );

	}



	/**
	 * Set up this plugin's objects.
	 *
	 * @since 0.4
	 */
	public function setup_objects() {

		// Only do this once.
		static $done;
		if ( isset( $done ) AND $done === true ) return;

		// Initialise objects.
		$this->term_html = new CiviCRM_WP_Event_Organiser_Term_Description;
		$this->db = new CiviCRM_WP_Event_Organiser_Admin;
		$this->civi = new CiviCRM_WP_Event_Organiser_CiviCRM;
		$this->eo = new CiviCRM_WP_Event_Organiser_EO;
		$this->eo_venue = new CiviCRM_WP_Event_Organiser_EO_Venue;
		$this->taxonomy = new CiviCRM_WP_Event_Organiser_Taxonomy;

		// Store references.
		$this->term_html->set_references( $this );
		$this->db->set_references( $this );
		$this->civi->set_references( $this );
		$this->eo->set_references( $this );
		$this->eo_venue->set_references( $this );
		$this->taxonomy->set_references( $this );

		// We're done.
		$done = true;

	}



	/**
	 * Do stuff on plugin activation.
	 *
	 * @since 0.1
	 */
	public function activate() {

	}



	/**
	 * Do stuff on plugin deactivation.
	 *
	 * @since 0.1
	 */
	public function deactivate() {

	}



	//##########################################################################



	/**
	 * Load translation files.
	 *
	 * A good reference on how to implement translation in WordPress:
	 * http://ottopress.com/2012/internationalization-youre-probably-doing-it-wrong/
	 *
	 * @since 0.1
	 */
	public function enable_translation() {

		// Not used, as there are no translations as yet.
		load_plugin_textdomain(

			// Unique name.
			'civicrm-event-organiser',

			// Deprecated argument.
			false,

			// Relative path to directory containing translation files.
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'

		);

	}



} // Class ends.



// Declare as global.
global $civicrm_wp_event_organiser;

// Init plugin.
$civicrm_wp_event_organiser = new CiviCRM_WP_Event_Organiser;



/**
 * Utility to get a reference to this plugin.
 *
 * @since 0.2.2
 *
 * @return object $civicrm_wp_event_organiser The plugin reference.
 */
function civicrm_eo() {

	// Return instance.
	global $civicrm_wp_event_organiser;
	return $civicrm_wp_event_organiser;

}



/**
 * Utility to add link to settings page.
 *
 * @since 0.1
 *
 * @param array $links The existing links array.
 * @param str $file The name of the plugin file.
 * @return array $links The modified links array.
 */
function civicrm_wp_event_organiser_plugin_action_links( $links, $file ) {

	// Bail if Event Organiser plugin is not present.
	if ( ! defined( 'EVENT_ORGANISER_VER' ) ) return $links;

	// Bail if CiviCRM plugin is not present.
	if ( ! function_exists( 'civi_wp' ) ) return $links;

	// Add settings link.
	if ( $file == plugin_basename( dirname( __FILE__ ) . '/civicrm-event-organiser.php' ) ) {

		// Is this Network Admin?
		if ( is_network_admin() ) {
			$link = add_query_arg( array( 'page' => 'civi_eo_parent' ), network_admin_url( 'settings.php' ) );
		} else {
			$link = add_query_arg( array( 'page' => 'civi_eo_parent' ), admin_url( 'options-general.php' ) );
		}

		// Add settings link.
		$links[] = '<a href="' . esc_url( $link ) . '">' . esc_html__( 'Settings', 'civicrm-event-organiser' ) . '</a>';

	}

	// --<
	return $links;

}

// Add filters for the above.
add_filter( 'network_admin_plugin_action_links', 'civicrm_wp_event_organiser_plugin_action_links', 10, 2 );
add_filter( 'plugin_action_links', 'civicrm_wp_event_organiser_plugin_action_links', 10, 2 );



