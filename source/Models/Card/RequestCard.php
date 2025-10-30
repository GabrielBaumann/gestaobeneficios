<?php

namespace Source\Models\Card;

use Source\Core\Model;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Office;
use Source\Models\UserSystem\UnitUserSystem;

class RequestCard extends Model
{
    public function __construct()
    {
        parent::__construct("card_request",[],[], "id_card_request");
    }

    // Novo Cartão 
    public function newCard(array $data, bool $type = false) : bool   
    {   
        // Verifica os números dos meses são válidos
        if(!is_int($data["month-start"]) && $data["month-start"] <= 0 || !is_int($data["month-end"]) && $data["month-end"] < 0) {
            $this->message->warning("Os números de meses não são válidos!");
            return false;  
        }

        // Verificar se o mês de início é maior que o mês de fim
        if($data["month-start"] > $data["month-end"]) {
            $this->message->warning("O Mês de início não pode ser maior que o mês de fim!");
            return false;  
        }

        // Buscar coordenador baseado no id do tecnico
        $unitUserSystem = new UnitUserSystem();
        $idunitCoordinator = $unitUserSystem->findById($data["technician"]);
        $idCoordinator = $unitUserSystem->activeCoordinator($idunitCoordinator->id_unit);

        // Criar solicitação
        $request = new static();
        $request->id_person_benefit = $data["person-benefit"];
        $request->id_unit_server = $data["technician"];
        $request->id_unit_coordinator = $idCoordinator;
        $request->type_request = "novo cartão";
        $request->status_request = "solicitado";
        $request->date_request = $data["date-request"];
        $request->id_user_system_register = 1;

        $request->save();

        // // Cria cartão e retorna o id do cartão
        $addCard = (new Card())->dataCard(["idCardRequest" => $request->id_card_request]);

        // Criar quantidade de recargas
        $addCardRecharge = (new CardRecharge())->addRecharge($addCard, $request->id_card_request, $data);

        $this->message->success("Solicitação feita com sucesso!");
        return true;

    }

    // Segunda via de cartão
    public function secondCard(array $data) : bool
    {
        $cardCanceled = (new Vw_card())
            ->find("id_person_benefit = :id AND 
                status_card = :st", 
                "id={$data["person-benefit"]}&st=cancelado")
            ->order("id_card_request", "DESC")
            ->fetch();

        if(!$cardCanceled) {
            $this->message->warning("Erro ao enivar solicitação tente mais tarde!");
            return false;
        }

        // Buscar coordenador baseado no id do tecnico
        $unitUserSystem = new UnitUserSystem();
        $idunitCoordinator = $unitUserSystem->findById($data["technician"]);
        $idCoordinator = $unitUserSystem->activeCoordinator($idunitCoordinator->id_unit);

        // Criar solicitação
        $request = new static();
        $request->id_person_benefit = $data["person-benefit"];
        $request->id_unit_server = $data["technician"];
        $request->id_unit_coordinator = $idCoordinator;
        $request->type_request = "segunda via";
        $request->status_request = "solicitado";
        $request->date_request = $data["date-request"];
        $request->id_user_system_register = 1;

        $request->save();
        
        // Cria cartão e retorna o id do cartão
        $addCard = (new Card())->dataCard(["idCardRequest" => $request->id_card_request]);

        // Seleciona todos as recargas que ainda não foram pagas e clona as recargas para o id da segunda via
        $rechargeUpdate = (new CardRecharge())
            ->find("id_card_request = :id AND 
                id_card_recharge_fixed <> :idf AND
                status_recharge = :st",
                "id={$cardCanceled->id_card_request}&idf=0&st=cancelado ocorrencia")
            ->fetch(true);

        $rechargeFixed = (new CardRecharge());
        $rechargeFixed->id_card_recharge_fixed = 0;
        $rechargeFixed->id_card_request = $request->id_card_request;
        $rechargeFixed->id_card = $addCard;
        $rechargeFixed->month_start = $rechargeUpdate[0]->month_start;
        $rechargeFixed->month_end = $rechargeUpdate[0]->month_end;
        $rechargeFixed->month_recharge = 0;
        $rechargeFixed->year_recharge = $rechargeUpdate[0]->year_recharge;
        $rechargeFixed->id_user_system_register = 1;

        $rechargeFixed->save();

        foreach($rechargeUpdate as $rechargeUpdateItem) {
            $recharge = (new CardRecharge());
            $recharge->id_card_recharge_fixed = $rechargeFixed->id_card_recharge;
            $recharge->id_card_request = $request->id_card_request;
            $recharge->id_card = $addCard;
            $recharge->month_start = $rechargeUpdateItem->month_start;
            $recharge->month_end = $rechargeUpdateItem->month_end;
            $recharge->month_recharge = $rechargeUpdateItem->month_recharge;
            $recharge->year_recharge = $rechargeUpdateItem->year_recharge;
            $recharge->id_user_system_register = 1;
            $recharge->save();
        }

        $this->message->success("Registro salvo com sucesso!");
        return true;
    }

