<?php

namespace Herrera\Pdo\Test;

class Pdo
{
    public $calls = array();

    public function prepare($a, $b)
    {
        $this->calls[] = array('prepare', $a, $b);

        return 123;
    }
}
