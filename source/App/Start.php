<?php

namespace Source\App;

use Source\Core\Controller;


class Start extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");        
    }

    public function startPage() : void
    {
        echo $this->view->render("/start/start", [

        ]); 
    }

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}