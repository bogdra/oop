<?php

namespace App\Interfaces;

/**
 * Interface RepositoryInterface
 */
interface RepositoryInterface extends \Countable, \Iterator
{
    public function read();
    public function insert();
    public function delete();
    public function update();

}