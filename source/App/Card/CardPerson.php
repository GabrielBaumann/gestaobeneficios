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


class CardPerson extends Controller
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

    // Página inicial para o módulo de cartão social
    public function startPage() : void
    {
        echo $this->view->render("/card/start", [
            "title" => "Cartão Alimentação",
            "menu" => "novo"
        ]); 
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

            $json["message"] = $requestCard->message()->flash();
            $json["redirected"] = url("/cartao/solicitarnovocartao");
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/cardrequest/formcardrequest", [
            "title" => "Formulário de Cartão",
            "personbenefit" => (new PersonBenefit())->find()->fetch(true),
            "listCard" => (new Vw_card())->find()->fetch(true)
        ]);    
    }

    // Seguda via e cartãp
    public function secondCard(array $data) : void 
    {
        if(isset($data["person-benefit"])) {
            $secundCard = new RequestCard();
            $secundCard->secondCard($data);

            if(!$secundCard) {
                $json["message"] = $secundCard->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $secundCard->message()->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Solicitar 2ª Via",
            "menu" => "segundavia",
            "personbenefit" => (new Vw_card_canceled())->find()->order("name_benefit")->limit(5000)->fetch(true)
        ]);
    }

    // Recarga
    public function recharge(?array $data) : void 
    {
        if(isset($data["csrf"])) {

            // Verificação de campos obrigatórios
            if(isset($data["valid"])) {
                $json["status"] = true;
                echo json_encode($json);
                return;  
            }

            // Creditar valores da recarga do mês e retorna o número da remessa de envio
            $creditRecharge = (new Vw_recharge())->creditRecharge($data);
            $numberOffice = $creditRecharge["numberOffice"];

            $json["redirectedBlank"] = url("/documentocartao/documento/$numberOffice/sendcompanyrecharge");
            $json["redirected"] = url("/documentocartao/baixarexcelerecarga/$numberOffice");
        
            echo json_encode($json);         
            return;
        }

        $month = date("m");
        $year = date("Y");

        echo $this->view->render("/card/start", [
            "title" => "Recarga",
            "menu" => "recarga",
            "listRecharge" => (new Vw_recharge())
                ->find(
                    "id_card_recharge_fixed <> :id
                    AND year_recharge = ". $year ."
                    AND month_recharge = ". $month ."
                    AND status_recharge = :st", 
                    "id=0&st=solicitado")
                ->fetch(true),
            "yearRecharge" => (new Vw_recharge())
                ->showYearRecharge(),
            "monthRecharge" => (new Vw_recharge())
                ->showMonthRecharge(),
            "shipmentRecharge" => (new Vw_recharge())
                ->showShipmentRecharge()
        ]);
    }

    // Gerar recarga
    public function generateRecharge(array $data) :  void
    {
        // Creditar valores da recarga do mês e retorna o número da remessa de envio
        $creditRecharge = (new Vw_recharge())->creditRecharge($data);
        $numberOffice = $creditRecharge["numberOffice"];

        $html = $this->view->render("/card/listRecharge",[
            "listRecharge" => (new Vw_recharge())
                ->find("id_card_recharge_fixed <> :id", "id=0")
                ->fetch(true)
        ]);

        $json["html"] = $html;
        $json["contentajax"] = "ajax-update";
        $json["redirectedBlank"] = url("/documento/$numberOffice/sendcompanyrecharge");
        $json["redirected"] = url("/baixarexcelerecarga/$numberOffice");
    
        echo json_encode($json);           
        return;
    }

    // Atualizar saldo 
    public function balanceUpdate(?array $data): void
    {

        echo $this->view->render("/card/start", [
            "title" => "Atualizar Saldo",
            "menu" => "saldo",
            "listBalance" => false
        ]);
    }


    // Recarga extra
    public function rechargeExtra(?array $data) : void 
    {

        if (isset($data["person-benefit"]) && !empty($data["person-benefit"])) {
            // var_dump($data);

            $rechargeExtra = (new CardRecharge())->addRechargeExtra($data);


            $json["message"] = messageHelpers()->warning("teste")->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Recarga Extra",
            "menu" => "recargaextra",
            "personbenefit" => (new Vw_card())
                ->find("status_card = :st AND type_request <> :ty", "st=ativo&ty=emergencial")
                ->fetch(true),
            "technicalUnit" => (new UnitUserSystem())->listTechnicalUnit()
        ]);
    }

    // Recarregar cartão
    public function rechargCard(?array $data) : void
    {
        if(isset($data["person-benefit"])) {
            $recharg = (new CardRecharge());

            $response = $recharg->checkRecharge($data);

            if(!$response) {
                $json["message"] = $recharg->message()->render();
                echo json_encode($json);    
                return;
            }

            $json["message"] = $recharg->message()->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Recarga Cartão",
            "menu" => "recargageral",
            "personbenefit" => (new Vw_card())
                ->find("status_card = :st AND type_request <> :ty", "st=ativo&ty=emergencial")
                ->fetch(true),
            "technicalUnit" => (new UnitUserSystem())->listTechnicalUnit()
        ]);
    }

    // Página de solicitação de novo cartão
    public function newCard() : void
    {
        echo $this->view->render("/card/start", [
            "menu" => "novocartao",
            "personbenefit" => (new PersonBenefit())
                ->find()
                ->order("name_benefit")
                ->limit(5000)
                ->fetch(true)
        ]); 
    }

    // Página de cartões solicitados
    public function requestCard(?array $data) : void
    {  
        if(isset($data["csrf"])) {
            
            // Campo criado no javascript para marcar que é somente para validação dos campos
            if(isset($data["valid"])) {
                $dataClean = cleanInputData($data);

                if(!$dataClean["valid"]) {
                    $json["message"] = messageHelpers()->warning("Selecione um mês!")->render();
                    echo json_encode($json);
                    return;
                }

                $json["status"] = true;
                echo json_encode($json);
                return;  
            }

            // if(empty($datall["date-month"])) {
            //     $json["message"] = messageHelpers()->warning("Selecione um mês!")->render();
            //     echo json_encode($json);
            //     return;
            // }

            // if(isset($datall["btn-send"])) {
            //     $month = $_SESSION["month"] = $datall["date-month"];
            // } else {
            //     $month = $_SESSION["month"];
            // }

            // $newSendCard = new Card(); 
            // if(!$newSendCard->checkListCardRequest()) {
            //     $json["message"] = messageHelpers()->warning("Erro!")->render();
            //     echo json_encode($json);
            //     return;
            // }

            // Modal quest
            // if(isset($data["btn-send"])) {
            //     $url = url("/solicitado");
            //     $this->modalQuest($url);
            //     return;
            // }

            // Sessão que recebe os dados para ofício
            $numberOffice = (new Office())->lastNumberOffice(1)[0];
            $newSendCard = (new Card())->sendCardCompany($numberOffice->id_office, $data["date-month"]);

            $html = $this->view->render("/card/requestCard", [
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND
                    status_card = :stc AND
                    received = :re", 
                    "st=solicitado&
                    stc=aguardando cartão&
                    re=não")
                ->fetch(true)
            ]);  
            
            $json["redirectedBlank"] = url("/documentocartao/documento/$numberOffice->id_office/sendcompany");
            $json["redirected"] = url("/documentocartao/baixarexcelempresa/$numberOffice->id_office");
            $json["contentajax"] = "content-ajax";
            $json["html"] = $html;
            $json["message"] = messageHelpers()->success("Lista gerada com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Solicitação de Cartão",
            "menu" => "solicitacao",
            "monthAll" => fncMonthAll(),
            "listCardName" => (new Vw_card())
                ->find("status_request = :st 
                    AND status_card = :stc 
                    AND received = :re", 
                    "st=solicitado&stc=aguardando cartão&re=não")
                ->fetch(true)
        ]);            
    }

    // Pagina com lista de enviados para a confecção
    public function sendCard(?array $data) : void
    {   
        
        if(isset($data["csrf"])) {

            // Campo criado no javascript para marcar que é somente para validação dos campos
            if(isset($data["valid"])) {

                if(!isset($data["received"])) {
                    $json["message"] = messageHelpers()->warning("Não há dados marcados!")->render();
                    echo json_encode($json);
                    return; 
                } 

                $json["status"] = true;
                echo json_encode($json);
                return;  
            }

            // if(isset($datall["btn-send"])) {
            //     $data = $_SESSION["data"] = $datall;
            // } else {
            //     $data = $_SESSION["data"];
            // }

            // if(!isset($data["received"])) {
            //     $json["message"] = messageHelpers()->warning("Não há dados marcados!")->render();
            //     echo json_encode($json);
            //     return; 
            // } 

            // Modal quest
            // if(isset($datall["btn-send"])) {
            //     $url = url("/enviado");
            //     $this->modalQuest($url);
            //     return;
            // }

            // Dá baixa nos cartões para ficarem como enviados as unidades
            $newSendCard = (new Card())->sendCardUnit($data);

            // Último número de remessa enviada
            $shipment = (new RequestCard())->lastNumberShipment();

            // Agrupa as solicitações por unidade e Emitir ofício e planilha excel
            $vwCard = (new Vw_card())->issueDocuments($data, $shipment);

            unset($_SESSION["data"]);

            $html = $this->view->render("/card/sendCard", [
                "menu" => "enviado",
                "listCardName" => (new Vw_card())
                    ->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=confecção&re=não")
                    ->fetch(true)
            ]); 

            $json["html"] = $html;
            $json["contentajax"] = "content-ajax";
            $json["redirectedBlank"] = url("/documentocartao/documentounidade/$shipment");
            $json["redirected"] = url("/documentocartao/baixarexcelunidade/$shipment");
            echo json_encode($json);           
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Enviados",
            "menu" => "enviado",
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=confecção&re=não")
                ->fetch(true)
        ]);             
    }

    // Exluir solicitação de cartão
    public function deleteRequestCard(array $data) : void
    {
        // Campo criado no javascript para marcar que é somente para validação dos campos
        if(isset($data["valid"])) {
            $json["status"] = true;
            echo json_encode($json);
            return;  
        }

        $idcard = (int)$data["id-request"];

        // Excluir solicitação de cartão previsão de recarga
        $deleCard = new RequestCard();
        $response = $deleCard->deleteRequestCard($idcard);

        if(!$response) {
            $json["message"] = $deleCard->message()->render();
            echo json_encode($json);
            return;
        }

        $json["message"] = $deleCard->message()->flash();
        $json["redirected"] = url("/cartao/solicitado");
        echo json_encode($json);
    }

    // Cartões ativos
    public function cardActive() : void
    {
        echo $this->view->render("/card/start", [
            "title" => "Cartão Ativo",
            "menu" => "cartao",
            "listCardName" => (new Vw_benefit_card())
                ->find()
                ->fetch(true)
        ]);           
    }

    // Beneficiário
    public function benefit() : void
    {

        echo $this->view->render("/card/start", [
            "title" => "Beneficiário do Cartão",
            "menu" => "beneficiario",
            "listBenefit" => (new Vw_benefit_to_card())
                ->find()
                ->fetch(true),
            "yearRecharge" => (new Vw_recharge())
                ->showYearRecharge(),
            "monthRecharge" => (new Vw_recharge())
                ->showMonthRecharge(),
            "shipmentRecharge" => (new Vw_recharge())
                ->showShipmentRecharge()
        ]);        
    }

    // Cancelar cartão
    public function cardCancel(?array $data) : void 
    {
        if(isset($data["csrf"])) {
        
            // Campo criado no javascript para marcar que é somente para validação dos campos
            if(isset($data["valid"])) {

                if(!$data["reason-canceled"]) {
                    $json["message"] = messageHelpers()->warning("Preencha todos os campos obrigatòrio (*)")->render();
                    echo json_encode($json);
                    return;
                }

                $json["status"] = true;
                echo json_encode($json);
                return;  
            }

            $cardCanele = (new CardCanceled());

            if(!$cardCanele->cardCancel($data)) {
                $json["message"] = $cardCanele->message()->render();
                return;
            }

            $json["message"] = messageHelpers()->success("Registro cancelado com sucesso!")->flash();

            if(isset($data["id-card-canceled"]) && !empty($data["id-card-canceled"])) {
                $json["message"] = messageHelpers()->success("Registro atualizado com sucesso!")->flash();
            }
            
            $idBenfiti = (int)fncDecrypt($data["id-person-benefit"]);           
            $json["redirected"] = url("/cartao/cardsbeneficiario" . "/" . fncEncrypt($idBenfiti));
            echo json_encode($json);
            return;
        }

        $idCard = (int)fncDecrypt($data["idcard"]);
        $html = $this->view->render("/modal/modalCardCancel", [
            "card" => (new Vw_card())
                ->find("id_card = :id", "id={$idCard}")
                ->fetch() ?? null
        ]);
              
        // Apenas para renderizar modal
        $json["html"] = $html;
        $json["idmodal"] = "modalCardCancel";
        echo json_encode($json);
        return;

    }

    // Editar cancelamento de cartão
    public function editModalCanceledCard(array $data) : void
    {
        $idCard = (int)fncDecrypt($data["idCard"]);
        $html = $this->view->render("/modal/modalCardCancel", [
            "edit" => true,
            "card" => (new Vw_card())
                ->find("id_card = :id", "id={$idCard}")
                ->fetch() ?? null,
            "data" => (new CardCanceled())
                ->find("id_card = :id", "id={$idCard}")
                ->fetch()
        ]);
              
        // Apenas para renderizar modal
        $json["html"] = $html;
        $json["idmodal"] = "modalCardCancel";
        echo json_encode($json);
        return;
    }

    // Solicitar cartão emergencial
    public function requestEmergency(?array $data) : void
    {

        if (isset($data["csrf"])) {
            
            // Campo criado no javascript para marcar que é somente para validação dos campos
            if(isset($data["valid"])) {
                $dataClean = cleanInputData($data);

                if(!$dataClean["valid"]) {
                    $json["message"] = messageHelpers()->warning("Preeencha todos os campos obrigatórios (*)")->render();
                    echo json_encode($json);
                    return;
                }

                $requestCard = new RequestCard();

                if(!$requestCard->checkRequest($data)) {
                    $json["message"] = $requestCard->message()->render();
                    echo json_encode($json);
                    return;
                }

                $json["status"] = true;
                echo json_encode($json);
                return;  
            }
            
            $newRequestEmergency = new RequestCard();
            $dataRequest = $newRequestEmergency->requestEmergency($data);

            $json["message"] = $newRequestEmergency->message()->render();
            $json["redirectedBlank"] = url("/documentocartao/documento/{$dataRequest["idoffice"]}/emergency");
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "menu" => "emergencial",
            "title" =>  "Emergencial",
            "listEmergency" => (new PersonBenefit())
                ->find()
                ->limit(5000)
                ->order("name_benefit")
                ->fetch(true),
            "listTechnical" => (new UnitUserSystem())->listTechnicalUnit()
        ]);
    }

    // Lista de cartões emergenciais solicitados
    public function listEmergency() : void
    {
        echo $this->view->render("/card/start", [
            "menu" => "listacartaoemergencial",
            "title" =>  "Emergencial",
            "listCardName" => (new Vw_card())
                ->find("type_request = :id",
                    "id=emergencial")
                ->fetch(true)
        ]);        
    }

    // Modal quest
    public function modalQuest(?array $data) : void
    {
        if (isset($data["btn-yes"])) {


            $json["response"] = true;
            echo json_encode($json);
            return;
        }

        $html = $this->view->render("/modal/modalQuest", [
            "title" => $data["title"] ?? "Confirmar Ação",
            "textMessage" => $data["text"]
        ]);

        $json["modal"] = $html;
        echo json_encode($json);
        return;
    }

    // Extrato de recargaas por beneficiário
    public function extractRechargeBenefit(?array $data) : void
    {
        $id = (int)fncDecrypt($data["idBenefiti"]);

        echo $this->view->render("/card/start", [
            "title" => "Extrato de Recargas",
            "menu" => "recargaextrato",
            "recharge" => (new Vw_recharge())
            ->find("id_person_benefit = :id AND id_card_recharge_fixed <> :ca",
                "id={$id}&ca=0")
            ->fetch(true),
            "balance" => (new CardBalance())
                ->find("id_person_benefit = :id", "id={$id}")
                ->fetch()
        ]);

    }

    // Lista de cartões dos beneficiários
    public function cardBenefit(?array $data): void
    {
        $idBenfiti = (int)fncDecrypt($data["idBenefiti"]);

        echo $this->view->render("/card/start", [
            "title" => "Extrato de Recargas",
            "menu" => "cartaobaneficiario",
            "card" => (new Vw_card())
                ->find("id_person_benefit = :id", "id={$idBenfiti}")
                ->fetch(true)
        ]);

    }
    

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}