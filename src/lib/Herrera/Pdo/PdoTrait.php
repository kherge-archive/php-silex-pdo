<?php

namespace Herrera\Pdo;

use PDOStatement;

/**
 * Adds PDO methods to the application.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
trait PdoTrait
{
    /**
     * Creates a new prepared statement.
     *
     * @param string $statement The statement.
     * @param array  $options   The driver options.
     *
     * @return PDOStatement The new statement.
     */
    public function prepare($statement, array $options = array())
    {
        return $this['pdo']->prepare($statement, $options);
    }
}
