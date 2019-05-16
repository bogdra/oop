<?php


namespace App\Traits;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;


trait Log
{
    /** @var Logger $logger */
    protected $logger;


    private function getLogger(string $type = 'default')
    {
        if (!$this->logger) {
            $this->logger = new Logger($type);
            $this->logger->pushHandler(new StreamHandler(dirname(__DIR__) . '/../logs/logs.log', Logger::DEBUG));
            $this->logger->pushHandler(new FirePHPHandler());
        }

        return $this->logger;
    }

    public function warning(string $message)
    {
        return $this->getLogger()->warning($message);
    }

}