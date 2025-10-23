<?php

namespace Source\Models\Card\Views;

use Source\Core\Model;

class Vw_recharge extends Model
{
    public function __construct()
    {
        parent::__construct("vw_recharge",[],[],"id_card_recharge");
    }

    // Retorna os anos que tenham recargas feitas
    public function showYearRecharge() : array
    {
        $yearArray = $this->find("id_card_recharge_fixed <> :id AND status_recharge <> :st AND status_recharge <> :cc",
            "id=0&st=aguardando cartão&cc=confecção",
            "DISTINCT year_recharge")
            ->order("year_recharge", "DESC")
            ->fetch(true);
            
        return $yearArray ?? [];
    }

    // Retorna os meses que tenham recarga
    public function showMonthRecharge(): array
    {
        $monthArray = $this->find("id_card_recharge_fixed <> :id AND status_recharge <> :st AND status_recharge <> :cc",
            "id=0&st=aguardando cartão&cc=confecção",
            "DISTINCT month_recharge")
            ->fetch(true);
            
        return $monthArray ?? [];
    }



}
