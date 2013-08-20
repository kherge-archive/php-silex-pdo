<?php

namespace Herrera\Pdo\Test;

use Herrera\Pdo\PdoTrait;
use Silex\Application as Silex;

class Application extends Silex
{
    use PdoTrait;
}
