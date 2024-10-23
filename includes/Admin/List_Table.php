<?php
/**
 * List table class that fetches data from an API.
 *
 * @package FlexibleDataTableBlock\Admin
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */

namespace FlexibleDataTableBlock\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class that fetches data from an API.
 */
class List_Table extends \WP_List_Table {

	/**
	 * Constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'contact',
				'plural'   => 'contacts',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Display a message when no items are found.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function no_items() {
		esc_html_e( 'No contacts found', 'flexibleDataTableBlock' );
	}

	/**
	 * Get the columns for the list table.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'id'    => __( 'ID', 'flexibleDataTableBlock' ),
			'fname' => __( 'First Name', 'flexibleDataTableBlock' ),
			'lname' => __( 'Last Name', 'flexibleDataTableBlock' ),
			'email' => __( 'Email', 'flexibleDataTableBlock' ),
			'date'  => __( 'Date', 'flexibleDataTableBlock' ),
		);

		return $columns;
	}

	/**
	 * Override the search box.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @param string $text     The 'submit' button label.
	 * @param string $input_id ID attribute value for the search input field.
	 *
	 * @return string
	 */
	public function search_box( $text, $input_id ) {
		return '';
	}

	/**
	 * Default column behavior, when no specific column method is defined.
	 *
	 * @param array  $item        The current item.
	 * @param string $column_name The name of the column.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		if ( isset( $item[ $column_name ] ) ) {
			if ( 'date' === $column_name ) {
				return gmdate( 'M d, Y', $item[ $column_name ] );
			}
			return esc_html( $item[ $column_name ] );
		}

		return ''; // Return empty string if no data found.
	}

	/**
	 * Prepare the list of items for displaying.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array(); // No hidden columns.
		$this->_column_headers = array( $columns, $hidden, array() );

		$data = $this->fetch_data_from_api();

		// Ensure items are an array for countable and table listing.
		$this->items = isset( $data['rows'] ) && is_array( $data ) ? $data['rows'] : array();

		// Update pagination to handle the array of items.
		$this->set_pagination_args(
			array(
				'total_items' => count( $this->items ),
				'per_page'    => 5, // Define items per page.
			)
		);
	}


	/**
	 * Fetch data from the API.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return array
	 */
	private function fetch_data_from_api() {
		$table_data_class = new \FlexibleDataTableBlock\Ajax\Get_Table_Data();
		return $table_data_class->fetch_data_from_api();
	}
}
