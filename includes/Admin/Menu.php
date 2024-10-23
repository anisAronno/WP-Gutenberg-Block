<?php
/**
 * Menu generator class.
 *
 * Ensure admin menu registrations.
 *
 * @package FlexibleDataTableBlock
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */

namespace FlexibleDataTableBlock\Admin;

/**
 * Menu generator class.
 *
 * Ensure admin menu registrations.
 *
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */
class Menu {

	/**
	 * Menu Slug.
	 *
	 * @var string
	 */
	private $menu_slug = 'flexibleDataTableBlock';

	/**
	 * Constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
	}

	/**
	 * Init Admin Menu
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function admin_menus() {
		$menu_hook = add_menu_page( __( 'FlexibleDataTableBlock', 'flexibleDataTableBlock' ), __( 'FlexibleDataTableBlock', 'flexibleDataTableBlock' ), flexible_data_table_get_admin_capability(), $this->menu_slug, array( $this, 'render_flexible_data_table' ), 'dashicons-smiley', 30 );

		add_action( 'load-' . $menu_hook, array( $this, 'flexible_data_table_menu_action' ) );
	}

	/**
	 * Backdoor for calling the menu hook.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function flexible_data_table_menu_action() {
		/**
		 * Backdoor for calling the menu hook.
		 * This hook won't get translated even the site language is changed
		 */
		do_action( 'flexible_data_table_load_dashboard' );
	}

	/**
	 * Render menu page
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function render_flexible_data_table() {
		$action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '';
		switch ( $action ) {
			case 'view':
				$template = FLEXIBLEDATATABLE_TEMPLATE_PATH . '/dashboard.php';
				break;

			case 'refresh':
				check_admin_referer( 'flexible_data_table_refresh_action' );
				$this->refresh_data();
				$template = FLEXIBLEDATATABLE_TEMPLATE_PATH . '/dashboard.php';
				break;

			default:
				$template = FLEXIBLEDATATABLE_TEMPLATE_PATH . '/dashboard.php';
				break;
		}

		if ( file_exists( $template ) ) {
			include $template;
		}
	}

	/**
	 * Refresh data
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function refresh_data() {
		delete_transient( 'flexible_data_table_api_data' );
	}
}
