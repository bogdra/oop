<?php

namespace App\Services;

class Factory
{
    public function getService(string $serviceName, $serviceParams = [])
    {
        if (!class_exists($serviceName)) {
            throw new \Exception('The service does not exists');
        }

        return
    }
}