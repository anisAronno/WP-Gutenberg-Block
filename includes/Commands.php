<?php
/**
 * Commands class.
 *
 * Handle Commands.
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
class Commands {

	use ContainerTrait;

	/**
	 * Class constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		$this->refresh_data_command = new \FlexibleDataTableBlock\Commands\FlexibleDataTableBlock_Refresh_Data_Command();
	}
}
