<?php
/**
 * Plugin Name: FWPP Pro
 * Plugin URI: https://github.com/fmd112000-coder/fwpp-pro
 * Description: A professional WordPress plugin with advanced features and functionality.
 * Version: 1.0.0
 * Author: fmd112000-coder
 * Author URI: https://github.com/fmd112000-coder
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fwpp-pro
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 *
 * @package FWPP_Pro
 * @author fmd112000-coder
 * @license GPL v2 or later
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define plugin constants
 */
if ( ! defined( 'FWPP_PRO_VERSION' ) ) {
	define( 'FWPP_PRO_VERSION', '1.0.0' );
}

if ( ! defined( 'FWPP_PRO_FILE' ) ) {
	define( 'FWPP_PRO_FILE', __FILE__ );
}

if ( ! defined( 'FWPP_PRO_DIR' ) ) {
	define( 'FWPP_PRO_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'FWPP_PRO_URL' ) ) {
	define( 'FWPP_PRO_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'FWPP_PRO_BASENAME' ) ) {
	define( 'FWPP_PRO_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * Main FWPP_Pro class
 *
 * @class FWPP_Pro
 */
final class FWPP_Pro {

	/**
	 * Plugin instance
	 *
	 * @var FWPP_Pro
	 */
	private static $instance = null;

	/**
	 * Get plugin instance
	 *
	 * @return FWPP_Pro
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		// Plugin activation
		register_activation_hook( FWPP_PRO_FILE, array( $this, 'activate' ) );

		// Plugin deactivation
		register_deactivation_hook( FWPP_PRO_FILE, array( $this, 'deactivate' ) );

		// Initialize plugin on WordPress init hook
		add_action( 'plugins_loaded', array( $this, 'init' ) );

		// Load plugin text domain for translations
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function init() {
		// Include required files
		$this->include_files();

		// Load plugin modules
		$this->load_modules();

		/**
		 * Hook: fwpp_pro_loaded
		 * Fires when FWPP Pro is fully loaded
		 */
		do_action( 'fwpp_pro_loaded' );
	}

	/**
	 * Include required files
	 *
	 * @return void
	 */
	private function include_files() {
		// Load utilities
		require_once FWPP_PRO_DIR . 'includes/class-helpers.php';

		// Load admin functionality if in admin
		if ( is_admin() ) {
			require_once FWPP_PRO_DIR . 'includes/admin/class-admin.php';
		}
	}

	/**
	 * Load plugin modules
	 *
	 * @return void
	 */
	private function load_modules() {
		/**
		 * Hook: fwpp_pro_load_modules
		 * Allows modules to be loaded dynamically
		 */
		do_action( 'fwpp_pro_load_modules' );
	}

	/**
	 * Plugin activation
	 *
	 * @return void
	 */
	public static function activate() {
		// Run activation code
		if ( class_exists( 'FWPP_Pro_Helpers' ) ) {
			FWPP_Pro_Helpers::log( 'FWPP Pro plugin activated' );
		}

		/**
		 * Hook: fwpp_pro_activate
		 * Fires when the plugin is activated
		 */
		do_action( 'fwpp_pro_activate' );

		// Flush rewrite rules if needed
		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation
	 *
	 * @return void
	 */
	public static function deactivate() {
		// Run deactivation code
		if ( class_exists( 'FWPP_Pro_Helpers' ) ) {
			FWPP_Pro_Helpers::log( 'FWPP Pro plugin deactivated' );
		}

		/**
		 * Hook: fwpp_pro_deactivate
		 * Fires when the plugin is deactivated
		 */
		do_action( 'fwpp_pro_deactivate' );

		// Flush rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Load plugin text domain for translations
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'fwpp-pro',
			false,
			dirname( FWPP_PRO_BASENAME ) . '/languages'
		);
	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_version() {
		return FWPP_PRO_VERSION;
	}
}

/**
 * Initialize the plugin
 */
function fwpp_pro() {
	return FWPP_Pro::get_instance();
}

// Kick off the plugin
fwpp_pro();
