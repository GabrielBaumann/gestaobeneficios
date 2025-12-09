<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\Card\CardRecharge;
use Source\Models\Card\RequestCard;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\Views\Vw_recharge;
use Source\Models\PersonBenefit;

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

            // Campo criado no javascript para marcar que é somente para validação dos campos
            if(isset($data["valid"])) {
                $dataClean = cleanInputData($data);
                
                // Campos vazios
                if(!$dataClean["valid"]) {
                    $json["message"] = messageHelpers()->warning("Preeencha todos os campos obrigatórios (*)")->render();
                    echo json_encode($json);
                    return;
                }

                $requestCard = new RequestCard();

                // Verifica se já existe uma solicitação
                if(!$requestCard->checkRequest($data)) {
                    $json["message"] = $requestCard->message()->render();
                    echo json_encode($json);
                    return;
                }

                $cardRecharge = new CardRecharge();
                
                // Verifica as regras de meses
                if(!$cardRecharge->checkRechargeMonth($data)) {
                    $json["message"] = $cardRecharge->message()->render();
                    echo json_encode($json);
                    return;
                }

                $json["status"] = true;
                echo json_encode($json);
                return;  
            }            
            
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
            "personbenefit" => (new PersonBenefit())->find()->fetch(true),
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
