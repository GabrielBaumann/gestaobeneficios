<?php

namespace Source\Models\Card;

use Source\App\CardRequest;
use Source\Core\Model;
use Source\Models\Card\Views\Vw_card;

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

        var_dump($type);

        // Criar solicitação
        $this->id_person_benefit = $data["person-benefit"];
        $this->id_unit_server = 2;
        $this->type_request = $type;
        $this->status_request = "Solicitado";
        $this->date_request = "2025/09/09";
        $this->id_user_system_register = 1;

        $this->save();

        // // Cria cartão e retorna o id do cartão
        $addCard = (new Card())->dataCard($this->id_card_request);

        // Criar quantidade de recargas
        $addCardRecharge = (new CardRecharge())->addRecharge($addCard, $this->id_card_request, $data);

        $this->message->success("ok");
        return true;

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
