<?php

namespace Source\Models\Card;

use Source\Core\Model;

class CardBalance extends Model
{
    public function __construct()
    {
        parent::__construct("card_balance",[],[], "id_card_balance");
    }
}
