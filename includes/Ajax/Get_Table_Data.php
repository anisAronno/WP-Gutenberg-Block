<?php
/**
 * AJAX handler class for retrieving table data.
 *
 * @package FlexibleDataTableBlock\Ajax
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */

namespace FlexibleDataTableBlock\Ajax;

/**
 * Class Get_Table_Data
 *
 * @package FlexibleDataTableBlock\Ajax
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */
class Get_Table_Data {

	/**
	 * Class constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		add_action( 'wp_ajax_flexible_data_table_get_table_data', array( $this, 'handle_ajax_request' ) );
		add_action( 'wp_ajax_nopriv_flexible_data_table_get_table_data', array( $this, 'handle_ajax_request' ) );
	}

	/**
	 * Handle the AJAX request.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function handle_ajax_request() {
		check_ajax_referer( 'flexible_data_table_ajax_nonce', 'nonce' );

		$data = $this->fetch_data_from_api();

		if ( is_wp_error( $data ) ) {
			wp_send_json_error( array( 'message' => $data->get_error_message() ) );
		} else {
			wp_send_json_success( array( 'data' => $data ) );
		}
	}

	/**
	 * Fetch data from API and return for internal usage.
	 *
	 * @return array|WP_Error Data from API or WP_Error on failure.
	 */
	public function fetch_data_from_api() {
		// Transient key for storing the API data.
		$transient_key = 'flexible_data_table_api_data';

		$data = get_transient( $transient_key );

		// If no data is found in the transient, fetch from the API.
		if ( empty( $data ) ) {
			$response = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );

			if ( is_wp_error( $response ) ) {
				return new \WP_Error( 'api_error', 'Failed to retrieve data from remote API.' );
			}

			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			// Validate data structure from API response.
			if ( ! $this->is_valid_data_structure( $data ) ) {
				return new \WP_Error( 'api_error', 'Invalid data structure received from API.' );
			}

			// Store the data in a transient, expiring in 1 hour.
			set_transient( $transient_key, $data, HOUR_IN_SECONDS );
		}

		return isset( $data['data'] ) ? $data['data'] : new \WP_Error( 'api_error', 'Invalid data structure received from API.' );
	}

	/**
	 * Validate data structure received from API.
	 *
	 * @param array $data Data received from the API.
	 * @return bool Whether the data structure is valid.
	 */
	private function is_valid_data_structure( $data ) {
		// Example validation, adjust as per actual data structure.
		return isset( $data['data']['headers'] ) && isset( $data['data']['rows'] );
	}
}
