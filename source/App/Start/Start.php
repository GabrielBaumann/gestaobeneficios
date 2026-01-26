<?php

namespace Source\App\Start;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Models\UserSystem\Auth;

class Start extends Controller
{
    private $user;

    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");
        // (new Session())->set("authUser", 1);
        if (!$this->user = Auth::user()) {
            $this->message->warning("Efetue login para acessar o sistema.")->flash();
            redirect("/");
        }        
    }

    public function startPage() : void
    {
        echo $this->view->render("/start/start", [
            "usersystem" => userUnit(),
        ]); 
    }

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}