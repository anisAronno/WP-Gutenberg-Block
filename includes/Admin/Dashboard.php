<?php
/**
 * Dashboard class.
 *
 * Handle Admin.
 *
 * @package FlexibleDataTableBlock\Admin
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */

namespace FlexibleDataTableBlock\Admin;

/**
 * Admin class.
 *
 * Handle Admin.
 */
class Dashboard {

	/**
	 * Class constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		add_action( 'flexible_data_table_load_dashboard', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Assets Loading
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		wp_enqueue_script( 'flexible-data-table-block-dashboard' );
		wp_enqueue_style( 'flexible-data-table-block-dashboard' );
	}

	/**
	 * Get Base Url
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @param string $admin_page_url The URL of the admin page.
	 *
	 * @return string
	 */
	public function get_router_base_url( $admin_page_url ) {
		$url_with_domain = substr( $admin_page_url, strpos( $admin_page_url, '//' ) + 2 );

		return substr( $url_with_domain, strpos( $url_with_domain, '/' ) + 1 ) . '#';
	}
}
