<?php

namespace Source\Models\Card;

use Source\Core\Model;
use Source\Models\Card\CardValue;

class Card extends Model
{
    public function __construct()
    {
        parent::__construct("card",[],[], "id_card");
    }

    public function dataCard(int $id_resquest) : int
    {       
        $idValue = (new CardValue())->valueCard();
        $card = new static;

        $card->id_card_request = $id_resquest;
        $card->id_card_value = $idValue;
        $card->id_user_system_register = 1;

        $card->save();
        return $card->id_card;
    }

}