    // Cartão emergencial
    public function requestEmergency(array $data) : array
    {   
        // Buscar coordenador baseado no id do tecnico e a unidade
        $unitUserSystem = new UnitUserSystem();
        $idCoordinator = $unitUserSystem->activeCoordinator($data["technician"]);
        $unitName = $unitUserSystem->unitOfTechnical($data["technician"])->name_full;

        // Número de ofício
        $numberOffice = (new Office())->lastNumberOffice(1)[0];
        $stringOffice = "unit=" . $numberOffice->id_office;

        // Criar solicitação
        $request = new static();
        $request->id_person_benefit = $data["person-benefit"];
        $request->id_unit_server = $data["technician"];
        $request->id_unit_coordinator = $idCoordinator;
        $request->type_request = "emergencial";
        $request->status_request = "concluída";
        $request->date_request = $data["date-request"];
        $request->id_office = $stringOffice;
        $request->id_user_system_register = 1;
        
        $request->save();

        // Cria cartão e retorna o id do cartão
        $addCard = (new Card())->dataCard(["idCardRequest" => $request->id_card_request, "numberCard" => $data["number-card"]], true);

        // Criar quantidade de recargas
        $addCardRecharge = (new CardRecharge());

        // Registro espelho
        $addCardRecharge->id_card_request = $request->id_card_request;
        $addCardRecharge->id_card = $addCard;
        $addCardRecharge->month_start = date("n");
        $addCardRecharge->month_end = date("n");
        $addCardRecharge->month_recharge = 0;
        $addCardRecharge->year_recharge = date("Y");
        $addCardRecharge->status_recharge = "ativo";

        $addCardRecharge->save();

        // Criar os registros fixos (as recargas de fato)
        $addCardRechargeFixed = (new CardRecharge());

        $addCardRechargeFixed->id_card_recharge_fixed = $addCardRecharge->id_card_recharge;
        $addCardRechargeFixed->id_card_request = $request->id_card_request;
        $addCardRechargeFixed->id_card = $addCard;
        $addCardRechargeFixed->month_start = date("n");
        $addCardRechargeFixed->month_end = date("n");
        $addCardRechargeFixed->month_recharge = date("n");
        $addCardRechargeFixed->year_recharge = date("Y");
        $addCardRechargeFixed->status_recharge = "credito liberado";

        $addCardRechargeFixed->save();

        $this->message->success("Solicitação feita com sucesso!");
        $dataAll = ["unit" => $unitName, "officenumber" => $numberOffice->number_office, "idoffice" => $numberOffice->id_office];

        return $dataAll;
    }

    // Exclusão de solicitação de cartão
    public function deleteRequestCard(int $idRequestCard) : bool
    {
        // Verificar o status da solicitação, se for solicitado pode exlcuir se não, não pode excluir
        $requestCard = (new Vw_card())->findById($idRequestCard);

        if(mb_strtolower($requestCard->status_request, 'UTF-8') != "solicitado") {
            $this->message->warning("Impossível excluir essa solicitação, ela já está em tramitação!");
            return false;
        }

        $idDeleteRequest = (new static())->findById($idRequestCard);
        $idDeleteRequest->destroy();
        $idDeleteCard = (new Card())->find("id_card_request = :id","id={$idRequestCard}")->fetch();
        $idDeleteCard->destroy();
        $idDeleteCardRecharge = (new CardRecharge())->delete("id_card_request = :id","id={$idRequestCard}");

        $this->message->success("Registro excluído com sucesso!");
        return true;
    }

    // Verificar se já existe solicitação
    public function checkRequest(array $data) : bool
    {
        // Verificar se já existe pedido de novo cartão ou segunda via de cartão
        $vwCard = (new Vw_card())->find("id_person_benefit = :id AND type_request IN ('novo cartão','segunda via') AND status_card IN ('ativo','confecção','aguardando cartão')", "id={$data["person-benefit"]}")->fetch(true);
        if($vwCard) {
            $this->message->warning("Já existe uma solicitação para esse beneficiário!");
            return false;
        }

        return true;
    }
    
    // Último número de remessa enviado para unidades
    public function lastNumberShipment() : int
    {
        $lastNumber = (new static())->find()->order("shipment", "DESC")->fetch();

        if(!$lastNumber) {
            $number = 1;
        } else {
            $number = $lastNumber->shipment + 1;
        }
        return $number;    
    }
    
}
