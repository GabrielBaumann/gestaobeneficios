<?php

namespace Source\Models\Card\Views;

use Source\Core\Model;
use Source\Models\Card\CardRecharge;
use Source\Models\Office;

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

    // Retorna os números de remessa
    public function showShipmentRecharge(): array
    {
        $shipmentArray = $this->find("id_card_recharge_fixed <> :id 
            AND status_recharge <> :st 
            AND status_recharge <> :cc
            AND shipment IS NOT NULL",
            "id=0&st=aguardando cartão&cc=confecção",
            "DISTINCT shipment")
            ->order("shipment")
            ->fetch(true);

        return $shipmentArray ?? [];
    }

    // Retonra dados da pesquisa do formulário de recarga
    public function searchRecharg(array $data) : array
    {       
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

                $conditions[] = "status_recharge = :ty";
                $params["ty"] = "solicitado";
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

    // Liberar crédito das recargas
    public function creditRecharge(array $data) : array
    {
        $numberOffice = (new Office())->lastNumberOffice(1)[0]->id_office;
        $numberShipment = ($this->numberShipment());

        unset($data["btn-send"]);
        
        foreach($data as $item) {
            $recharge = (new CardRecharge())->findById((int)$item);

            $recharge->id_card_recharge = (int)$item;
            $recharge->status_recharge = "credito liberado";
            $recharge->shipment = $numberShipment;
            $recharge->id_office = $numberOffice;
            $recharge->id_user_system_update = 1;
            $recharge->save();
        }

        $return = ["numberShipment" => $numberShipment, "numberOffice" => $numberOffice];
        return $return;
    }

    // Último número de remessa enviado para unidades
    public function numberShipment() : int
    {   
        $year = date("Y");

        $lastNumber = (new static())
            ->find("id_card_recharge_fixed <> :id AND year_recharge = :ye","id=0&ye={$year}")
            ->order("shipment", "DESC")
            ->fetch();
            
        if(!$lastNumber) {
            $number = 1;
        } else {
            $number = $lastNumber->shipment + 1;
        }
        return $number;    
    }

    // Retorna um array com as recargas usando o número de ofício com condição
    public function listRecharge(int $idOffice) : array
    {
        $listRecharge = (new static())
            ->find("id_office = :id","id={$idOffice}")
            ->fetch(true);

        return $listRecharge;
    }

    // Retorna um array com os dados para emissão do ofício
    public function dataOfficeRecharge(int $idOffice) :  array
    {
        $recharge = (new static())
            ->find("id_office = :id","id={$idOffice}")
            ->fetch(true);

        $array = [
            "dataSend" => date_complete_string($recharge[0]->date_update),
            "title" =>  "Ofício Encaminhamento - " . format_number($recharge[0]->number_office),
            "countCard" => count($recharge ?? []),
            "monthDocument" => $recharge[0]->month_recharge, 
            "numberOffice" => format_number($recharge[0]->number_office), 
            "valueCard" => fncstr_price($recharge[0]->value),
            "monthRecharge" => fncMonthString($recharge[0]->month_recharge),
            "unit" => "WEBCARD ADMINISTRATIVO LTDA."
        ];

        return $array;
    }

}
