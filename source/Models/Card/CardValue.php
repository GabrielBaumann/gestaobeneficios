<?php

namespace Source\Models\Card;

use Source\Core\Model;

class CardValue extends Model
{
    public function __construct()
    {
        parent::__construct("card_value",[],[], "id_card_value");
    }

    // Retorna o id do valor atualizado do cartão
    public function valueCard() : int
    {
        $idValueCard = $this->find("status_value = :s","s=ativo")->fetch();
        $idValue = $idValueCard->id_card_value ?? 0;

        return $idValue;
    }
}
