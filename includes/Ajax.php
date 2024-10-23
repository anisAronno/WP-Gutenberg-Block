<?php
/**
 * Admin class.
 *
 * Handle Admin.
 *
 * @package FlexibleDataTableBlock
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 */

namespace FlexibleDataTableBlock;

use WeDevs\WpUtils\ContainerTrait;

/**
 * Block class.
 *
 * Handle Blocks.
 */
#[AllowDynamicProperties]
class Ajax {

	use ContainerTrait;

	/**
	 * Class constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		$this->get_table_data = new \FlexibleDataTableBlock\Ajax\Get_Table_Data();
	}
}
