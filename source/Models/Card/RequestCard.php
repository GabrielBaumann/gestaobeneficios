<?php

namespace Source\Models\Card;

use Source\App\CardRequest;
use Source\Core\Model;
use Source\Models\Card\Views\Vw_card;
use Source\Models\UserSystem\UnitUserSystem;

class RequestCard extends Model
{
    public function __construct()
    {
        parent::__construct("card_request",[],[], "id_card_request");
    }

    // Novo Cartão e segunda via de cartão = true segunda via, false novo cartão
    public function newCard(array $data, bool $type = false) : bool   
    {   

        // Verifica os números dos meses são válidos
        if(!is_int($data["month-start"]) && $data["month-start"] < 0 || !is_int($data["month-end"]) && $data["month-end"] < 0) {
            $this->message->warning("Os números de meses não são válidos!");
            return false;  
        }

        // Verificar se o mês de início é maior que o mês de fim
        if($data["month-start"] > $data["month-end"]) {
            $this->message->warning("O Mês de início não pode ser maior que o mês de fim!");
            return false;  
        }

        // Nova Cartão ou Segunda Via
        $type ? $type = "novo cartão" : $type = "segunda via";

        // Buscar coordenador baseado no id do tecnico
        $unitUserSystem = new UnitUserSystem();
        $idunitCoordinator = $unitUserSystem->findById($data["technician"]);
        $idCoordinator = $unitUserSystem->activeCoordinator($idunitCoordinator->id_unit);

        // Criar solicitação
        $request = new static();
        $request->id_person_benefit = $data["person-benefit"];
        $request->id_unit_server = $data["technician"];
        $request->id_unit_coordinator = $idCoordinator;
        $request->type_request = $type;
        $request->status_request = "solicitado";
        $request->date_request = $data["date-request"];
        $request->id_user_system_register = 1;

        $request->save();

        // // Cria cartão e retorna o id do cartão
        $addCard = (new Card())->dataCard($request->id_card_request);

        // Criar quantidade de recargas
        $addCardRecharge = (new CardRecharge())->addRecharge($addCard, $request->id_card_request, $data);

        $this->message->success("ok");
        return true;

    }

    // Cartão emergencial
    public function requestEmergency(array $data) : int
    {
        // Buscar coordenador baseado no id do tecnico
        $unitUserSystem = new UnitUserSystem();
        $idunitCoordinator = $unitUserSystem->findById($data["technician"]);
        $idCoordinator = $unitUserSystem->activeCoordinator($idunitCoordinator->id_unit);

        // Criar solicitação
        $request = new static();
        $request->id_person_benefit = $data["person-benefit"];
        $request->id_unit_server = $data["technician"];
        $request->id_unit_coordinator = $idCoordinator;
        $request->type_request = "emergencial";
        $request->status_request = "solicitado";
        $request->date_request = $data["date-request"];
        $request->id_user_system_register = 1;
        
        $request->save();

        // // Cria cartão e retorna o id do cartão
        $addCard = (new Card())->dataCard($request->id_card_request);

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

        $this->message->success("ok");
        return $request->id_card_request;
        
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

}
