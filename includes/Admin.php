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
 * Admin class.
 *
 * Handle Admin.
 */
#[AllowDynamicProperties]
class Admin {

	use ContainerTrait;

	/**
	 * Class constructor.
	 *
	 * @since FLEXIBLEDATATABLEBLOCK_SINCE
	 */
	public function __construct() {
		$this->dashboard = new Admin\Dashboard();
		$this->menu      = new Admin\Menu();
	}
}
