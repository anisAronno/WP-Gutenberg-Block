<?php
/**
 * Blocks class.
 *
 * Handle Blocks.
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
class Blocks {

	use ContainerTrait;

	/**
	 * Class constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		$this->table = new Blocks\Table();
	}
}
