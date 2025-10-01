<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Models\Auth;
use Source\Models\Card\Card;
use Source\Models\Card\CardValue;
use Source\Models\Card\RequestCard;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\Views\Vw_recharge;
use Source\Models\UserSystem\UnitUserSystem;

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

    // Solicitar um novo cartão ou uma segunda via
    public function formCardRequest(?array $data) : void
    {   
        if (isset($data["csrf"]) && !empty($data["csrf"])) {

            $requestCard = new RequestCard();
            $reponse = $requestCard->newCard($data, true);

            if(!$reponse) {
                $json["message"] = $requestCard->message()->render();
            }

            $json["message"] = $requestCard->message()->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/cardrequest/formcardrequest", [
            "title" => "Formulário de Cartão",
            "listCard" => (new Vw_card())->find()->fetch(true)
        ]);    
    }

    // Excluir a solicitação
    public function deleteRequestCard(?array $data) : void
    {
        if (isset($data["csrf"]) && !empty($data["csrf"])) {

            $requestCard = new RequestCard();
            $reponse = $requestCard->deleteRequestCard($data["id-request"]);

            if(!$reponse) {
                $json["message"] = $requestCard->message()->render();
            }

            $json["message"] = $requestCard->message()->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/cardrequest/formDeleteRequest", [
            "Title" => "Excluir solicitação",
            "listCard" => (new Vw_recharge())->find()->fetch(true)
        ]);
    }

}
