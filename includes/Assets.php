<?php
/**
 * Assets class.
 *
 * Handle all the assets.
 *
 * @package FlexibleDataTableBlock
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */

namespace FlexibleDataTableBlock;

/**
 * Class Assets
 *
 * @package FlexibleDataTableBlock
 */
class Assets {

	/**
	 * The constructor for the class
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_all_scripts' ) );
	}

	/**
	 * Register all the css and js from here
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return void
	 */
	public function register_all_scripts() {
		$styles  = $this->get_styles();
		$scripts = $this->get_scripts();
		do_action( 'flexible_data_table_before_register_scripts', $scripts, $styles );
		$this->register_styles( $styles );
		$this->register_scripts( $scripts );
		do_action( 'flexible_data_table_after_register_scripts', $scripts, $styles );
	}

	/**
	 * Register the CSS from here. Need to define the JS first from get_styles()
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @param array $styles Array of styles.
	 *
	 * @return void
	 */
	public function register_styles( $styles ) {
		foreach ( $styles as $handle => $style ) {
			$deps    = ! empty( $style['deps'] ) ? $style['deps'] : array();
			$version = ! empty( $style['version'] ) ? $style['version'] : FLEXIBLEDATATABLE_VERSION;
			$media   = ! empty( $style['media'] ) ? $style['media'] : 'all';

			wp_register_style( 'flexible-data-table-block-' . $handle, $style['src'], $deps, $version, $media );
		}
	}

	/**
	 * Register the JS from here. Need to define the JS first from get_scripts()
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @param array $scripts Array of scripts.
	 *
	 * @return void
	 */
	public function register_scripts( $scripts ) {
		foreach ( $scripts as $handle => $script ) {
			$deps      = ! empty( $script['deps'] ) ? $script['deps'] : array();
			$in_footer = ! empty( $script['in_footer'] ) ? $script['in_footer'] : true;
			$version   = ! empty( $script['version'] ) ? $script['version'] : FLEXIBLEDATATABLE_VERSION;

			wp_register_script( 'flexible-data-table-block-' . $handle, $script['src'], $deps, $version, $in_footer );
		}
	}

	/**
	 * Returns the list of styles
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return mixed|null
	 */
	public function get_styles() {
		return array(
			'dashboard'   => array(
				'src' => FLEXIBLEDATATABLE_ASSET_URI . '/css/flexibleDataTableBlock.css',
			),
			'table-style' => array(
				'src' => FLEXIBLEDATATABLE_BLOCK_ASSET_URI . '/index.css',
			),
		);
	}

	/**
	 * Returns the list of JS
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 *
	 * @return mixed|null
	 */
	public function get_scripts() {
		$asset_path = FLEXIBLEDATATABLE_BLOCK_ASSET_PATH . '/index.asset.php';

		$dependency = array(
			'dependencies' => null,
			'version'      => null,
		);

		if ( file_exists( $asset_path ) ) {
			$dependency = include $asset_path;
		}

		$scripts = array(
			'dashboard'    => array(
				'src'       => FLEXIBLEDATATABLE_ASSET_URI . '/js/flexibleDataTableBlock.js',
				'in_footer' => true,
			),
			'block-script' => array(
				'src'       => FLEXIBLEDATATABLE_BLOCK_ASSET_URI . '/index.js',
				'version'   => $dependency['version'],
				'deps'      => array( 'wp-block-editor', 'wp-blocks', 'wp-components', 'wp-element', 'wp-i18n' ),
				'in_footer' => true,
			),
		);

		return $scripts;
	}
}
