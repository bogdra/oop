<?php


namespace App\Traits;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;


trait Log
{
    /** @var Logger $logger */
    protected $logger;


    public function __construct(string $type = 'default')
    {
        $this->logger = new Logger($type);
        $this->logger->pushHandler(new StreamHandler(dirname(__DIR__) . '/logs/logs.log', Logger::DEBUG));
        $this->logger->pushHandler(new FirePHPHandler());
    }
}