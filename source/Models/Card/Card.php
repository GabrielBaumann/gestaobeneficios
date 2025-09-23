<?php

namespace Source\Models\Card;

use Source\Core\Model;

class Card extends Model
{
    public function __construct()
    {
        parent::__construct("card",[],[], "id_card");
    }
}
