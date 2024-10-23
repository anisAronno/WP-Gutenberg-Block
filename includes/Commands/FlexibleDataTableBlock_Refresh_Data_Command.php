<?php
/**
 * Refresh data command.
 *
 * @package FlexibleDataTableBlock\Commands
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */

namespace FlexibleDataTableBlock\Commands;

/**
 * Class FlexibleDataTableBlock_Refresh_Data_Command
 *
 * @package FlexibleDataTableBlock\Commands
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */
class FlexibleDataTableBlock_Refresh_Data_Command {

	/**
	 * Class constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			$this->add_commands();
		}
	}

	/**
	 * Add the WP-CLI commands.
	 */
	public function add_commands() {
		\WP_CLI::add_command( 'FDT refresh-data', array( $this, 'refresh_data' ) );
	}

	/**
	 * Forces the refresh of the API data.
	 *
	 * @when after_wp_load
	 */
	public function refresh_data() {
		delete_transient( 'flexible_data_table_api_data' );
		$table_data = new \FlexibleDataTableBlock\Ajax\Get_Table_Data();
		$table_data->fetch_data_from_api();
		\WP_CLI::success( 'API data refreshed successfully.' );
	}
}
