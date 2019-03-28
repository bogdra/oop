<?php

namespace App\Interfaces;

interface PersistenceInterface extends \Countable

{
    public function read();
    public function insert();
    public function delete();
    public function update();
}
