<?php

namespace \App\Interfaces;

/**
 * Interface RepositoryInterface
 */
interface RepositoryInterface
{
    public function read();
    public function insert();
    public function delete();
    public function update();

}