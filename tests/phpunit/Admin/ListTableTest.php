<?php

namespace FlexibleDataTableBlock\Tests\Admin;

use WP_UnitTestCase;
use FlexibleDataTableBlock\Admin\List_Table;

/**
 * List Table class test.
 */
class ListTableTest extends WP_UnitTestCase {

    /**
     * List Table class instance.
     *
     * @var List_Table
     */
    public $list_table;

    /**
     * Setup test environment.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->list_table = new List_Table();
    }

    /**
     * Test if columns are returned correctly.
     */
    public function test_get_columns() {
        $columns = $this->list_table->get_columns();

        // Perform assertions on the columns
        $this->assertIsArray( $columns );
        $this->assertArrayHasKey( 'id', $columns );
        $this->assertArrayHasKey( 'fname', $columns );
        $this->assertArrayHasKey( 'lname', $columns );
        $this->assertArrayHasKey( 'email', $columns );
        $this->assertArrayHasKey( 'date', $columns );
    }

    /**
     * Test if no items message is returned correctly.
     */
    public function test_no_items() {
        ob_start();
        $this->list_table->no_items();
        $output = ob_get_clean();

        // Perform assertions on the output
        $this->assertNotEmpty( $output );
        $this->assertStringContainsString( 'No contacts found', $output );
    }

    /**
     * Test if default column value is returned correctly.
     */
    public function test_column_default() {
        $item = [
			'id' => 1,
			'fname' => 'John',
			'lname' => 'Doe',
			'email' => 'john.doe@example.com',
			'date' => strtotime( '2024-01-01' ),
		];
        $column_name = 'fname';

        $value = $this->list_table->column_default( $item, $column_name );

        // Perform assertions on the value
        $this->assertEquals( 'John', $value );

        // Test date column
        $column_name = 'date';
        $value = $this->list_table->column_default( $item, $column_name );
        $this->assertEquals( 'Jan 01, 2024', $value );
    }

    /**
     * Test if items are prepared correctly.
     */
    public function test_prepare_items() {
        // Mock data returned from API
        $mock_data = [
            'rows' => [
                [
					'id' => 1,
					'fname' => 'John',
					'lname' => 'Doe',
					'email' => 'john.doe@example.com',
					'date' => strtotime( '2024-01-01' ),
				],
                [
					'id' => 2,
					'fname' => 'Jane',
					'lname' => 'Doe',
					'email' => 'jane.doe@example.com',
					'date' => strtotime( '2024-01-02' ),
				],
            ],
        ];

        // Use reflection to make the fetch_data_from_api method accessible
        $reflection = new \ReflectionClass( $this->list_table );
        $method = $reflection->getMethod( 'fetch_data_from_api' );
        $method->setAccessible( true );

        // Mock the fetch_data_from_api method to return the mock data
        $method->invoke( $this->list_table, $mock_data );

        $this->list_table->prepare_items();

        // Perform assertions on the items
        $this->assertIsArray( $this->list_table->items );
        $this->assertCount( 5, $this->list_table->items );
    }
}
