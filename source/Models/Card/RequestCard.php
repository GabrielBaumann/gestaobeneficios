<?php

namespace Source\Models\Card;

use Source\Core\Model;

class RequestCard extends Model
{
    public function __construct()
    {
        parent::__construct("card_request",[],[], "id_card_request");
    }

    public function newCard(array $data) : bool   
    {

        if($data["month-start"] > $data["month-end"]) {
            $this->message->warning("O Mês de início não pode ser maior que o mês de fim!");
            return false;  
        }

        $this->message->success("ok");
        return true;

    }

}
