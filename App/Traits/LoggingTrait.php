<?php


namespace App\Traits;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;


trait LoggingTrait
{
    /** @var Logger $logger */
    protected $logger;


    private function getLogger(string $type )
    {
        if (!$this->logger) {
            $this->logger = new Logger($type);
            $this->logger->pushHandler(new StreamHandler(dirname(__DIR__) . '/../logs/logs.log', Logger::DEBUG));
        }
        return $this->logger;
    }

    public function critical(string $message)
    {
        return $this->getLogger('default')->warning($message);
    }

    public function warning(string $message)
    {
        return $this->getLogger('default')->warning($message);
    }

    public function alert(string $message)
    {

        return $this->getLogger('default')->warning($message);
    }

    public function emergency(string $message)
    {
        return $this->getLogger('default')->warning($message);
    }

}