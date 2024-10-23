<?php
/**
 * Table class.
 *
 * Handles block registration and rendering.
 *
 * @package FlexibleDataTableBlock\Blocks
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */

namespace FlexibleDataTableBlock\Blocks;

/**
 * Blocks class.
 *
 * Handles block registration and rendering.
 */
class Table {

	/**
	 * Class constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_assets' ) );
		add_action( 'init', array( $this, 'register_custom_api_data_table_block' ) );
	}

	/**
	 * Assets Loading
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		if ( is_admin() ) {
			wp_enqueue_script( 'flexible-data-table-block-block-script' );
			wp_localize_script(
				'flexible-data-table-block-block-script',
				'FlexibleDataTableBlockData',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'flexible_data_table_ajax_nonce' ),
				)
			);
		}
	}

	/**
	 * Register the block.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function register_custom_api_data_table_block() {
		$block_json = FLEXIBLEDATATABLE_BLOCK_ASSET_PATH . '/block.json';

		if ( file_exists( $block_json ) ) {
            // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			$block_data = json_decode( file_get_contents( $block_json ), true );

			register_block_type(
				$block_data['name'],
				array_merge(
					$block_data,
					array(
						'style' => 'flexible-data-table-block-table-style',
					)
				)
			);
		}
	}
}
