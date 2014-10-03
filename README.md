Unit Test class for Codeception and Laravel 5
====================

This class allows you to write [Codeception](http://codeception.com/) unit tests with all the same goodies (helpers, facade mocking, etc) that the [default Laravel testing](http://laravel.com/docs/4.2/testing) provides.

**Wait, _unit_ tests in Codeception? I thought Codeception was for functional and acceptance testing?**

It is. However it can also run [unit tests](http://codeception.com/docs/06-UnitTests) where it "uses PHPUnit as a backend" and adds a few nice helpers.

**Uh, then why not just PHPUnit with the default Laravel setup?**

If you are writing your functional/acceptance tests in Codeception (and I encourage it!) then it might be really nice to be able to run all your tests at once for end-to-end testing. This could make automated testing / CI a bit easier.

Setup
====================

First off add the composer dependency:

    "require-dev": {
        "stechstudio/codeception-laravel-unittest" : "0.1.*"

Then of course update composer:

    composer update

Now when writing your Codeception unit tests, extend `STS\Testing\CodeceptionLaravelUnitTest` instead of `\Codeception\TestCase\Test`:

    use STS\Testing\CodeceptionLaravelUnitTest;

    class MyTest extends CodeceptionLaravelUnitTest {

That's it! Now you can refer to the [Laravel docs](http://laravel.com/docs/4.2/testing) to see the goodies this provides.
