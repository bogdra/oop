<?php
namespace App\Core;

class View
{
    protected   $viewsPath = ROOT. DS. 'app'. DS. 'views',
                $siteTitle = SITE_TITLE,
                $params;

    public function render(string $view, $params = [] )
    {
        $this->params = $params;

        list($controller, $action) = explode('/', $view);
        $viewPath = $this->viewsPath. DS. $controller. DS. $action. '.php';

        (file_exists($viewPath)) ? include $viewPath : die("The view $view does not exists");

    }

    public function getSiteTitle() :string
    {
        echo 'Exercitiu Leu';
    }

    public function getPartial(string $partialName)
    {
        $partialFullPath = $this->viewsPath. DS. 'partials'. DS. $partialName. '.php';

        if (file_exists($partialFullPath)) {
            include($partialFullPath);
        }

    }
}