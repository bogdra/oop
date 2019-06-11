<?php

namespace App\Interfaces;

interface PersistenceInterface extends \Countable

{
    public function read(string $table, $params = []);

    public function insert(string $tableName, $params = []);

    public function delete(string $tableName, int $id);

    public function update(string $tableName, int $id, $fields = []);
}
