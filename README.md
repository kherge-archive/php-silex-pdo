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
        'pdo.username' => 'username', // optional
        'pdo.password' => 'password', // optional
        'pdo.options' => array( // optional
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        )
    )
);

$pdo = $app['pdo'];
```

[Build Status]: https://travis-ci.org/herrera-io/php-silex-pdo.png?branch=master
