<?php

namespace Source\Models\Card;

use Source\Core\Model;

class CardRecharge extends Model
{
    public function __construct()
    {
        parent::__construct("card_recharge",[],[], "id_card_recharge");
    }
}
