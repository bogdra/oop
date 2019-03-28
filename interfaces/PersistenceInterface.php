<?php

namespace App\Interfaces;

/**
 * Interface PersistenceInterface
 */
interface PersistenceInterface extends \Countable
{
    public function read();
    public function insert();
    public function delete();
    public function update();

}