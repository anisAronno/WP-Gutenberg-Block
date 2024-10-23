<?php
/**
 * PHPUnit bootstrap file.
 *
 * Loads the necessary setup to run the tests.
 * This file will be called first by the test runner.
 * Before running any tests.
 */

// Composer auto-loader must be loaded before WP_PHPUNIT__DIR will be available
require_once dirname( __DIR__, 2 ) . '/vendor/autoload.php';
$_tests_dir = getenv( 'WP_TESTS_DIR' ) ?: getenv( 'WP_PHPUNIT__DIR' ) ?: rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';

if ( ! file_exists( "{$_tests_dir}/includes/functions.php" ) ) {
    echo "Could not find {$_tests_dir}/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL;
    exit( 1 );
}

// Give access to tests_add_filter() function.
require_once "{$_tests_dir}/includes/functions.php";

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin(): void {
    require_once dirname( dirname( __DIR__ ) ) . '/flexibleDataTableBlock.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

/**
 * Install database tables for this plugin.
 */
function install_plugin_databases(): void {
    _manually_load_plugin();
    ( new \FlexibleDataTableBlock\Setup\Installer() )->run();
}

tests_add_filter( 'setup_theme', 'install_plugin_databases' );

// Start up the WP testing environment.
require "{$_tests_dir}/includes/bootstrap.php";
