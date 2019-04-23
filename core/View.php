<?php

namespace Core;

use App\Exception\ViewException;

class View
{
    protected $viewsPath;
    protected $title;
    public $params;


    public function __construct()
    {
        $this->viewsPath = ROOT . DS . 'app' . DS . 'views';
        $this->title = SITE_TITLE;
    }

    public function render(string $view, $params = [])
    {
        $this->params = $params;

        list($controller, $action) = explode('/', $view);
        $viewPath = $this->viewsPath . DS . $controller . DS . $action . '.php';

        if (!file_exists($viewPath)) {
            throw new ViewException("The view $view does not exists");
        }
        include $viewPath;
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
        $partialFullPath = $this->viewsPath . DS . 'partials' . DS . $partialName . '.php';

        if (!file_exists($partialFullPath)) {
            throw new ViewException("The partial html file,$partialFullPath does not exists");
        }
        include($partialFullPath);
    }
}
