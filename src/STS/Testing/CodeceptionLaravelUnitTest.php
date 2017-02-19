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
     * The callbacks that will be run before the application is destroyed.
     *
     * @var array
     */
    protected $beforeApplicationDestroyedCallbacks = [];

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        //application is already created by the Codeception module and that's the one we will use
        //so this is not needed in our case
    }

    /**
     * Setup the test environment. We weed to use the app already initiated by
     * the Codeception module
     *
     * @return void
     */
    public function setUp()
    {
        //Codecetion Module will initiate the app
        parent::setUp();

        //now lets grab the app from Codeception Module
        $laravelCodeceptionModule = $this->getModule('Laravel5');
        $this->app = $laravelCodeceptionModule->getApplication();
    }

    /**
     * Run all callbacks and clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        if ($this->app) {
            foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
                call_user_func($callback);
            }
        }
        // the app is coming from Codeception module, Codeception Module will also flush down the application
        parent::tearDown();
    }

    /**
     * Add a callback to execute just before we flush the application
     *
     * @return void
     */
    protected function beforeApplicationDestroyed(callable $callback)
    {
        $this->beforeApplicationDestroyedCallbacks[] = $callback;
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

        //If all fails Codeception can give us the app root directory
        $rootDir = \Codeception\Configuration::projectDir();
        if(file_exists($rootDir . '/bootstrap/app.php')) {
            return $rootDir;
        }

        // We need to full out exit here, not just throw an exception
        print("Unable to determine your base Laravel path, and didn't find a valid LARAVEL_BASE defined. Please define that in your _bootstrap.php file.");
        exit(1);
    }
}