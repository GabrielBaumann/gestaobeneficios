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
            ->order("month_recharge")
            ->fetch(true);  
        return $monthArray ?? [];
    }

    // Retonra dados da pesquisa do formulário de recarga
    public function searchRecharg(array $data) : array
    {
        var_dump($data); 
        
        //Índices dos pagamento
        // 1 - Pagos
        // 2 - Recargas Agendadas
        // 3 - À Pagar 

        $year = isset($data["yearSearche"]) ? $data["yearSearche"] : date("Y");
        $month = isset($data["monthSearch"]) ? $data["monthSearch"] : null;
        $recipient = isset($data["recipientname"]) ? $data["recipientname"] : null;
        $shipment = isset($data["shipment"]) ? $data["shipment"] : null;
        $typepaymentsearch = isset($data["typePaymentSearch"]) ? $data["typePaymentSearch"] : null;

        $conditions = [];
        $params = [];

        //Verificar o tipo de pagamento pagos - recargas agendads - à pagar

            if($typepaymentsearch == 1 || $typepaymentsearch == 3) {
                $type = ($typepaymentsearch == 3) ? "solicitado" : "credito liberado" ;
                $conditions[] = "status_recharge = :ty";
                $params["ty"] = $type;

            } else if ($typepaymentsearch == 2) {
                $month = date("m");

                $conditions[] = "month_recharge = :mo";
                $params["mo"] = $month;
            }

        if(!empty($year)) {
            $conditions[] = "year_recharge = :ye";
            $params["ye"] = $year;
        }

        if(!empty($month)) {
            $conditions[] = "month_recharge = :mo";
            $params["mo"] = $month;
        }

        if(!empty($recipient)) {
            $conditions[] = "(name_benefit LIKE :na OR cpf LIKE :na)";
            $params["na"] = "%{$recipient}%";
        }

        if(!empty($shipment)) {
            $conditions[] = "shipment = :sh";
            $params["sh"] = $shipment;
        }

        $conditions[] = "id_card_recharge_fixed <> :idf";
        $params["idf"] = 0;

        $where = implode(" AND ", $conditions);

        $resultSearch = (new static())->find($where, http_build_query($params))->fetch(true) ?? [];

        return $resultSearch;
    }

}
