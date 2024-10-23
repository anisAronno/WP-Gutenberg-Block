<?php
/**
 * Plugin Name: Flexible Data Table Block
 * Description: A flexible data table block for WordPress.
 * Plugin URI: https://github.com/anisAronno/flexible-data-table-block
 * Author: Anichur Rahaman
 * Author URI: https://anichur.com
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: flexibleDataTableBlock
 *
 * @package flexibleDataTableBlock
 */

defined( 'ABSPATH' ) || exit;

if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	return;
}

require_once __DIR__ . '/vendor/autoload.php';

use WeDevs\WpUtils\ContainerTrait;
use WeDevs\WpUtils\SingletonTrait;

/**
 * Main Plugin Class
 *
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */
#[AllowDynamicProperties]
final class FlexibleDataTableBlock {

	use SingletonTrait;
	use ContainerTrait;

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public const VERSION = '1.0.0';

	/**
	 * Constructor for the flexibleDataTableBlock class.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * Sets up all the appropriate hooks and actions within our plugin.
	 */
	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, array( $this, 'activate' ) );

		$this->init_plugin();
		$this->init_hooks();
	}

	/**
	 * Run the installer to create necessary migrations and seeders.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function activate() {
		$installer = new \FlexibleDataTableBlock\Setup\Installer();
		$installer->run();
	}

	/**
	 * Initialize the hooks.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function init_hooks() {
		// Localize our plugin.
		add_action( 'init', array( $this, 'localization_setup' ) );

		add_action( 'plugins_loaded', array( $this, 'instantiate' ) );
	}

	/**
	 * Initialize plugin for localization
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @uses load_plugin_textdomain()
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'flexibleDataTableBlock', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Instantiate the classes
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function instantiate() {
		$this->assets   = new FlexibleDataTableBlock\Assets();
		$this->commands = new FlexibleDataTableBlock\Commands();
		$this->blocks   = new FlexibleDataTableBlock\Blocks();

		if ( is_admin() ) {
			// Show this only if administrator role is enabled.
			$this->admin = new FlexibleDataTableBlock\Admin();
			$this->ajax  = new FlexibleDataTableBlock\Ajax();
		}
	}

	/**
	 * Load the plugin after all plugins are loaded.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function init_plugin() {
		$helpers = FLEXIBLEDATATABLE_DIR . '/helpers/common-functions.php';

		if ( file_exists( $helpers ) ) {
			require_once $helpers;
		}

		/**
		 * Fires after the plugin is loaded.
		 *
		 * @since FLEXIBLEDATATABLEBLOCK_SINCE
		 */
		do_action( 'flexible_data_table_loaded' );
	}

	/**
	 * Define the constants.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function define_constants() {
		$this->define( 'FLEXIBLEDATATABLE_VERSION', self::VERSION );
		$this->define( 'FLEXIBLEDATATABLE_FILE', __FILE__ );
		$this->define( 'FLEXIBLEDATATABLE_DIR', __DIR__ );
		$this->define( 'FLEXIBLEDATATABLE_PATH', dirname( FLEXIBLEDATATABLE_FILE ) );
		$this->define( 'FLEXIBLEDATATABLE_INCLUDES', FLEXIBLEDATATABLE_PATH . '/includes' );
		$this->define( 'FLEXIBLEDATATABLE_URL', plugins_url( '', FLEXIBLEDATATABLE_FILE ) );
		$this->define( 'FLEXIBLEDATATABLE_ASSET_URI', FLEXIBLEDATATABLE_URL . '/assets' );
		$this->define( 'FLEXIBLEDATATABLE_BLOCK_ASSET_URI', FLEXIBLEDATATABLE_URL . '/build' );
		$this->define( 'FLEXIBLEDATATABLE_BLOCK_ASSET_PATH', FLEXIBLEDATATABLE_PATH . '/build' );
		$this->define( 'FLEXIBLEDATATABLE_TEMPLATE_PATH', FLEXIBLEDATATABLE_DIR . '/templates' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @param string $constant_name The constant name to check and define.
	 * @param mixed  $value         The value to set if the constant is not defined.
	 *
	 * @return void
	 */
	private function define( $constant_name, $value ) {
		if ( ! defined( $constant_name ) ) {
			define( $constant_name, $value ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.VariableConstantNameFound
		}
	}
}

/**
 * Returns the main instance of FlexibleDataTableBlock
 *
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 *
 * @return FlexibleDataTableBlock
 */
function flexibleDataTableBlock() { // phpcs:ignore Universal.Files.SeparateFunctionsFromOO.Mixed
	return FlexibleDataTableBlock::instance();
}

flexibleDataTableBlock();
