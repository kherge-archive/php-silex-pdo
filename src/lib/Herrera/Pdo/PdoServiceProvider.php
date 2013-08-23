<?php

namespace Herrera\Pdo;

use PDO;
use Herrera\Pdo\Pdo as PdoLog;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * A simple PDO service provider.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class PdoServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    // @codeCoverageIgnoreStart
    public function boot(Application $app)
    {
    }
    // @codeCoverageIgnoreEnd

    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app['pdo.factory'] = $app->protect(
            function (
                $dsn,
                $username = null,
                $password = null,
                array $options = array()
            ) use ($app) {
                if ($app['debug'] && isset($app['monolog'])) {
                    $pdo = new PdoLog($dsn, $username, $password, $options);

                    $pdo->onLog(
                        function (array $entry) use ($app) {
                            $app['monolog']->addDebug(
                                sprintf(
                                    'PDO query: %s, values :%s',
                                    $entry['query'],
                                    var_export($entry['values'], true)
                                )
                            );
                        }
                    );

                    return $pdo;
                }

                return new PDO($dsn, $username, $password, $options);
            }
        );

        $app['pdo'] = $app->share(
            function (Application $app) {
                foreach ($app['pdo.defaults'] as $name => $value) {
                    if (!isset($app[$name])) {
                        $app[$name] = $value;
                    }
                }

                return $app['pdo.factory'](
                    $app['pdo.dsn'],
                    $app['pdo.username'],
                    $app['pdo.password'],
                    $app['pdo.options']
                );
            }
        );

        $app['pdo.defaults'] = array(
            'pdo.username' => null,
            'pdo.password' => null,
            'pdo.options' => array()
        );
    }
}
