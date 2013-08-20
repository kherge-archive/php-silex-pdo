<?php

namespace Herrera\Pdo\Tests;

use Herrera\Pdo\PdoServiceProvider;
use Herrera\Pdo\Test\Application;
use Herrera\Pdo\Test\Pdo;
use Herrera\PHPUnit\TestCase;

class PdoTraitTest extends TestCase
{
    /**
     * @var Application
     */
    private $app;

    public function testPrepare()
    {
        $a = 'SELECT * FROM CookieMonster';
        $b = array('rand' => rand());

        $this->assertSame(123, $this->app->prepare($a, $b));
    }

    protected function setUp()
    {
        if (!version_compare(PHP_VERSION, '5.4', '>=')) {
            $this->markTestSkipped('PHP 5.4 or greater required.');
        }

        $this->app = new Application();
        $this->app['pdo'] = new Pdo();
    }
}
