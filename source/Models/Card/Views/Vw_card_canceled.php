<?php

namespace Source\Models\Card\Views;

use Source\Core\Model;

class Vw_card_canceled extends Model
{
    public function __construct()
    {
        parent::__construct("vw_card_canceled",[],[],"id_card_request");
    }

}
