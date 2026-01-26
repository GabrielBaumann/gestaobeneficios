<?php

namespace Source\App\Web;

use Source\Core\Controller;
use Source\Models\UserSystem\Auth;

class Web extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_THEME . "/");        
    }

    public function login(?array $data) : void
    {
        if(isset($data["csrf"])) {
            
            $userAuth = new Auth();


            if(!$userAuth->login($data["cpfuser"],$data["password"])) {
                $json["message"] = $userAuth->message()->render();
                echo json_encode($json);
                return;
            }

            if($userAuth->user()->status_register === "registrado") {
                // Redirecionar para página de confirmações e mudança de senha do usuário
                
                $json["redirected"] = url("/usuario/confirmarcadastro");
                echo json_encode($json);
                return;
            }
            
            $json["redirected"] = url("/inicio/inicio");
            echo json_encode($json);
            return;
        }


        echo $this->view->render("index", [
    
        ]); 
    }

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}