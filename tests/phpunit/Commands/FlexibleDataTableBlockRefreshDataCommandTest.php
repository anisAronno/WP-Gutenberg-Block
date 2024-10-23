<?php

namespace FlexibleDataTableBlock\Tests\Commands;

use WP_UnitTestCase;
use FlexibleDataTableBlock\Commands\FlexibleDataTableBlock_Refresh_Data_Command;

/**
 * Test class for FlexibleDataTableBlock_Refresh_Data_Command.
 */
class FlexibleDataTableBlockRefreshDataCommandTest extends WP_UnitTestCase {

    /**
     * Instance of FlexibleDataTableBlock_Refresh_Data_Command class.
     *
     * @var FlexibleDataTableBlock_Refresh_Data_Command
     */
    protected $command;

    /**
     * Setup test environment.
     */
    protected function setUp(): void {
        parent::setUp();

        // Mock the WP_CLI class if it does not exist
        if ( ! class_exists( 'WP_CLI' ) ) {
            class_alias( 'FlexibleDataTableBlock\Tests\Commands\WP_CLI_Mock', 'WP_CLI' );
        }

        $this->command = new FlexibleDataTableBlock_Refresh_Data_Command();
    }

    /**
     * Test add_commands method.
     */
    public function test_add_commands() {
        // Ensure the function runs without errors
        $this->expectOutputString( '' );
        $this->command->add_commands();
    }

    /**
     * Test refresh_data method.
     */
    public function test_refresh_data() {
        // Capture the output of WP_CLI::success
        $output = '';
        WP_CLI_Mock::$success_callback = function ( $message ) use ( &$output ) {
            $output = $message;
        };

        // Call the refresh_data method
        $this->command->refresh_data();

        // Assert the success message is correct
        $this->assertEquals( 'API data refreshed successfully.', $output );
    }
}

/**
 * Mock class for WP_CLI.
 */
class WP_CLI_Mock {

    public static $success_callback;

    public static function add_command( $name, $callable ) {
        // No-op for add_command in tests
    }

    public static function success( $message ) {
        if ( is_callable( self::$success_callback ) ) {
            call_user_func( self::$success_callback, $message );
        }
    }
}
