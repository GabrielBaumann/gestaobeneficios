<?php

namespace Source\Models\Card;

use Source\Core\Model;

class CardNotFound extends Model
{
    public function __construct()
    {
        parent::__construct("card_not_found",[],[], "id_card_not_found");
    }
}
