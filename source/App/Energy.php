<?php

namespace Source\App;

use Source\Core\Controller;


class Energy extends Controller
{
    private $user;

    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_APP . "/");
        
        // if (!$this->user = Auth::user()) {
        //     $this->message->warning("Efetue login para acessar o sistema.")->flash();
        //     redirect("/");
        // }        
    }

    public function startPage() : void
    {
        
        echo $this->view->render("/energy/start", [

        ]); 
    }

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}