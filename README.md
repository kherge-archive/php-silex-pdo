PDO Service Provider
====================

[![Build Status]](https://travis-ci.org/herrera-io/php-silex-pdo)

A simple PDO service provider.

Summary
-------

A stupid simple PDO service provider. I cannot get any more clear than this.

Installation
------------

Add it to your list of Composer dependencies:

```sh
$ composer require "herrera-io/silex-pdo=1.*"
```

Usage
-----

```php
<?php

use Herrera\Pdo\PdoServiceProvider;
use Silex\Application;

$app = new Application();
$app->register(
    new PdoServiceProvider(),
    array(
        'pdo.dsn' => 'pdo_mysql:dbname=test;host=127.0.0.1',
        'pdo.username' => 'username',
        'pdo.password' => 'password',
        'pdo.options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        )
    )
);

use Herrera\Cli\Application;

$app = new Application('MyApp', '1.2.3');

$app->add('myCommand', function ($input, $output) use ($app) {
    $output->writeln('Hello, ' . $input->getArgument('name') . '!');

    return 123;
})->addArgument('name');

$app->run();
```

Running it:

```sh
$ php myApp.php myCommand Guest
Hello, Guest!
```

[Build Status]: https://travis-ci.org/herrera-io/php-silex-pdo.png?branch=master
