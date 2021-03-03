<?php
namespace LuK3zz\score\Database;

use PDO;

class Database extends PDO
{
    /**
     * @param string            $dsn
     * @param string|null       $username
     * @param string|null       $password
     * @param array<int, mixed> $options
     *
     * @codeCoverageIgnore
     */
    public function __construct(string $dsn, ?string $username = null, ?string $password = null, array $options = [])
    {
        parent::__construct($dsn, $username, $password, $options + $this->getDefaultOptions());
    }

    /**
     * @codeCoverageIgnore
     *
     * @return array<int, mixed>
     */
    protected function getDefaultOptions(): array
    {
        return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    /**
     * @param Clause\Method|null $procedure
     *
     * @return Statement\Call
     */
    public function call(Clause\Method $procedure = null): Statement\Call
    {
        return new Statement\Call($this, $procedure);
    }
}
