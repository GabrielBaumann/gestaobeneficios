<?php

namespace Source\Models\Card;

use Source\Core\Model;

class CardRecharge extends Model
{
    public function __construct()
    {
        parent::__construct("card_recharge",[],[], "id_card_recharge");
    }

    public function addRecharge(int $idCard, int $idRequestCard, array $data) : bool
    {
        // Registro espelho
        $idFixed = $this->bootstrap($idCard, $idRequestCard, 0, 0, $data);

        // Criar os registros fixos (as recargas de fato)
        for($i = (int)$data["month-start"]; $i <= (int)$data["month-end"];  $i++) {
            $newCardRecharge = new static;
            $newCardRecharge->bootstrap($idCard, $idRequestCard, $i, $idFixed, $data);
        }
        return true;
    }

    public function bootstrap(int $idCard, int $idRequestCard, int $monthRecharge, int $idFifixed,array $data) : int
    {
        $this->id_card_request = $idRequestCard;
        $this->id_card_recharge_fixed = $idFifixed;
        $this->id_card = $idCard;
        $this->month_start = $data["month-start"];
        $this->month_end = $data["month-end"];
        $this->month_recharge = $monthRecharge;
        $this->year_recharge = date('Y');
        $this->id_user_system_register = 1;
        
        $this->save();
        return $this->id_card_recharge;
    }

}
