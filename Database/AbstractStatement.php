<?php
namespace LuK3zz\score\Database;

use PDO;
use PDOException;
use PDOStatement;

abstract class AbstractStatement implements QueryInterface
{
    /** @var PDO $dbh */
    protected $dbh;

    /**
     * @param PDO $dbh
     */
    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @throws PDOException
     *
     * @return mixed
     */
    public function execute(): PDOStatement
    {
        $stmt = $this->dbh->prepare($this->__toString());
        $stmt->execute($this->getValues());

        return $stmt;
    }
}