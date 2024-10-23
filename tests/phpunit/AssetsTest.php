<?php

namespace FlexibleDataTableBlock\Tests;

use FlexibleDataTableBlock\Assets;
use PHPUnit\Framework\TestCase;

/**
 * Assets class test.
 */
class AssetsTest extends TestCase {

    /**
     * Assets class instance.
     *
     * @var Assets
     */
    public $assets;

    /**
     * Setup test environment.
     */
    protected function setUp(): void {
        parent::setUp();

        $this->assets = new Assets();
    }

    /**
     * Test get_styles method.
     */
    public function test_get_styles() {
        $styles = $this->assets->get_styles();

        $this->assertIsArray( $styles );
        $this->assertArrayHasKey( 'dashboard', $styles );
        $this->assertArrayHasKey( 'table-style', $styles );
        // Further assertions to check the structure of the returned styles array
    }

    /**
     * Test get_scripts method.
     */
    public function test_get_scripts() {
        $scripts = $this->assets->get_scripts();

        $this->assertIsArray( $scripts );
        $this->assertArrayHasKey( 'dashboard', $scripts );
        $this->assertArrayHasKey( 'block-script', $scripts );
        // Further assertions to check the structure of the returned scripts array
    }

    /**
     * Here you can test register_styles and register_scripts methods indirectly.
     * Since wp_register_style and wp_register_script are WordPress functions,
     * you can't directly test them here. You can mock these functions or test
     * the outcome of these methods if it's affecting any WordPress global variables or states.
     */

    protected function tearDown(): void {
        parent::tearDown();
        unset( $this->assets );
    }
}
