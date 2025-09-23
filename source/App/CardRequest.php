<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\Card\Card;
use Source\Models\Card\RequestCard;

class CardRequest extends Controller
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

    public function formCardRequest(?array $data) : void
    {   
        if (isset($data["person-benefit"]) && !empty($data["person-benefit"])) {
            
            $requestCard = new RequestCard();
            $reponse = $requestCard->newCard($data);

            if(!$reponse) {
                $json["message"] = $requestCard->message()->render();
            }

            echo json_encode($json);
            return;
        }

        echo $this->view->render("/cardrequest/formcardrequest", [
            "title" => "Formulário de Cartão"
        ]);    
    }

}
