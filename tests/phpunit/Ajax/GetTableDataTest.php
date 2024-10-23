<?php

namespace FlexibleDataTableBlock\Tests\Ajax;

use WP_Ajax_UnitTestCase;
use FlexibleDataTableBlock\Ajax\Get_Table_Data;

/**
 * Test class for Get_Table_Data AJAX handler.
 */
class GetTableDataTest extends WP_Ajax_UnitTestCase {

    /**
     * Instance of Get_Table_Data class.
     *
     * @var Get_Table_Data
     */
    protected $ajax_handler;

    /**
     * Setup test environment.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->ajax_handler = new Get_Table_Data();
    }

    /**
     * Test handle_ajax_request method.
     */
    public function test_handle_ajax_request() {
        // Mock nonce verification
        $_POST['nonce'] = wp_create_nonce( 'flexible_data_table_ajax_nonce' );

        // Mock API response
        $mock_data = [
            'headers' => [ 'ID', 'First Name', 'Last Name', 'Email', 'Date' ],
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

        // Mock the fetch_data_from_api method to return the mock data
        $ajax_handler_mock = $this->getMockBuilder( Get_Table_Data::class )
            ->onlyMethods( [ 'fetch_data_from_api' ] )
            ->getMock();
        $ajax_handler_mock->method( 'fetch_data_from_api' )->willReturn( $mock_data );

        // Set the mock object to the ajax handler
        $this->ajax_handler = $ajax_handler_mock;

        // Set the action and call the AJAX handler
        try {
            $this->_handleAjax( 'flexible_data_table_get_table_data' );
        } catch ( \WPAjaxDieContinueException $e ) {
            // Continue to assertions
        }

        // Get the response
        $response = json_decode( $this->_last_response, true );

        // Perform assertions
        $this->assertArrayHasKey( 'success', $response );
        $this->assertTrue( $response['success'] );
        $this->assertArrayHasKey( 'data', $response );
        $this->assertArrayHasKey( 'headers', $response['data']['data'] );
        $this->assertArrayHasKey( 'rows', $response['data']['data'] );
    }

    /**
     * Test fetch_data_from_api method with valid data.
     */
    public function test_fetch_data_from_api_valid() {
        // Mock API response
        $mock_response = [
            'data' => [
                'headers' => [ 'ID', 'First Name', 'Last Name', 'Email', 'Date' ],
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
            ],
        ];

        // Mock the wp_remote_get function to return the mock response
        add_filter(
            'pre_http_request', function () use ( $mock_response ) {
				return [
					'response' => [
						'code' => 200,
						'message' => 'OK',
					],
					'body' => json_encode( $mock_response ),
				];
			}
        );

        $data = $this->ajax_handler->fetch_data_from_api();

        // Perform assertions
        $this->assertIsArray( $data );
        $this->assertArrayHasKey( 'headers', $data );
        $this->assertArrayHasKey( 'rows', $data );
    }

    /**
     * Test is_valid_data_structure method.
     */
    public function test_is_valid_data_structure() {
        $valid_data = [
            'data' => [
                'headers' => [ 'ID', 'First Name', 'Last Name', 'Email', 'Date' ],
                'rows' => [
                    [
						'id' => 1,
						'fname' => 'John',
						'lname' => 'Doe',
						'email' => 'john.doe@example.com',
						'date' => strtotime( '2024-01-01' ),
					],
                ],
            ],
        ];

        $invalid_data = [
            'data' => [
                'invalid_key' => 'invalid_value',
            ],
        ];

        $reflection = new \ReflectionClass( $this->ajax_handler );
        $method = $reflection->getMethod( 'is_valid_data_structure' );
        $method->setAccessible( true );

        $this->assertTrue( $method->invokeArgs( $this->ajax_handler, [ $valid_data ] ) );
        $this->assertFalse( $method->invokeArgs( $this->ajax_handler, [ $invalid_data ] ) );
    }
}
