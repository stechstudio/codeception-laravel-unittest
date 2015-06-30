<?php
namespace STS\Testing;

use Illuminate\Foundation\Testing\ApplicationTrait;
use Illuminate\Foundation\Testing\AssertionsTrait;
use Illuminate\Foundation\Testing\CrawlerTrait;
use Codeception\TestCase\Test;

class CodeceptionLaravelUnitTest extends Test {
    use ApplicationTrait, AssertionsTrait, CrawlerTrait;

	 protected $baseUrl = 'http://localhost';
	 
    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $basePath = $this->findBasePath();
        $app = require $basePath . '/bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
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
        if ($this->app)
        {
            $this->app->flush();
        }

        return parent::tearDown();
    }

    /**
     * Figure out the base Laravel path
     *
     * @return string
     */
    protected function findBasePath()
    {
        // Assuming that tests are running inside a folder called /test/..., and that folder
        // is in the base Laravel folder, this is easy.
        $reflector = new \ReflectionClass(get_called_class());
        $currentPath = $reflector->getFileName();
        $basePath = substr($currentPath,0, strpos($currentPath, "/tests/"));

        if(file_exists($basePath . '/bootstrap/app.php')) {
            return $basePath;
        }

        // We couldn't figure it out automatically, let's look for help
        if(defined('LARAVEL_BASE') && file_exists(LARAVEL_BASE . '/bootstrap/app.php')) {
            return LARAVEL_BASE;
        }

        // We need to full out exit here, not just throw an exception
        print("Unable to determine your base Laravel path, and didn't find a valid LARAVEL_BASE defined. Please define that in your _bootstrap.php file.");
        exit(1);
    }
}
