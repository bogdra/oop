<?php
namespace App\Controller;

use App\Interfaces\ControllerInterface;

class RestrictedController implements ControllerInterface
{
    public function indexAction()
    {
        echo 'Restricted Area';
    }
}