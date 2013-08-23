<?php

namespace Herrera\Pdo\Tests;

use Herrera\Pdo\PdoServiceProvider;
use Herrera\PHPUnit\TestCase;
use Monolog\Logger;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;

class PdoServiceProviderTest extends TestCase
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var PdoServiceProvider
     */
    private $provider;

    public function testRegister()
    {
        $this->provider->register($this->app);

        $this->app['pdo.dsn'] = 'sqlite::memory:';

        $this->assertInstanceOf('Closure', $this->app['pdo.factory']);
        $this->assertInstanceOf('PDO', $this->app['pdo']);
        $this->assertSame(
            array(
                'pdo.username' => null,
                'pdo.password' => null,
                'pdo.options' => array()
            ),
            $this->app['pdo.defaults']
        );
    }

    /**
     * @depends testRegister
     */
    public function testPdo()
    {
        $this->provider->register($this->app);

        $_this = $this;

        $this->app['pdo.factory'] = $this->app->protect(
            function ($a, $b, $c, array $d) use ($_this) {
                $_this->assertEquals('a', $a);
                $_this->assertEquals('b', $b);
                $_this->assertEquals('c', $c);
                $_this->assertEquals(array('d'), $d);

                return true;
            }
        );

        $this->app['pdo.defaults'] = array(
            'pdo.dsn' => 'a',
            'pdo.username' => 'b',
            'pdo.password' => 'c',
            'pdo.options' => array('d')
        );

        $this->assertTrue($this->app['pdo']);
    }

    /**
     * @depends testRegister
     */
    public function testPdoDebug()
    {
        $file = $this->createFile();

        $this->app['debug'] = true;
        $this->app->register(
            new MonologServiceProvider(),
            array(
                'monolog.level' => Logger::DEBUG,
                'monolog.logfile' => $file,
            )
        );

        $this->app['pdo.dsn'] = 'sqlite::memory:';

        $this->provider->register($this->app);

        $this->app['pdo']->exec('CREATE TABLE test(id INTEGER PRIMARY KEY)');

        $this->assertContains(
            'CREATE TABLE test(id INTEGER PRIMARY KEY)',
            file_get_contents($file)
        );
    }

    protected function setUp()
    {
        $this->app = new Application();
        $this->provider = new PdoServiceProvider();
    }
}
