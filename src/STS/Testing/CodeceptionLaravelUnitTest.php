<?php
namespace STS\Testing;

use Illuminate\Foundation\Testing\ApplicationTrait;
use Illuminate\Foundation\Testing\AssertionsTrait;

class CodeceptionLaravelUnitTest extends \Codeception\TestCase\Test {
    use ApplicationTrait, AssertionsTrait;

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';

        if(!defined('LARAVEL_BASE')) {
            die("Please define your LARAVEL_BASE path in _bootstrap.php");
        }

        if(!file_exists(LARAVEL_BASE . '/bootstrap/start.php')) {
            die("Can't find bootstrap/start.php. Please check your LARAVEL_BASE path.");
        }

        return require LARAVEL_BASE . '/bootstrap/start.php';
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        if ( ! $this->app)
        {
            $this->refreshApplication();
        }

        return parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->app->flush();
        return parent::tearDown();
    }
}