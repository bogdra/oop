<?php
namespace App\Core;

use mysql_xdevapi\Exception;

class View
{
    protected   $viewsPath;
    protected   $title;
    public      $params;


    public function __construct()
    {
        $this->viewsPath = ROOT. DS. 'app'. DS. 'views';
        $this->title = SITE_TITLE;
    }

    public function render(string $view, $params = [] )
    {
        $this->params = $params;

        list($controller, $action) = explode('/', $view);
        $viewPath = $this->viewsPath. DS. $controller. DS. $action. '.php';

        (file_exists($viewPath)) ? include $viewPath : die("The view $view does not exists");
    }

    public function setTitle(string $title) :void
    {
       $this->title = $title;
    }

    public function getTitle() :string
    {
        return $this->title;
    }

    public function getPartial(string $partialName) :void
    {
        $partialFullPath = $this->viewsPath. DS. 'partials'. DS. $partialName. '.php';

        try
        {
            if (!file_exists($partialFullPath))
            {
                throw new \Exception("The partial html file,$partialFullPath does not exists");
            }
            else
            {
                include($partialFullPath);
            }
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
