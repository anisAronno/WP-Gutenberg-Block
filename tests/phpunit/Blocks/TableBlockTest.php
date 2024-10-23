<?php

namespace FlexibleDataTableBlock\Tests\Blocks;

use WP_UnitTestCase;
use FlexibleDataTableBlock\Blocks\Table;

/**
 * Test class for Table Block.
 */
class TableBlockTest extends WP_UnitTestCase {

    /**
     * Instance of Table block.
     *
     * @var Table
     */
    protected $table_block;

    /**
     * Setup test environment.
     */
    protected function setUp(): void {
        parent::setUp();

        // Initialize Table block instance
        $this->table_block = new Table();
    }

    /**
     * Test register_custom_api_data_table_block method.
     */
    public function test_register_custom_api_data_table_block() {
        // Check if the block type is registered
        $this->assertTrue( $this->is_block_registered( 'custom/flexible-data-table' ), 'Block type should be registered.' );
    }

    /**
     * Helper method to check if a block type is registered.
     *
     * @param string $block_name Block name to check.
     * @return bool
     */
    protected function is_block_registered( $block_name ) {
        $block_types = \WP_Block_Type_Registry::get_instance()->get_all_registered();
        return isset( $block_types[ $block_name ] );
    }
}
