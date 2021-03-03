<?php
namespace LuK3zz\score\Database;

use LuK3zz\score\Application;
use LuK3zz\score\Model;

abstract class DatabaseModel extends Model {
    /**
     * @param array<int|string, string> $columns
     *
     * @return Statement\Select
     */
    public function select(array $columns = ['*']): Statement\Select
    {
        return new Statement\Select(Application::$database, $columns);
    }

    /**
     * @param array<int|string, mixed> $pairs
     *
     * @return Statement\Insert
     */
    public function insert(array $pairs = [])//: Statement\Insert
    {

        return $this->attributes();
        //return new Statement\Insert(Application::$database, $pairs);
    }

    /**
     * @param array<string, mixed> $pairs
     *
     * @return Statement\Update
     */
    public function update(array $pairs = []): Statement\Update
    {
        return new Statement\Update(Application::$database, $pairs);
    }

    /**
     * @param string|array<string, string> $table
     *
     * @return Statement\Delete
     */
    public function delete($table = null): Statement\Delete
    {
        return new Statement\Delete(Application::$database, $table);
    }
}
