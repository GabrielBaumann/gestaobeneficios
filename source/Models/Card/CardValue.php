<?php

namespace Source\Models\Card;

use Source\Core\Model;

class CardValue extends Model
{
    public function __construct()
    {
        parent::__construct("card_value",[],[], "id_card_value");
    }
}
