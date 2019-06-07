<?php

namespace Core;

use App\Exceptions\View\FileNotFoundException;
use App\Traits\LoggingTrait;

class View
{
    use LoggingTrait;

    protected $viewsPath;
    protected $title;
    public $params;


    public function __construct()
    {
        $this->viewsPath = ROOT . DS . 'App' . DS . 'Views';
        $this->title = SITE_TITLE;
    }


    public function render(string $view, $params = [])
    {
        try {
            $this->params = $params;

            list($controller, $action) = explode('/', $view);
            $viewPath = $this->viewsPath . DS . $controller . DS . $action . '.php';

            if (!file_exists($viewPath)) {
                throw new FileNotFoundException("The view $view does not exists");
            } else {
                include_once($viewPath);
            }
        } catch (FileNotFoundException $e) {
            $this->logger->warning($e->getMessage());
            //TODO: kill execution or redirect to specific page
        }
    }


    public function setTitle(string $title)
    {
        $this->title = $title;
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function getPartial(string $partialName)
    {
        try {
            $partialFullPath = $this->viewsPath . DS . 'partials' . DS . $partialName . '.php';

            if (!file_exists($partialFullPath)) {
                throw new FileNotFoundException("The partial html file, $partialFullPath does not exists");
            } else {
                include_once($partialFullPath);
            }
        } catch (FileNotFoundException $e) {
            $this->logger->warning($e->getMessage());
            //TODO: kill execution
        }
    }
}
