<?php

namespace Source\App\Card;

use Source\Core\Controller;
use Source\Models\Card\Card;
use Source\Models\Card\CardBalance;
use Source\Models\Card\CardCanceled;
use Source\Models\Card\CardRecharge;
use Source\Models\Card\RequestCard;
use Source\Models\Card\Views\Vw_benefit_card;
use Source\Models\Card\Views\Vw_benefit_to_card;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\Views\Vw_card_canceled;
use Source\Models\Card\Views\Vw_recharge;
use Source\Models\Card\Views\Vw_request;
use Source\Models\Office;
use Source\Models\PersonBenefit;
use Source\Models\UserSystem\UnitUserSystem;


class CardPersonSearch extends Controller
{
    private $user;

    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");
        
        // if (!$this->user = Auth::user()) {
        //     $this->message->warning("Efetue login para acessar o sistema.")->flash();
        //     redirect("/");
        // }        
    }

 
    // Procurar recargas
    public function searchRecharge(array $data) : void
    {
        // Verifica se os campos de pesquisa estão vazios
        $dataEmptyInput = count(cleanInputData($data)["errors"]);
        $allInput = count($data);
        
        if($dataEmptyInput === $allInput) {
            $json["message"] = messageHelpers()->warning("Digite um nome ou CPF para pesquisar!")->render();
            echo json_encode($json);
            return;
        }

        if(isset($data["clean"]) && !empty($data["clean"])) {

            $month = (int)date("m");
            $year = (int)date("Y");

            $searchRecharg = (new Vw_recharge())->find("status_recharge = :st 
                    AND year_recharge = :ye 
                    AND month_recharge = :mo", 
                    "st=solicitado&ye={$year}&mo={$month}")
            ->fetch(true);
        } else {

            // Fazer a pesquisa e devolve os valores
            $searchRecharg = (new Vw_recharge())->searchRecharg(cleanInputData($data)["data"]);
            
            if(!$searchRecharg) {
                $json["message"] = messageHelpers()->warning("Não há dados para essa pesquisa!")->render();
                echo json_encode($json);
                return;            
            }
        }

        $html = $this->view->render("/card/listRecharge", [
            "listRecharge" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);
    }

    // Procura solicitados
    public function searchRequest(array $data) : void
    {        
        if(isset($data["clean"]) && !empty($data["clean"])) {
            $searchRecharg = (new Vw_card())->find("status_request = :st 
                    AND status_card = :stc 
                    AND received = :re", 
                    "st=solicitado&stc=aguardando cartão&re=não")
                ->fetch(true);
        } else {
            // Verifica se os campos de pesquisa estão vazios
            $dataEmptyInput = count(cleanInputData($data)["errors"]);
            $allInput = count($data);

            if($dataEmptyInput === $allInput) {
                $json["message"] = messageHelpers()->warning("Digite um nome ou CPF para pesquisar!")->render();
                echo json_encode($json);
                return;
            }

            // Fazer a pesquisa e devolve os valores
            $searchRecharg = (new Vw_card())->searchRequest(cleanInputData($data)["data"]);

            if(!$searchRecharg) {
                $json["message"] = messageHelpers()->warning("Não há dados para pesquisa!")->render();
                echo json_encode($json);
                return;            
            }
        }
        $html = $this->view->render("/card/requestCard", [
            "title" => "Solicitação de Cartão",
            "menu" => "solicitacao",
            "monthAll" => fncMonthAll(),
            "listCardName" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);
    }

    // Procurar enviados
    public function searchSend(array $data) : void  
    {
        if(isset($data["clean"]) && !empty($data["clean"])) {
            $searchRecharg = (new Vw_card())->find("status_request = :st 
                    AND status_card = :stc 
                    AND received = :re",
                    "st=concluída&stc=confecção&re=não")
                ->fetch(true);
        } else {
            // Verifica se os campos de pesquisa estão vazios
            $dataEmptyInput = count(cleanInputData($data)["errors"]);
            $allInput = count($data);
            
            if($dataEmptyInput === $allInput) {
                $json["message"] = messageHelpers()->warning("Digite um nome ou CPF para pesquisar!")->render();
                echo json_encode($json);
                return;
            }

            // Fazer a pesquisa e devolve os valores
            $searchRecharg = (new Vw_card())->searchSend(cleanInputData($data)["data"]);

            if(!$searchRecharg) {
                $json["message"] = messageHelpers()->warning("Não há dados para pesquisa!")->render();
                echo json_encode($json);
                return;            
            }
        }
        $html = $this->view->render("/card/sendCard", [
            "title" => "Enviados",
            "menu" => "enviado",
            "listCardName" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);     
    }

    // Procurar Cartões
    public function searchCard(array $data) : void
    {
        // Verifica se os campos de pesquisa estão vazios
        $dataEmptyInput = count(cleanInputData($data)["errors"]);
        $allInput = count($data);
        
        if($dataEmptyInput === $allInput) {
            $json["message"] = messageHelpers()->warning("Digite um nome ou CPF para pesquisar!")->render();
            echo json_encode($json);
            return;
        }

        // Fazer a pesquisa e devolve os valores
        $searchRecharg = (new Vw_benefit_card())->searchCard(cleanInputData($data)["data"]);

        if(!$searchRecharg) {
            $json["message"] = messageHelpers()->warning("Não há dados para pesquisa!")->render();
            echo json_encode($json);
            return;            
        }

        $html = $this->view->render("/card/activeCard", [
            "title" => "Enviados",
            "menu" => "enviado",
            "listCardName" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);
    }

    // Procurar emergenciais
    public function searchEmergency(array $data) : void
    {

        if(isset($data["clean"]) && !empty($data["clean"])) {
            
            $searchRecharg = (new Vw_card())->find("type_request = :id",
                    "id=emergencial")
                ->fetch(true);
        } else {
            // Verifica se os campos de pesquisa estão vazios
            $dataEmptyInput = count(cleanInputData($data)["errors"]);
            $allInput = count($data);
            
            if($dataEmptyInput === $allInput) {
                $json["message"] = messageHelpers()->warning("Digite um nome ou CPF para pesquisar!")->render();
                echo json_encode($json);
                return;
            }

            // Fazer a pesquisa e devolve os valores
            $searchRecharg = (new Vw_card())->searchEmergency(cleanInputData($data)["data"]);
        }

        $html = $this->view->render("/card/listCardEmergency", [
            "menu" => "listacartaoemergencial",
            "title" =>  "Emergencial",
            "listCardName" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);
    }

    // Procurar beneficiário com cartão 
    public function searchBenefit(array $data) : void
    {
        // Verifica se os campos de pesquisa estão vazios
        $dataEmptyInput = count(cleanInputData($data)["errors"]);
        $allInput = count($data);
        
        if($dataEmptyInput === $allInput) {
            $json["message"] = messageHelpers()->warning("Digite um nome ou CPF para pesquisar!")->render();
            echo json_encode($json);
            return;
        }

        if(isset($data["clean"]) && !empty($data["clean"])) {

            $searchRecharg = (new Vw_benefit_to_card())
                ->find()
                ->fetch(true);
        } else {

            // Fazer a pesquisa e devolve os valores
            $searchRecharg = (new Vw_benefit_to_card())->searchBenefit(cleanInputData($data)["data"]);
            
            if(!$searchRecharg) {
                $json["message"] = messageHelpers()->warning("Não há dados para essa pesquisa!")->render();
                echo json_encode($json);
                return;            
            }
        }

        $html = $this->view->render("/card/listBenefit", [
            "menu" => "beneficiario",
            "title" =>  "Beneficiário",
            "listBenefit" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);
    }
   
    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}