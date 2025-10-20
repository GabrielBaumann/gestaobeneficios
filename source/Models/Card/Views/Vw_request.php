<?php

namespace Source\Models\Card\Views;

use Source\Core\Model;

class Vw_request extends Model
{
    public function __construct()
    {
        parent::__construct("vw_request",[],[],"id_request");
    }

    // Retorna dados baseado no shipment (remessa de envio para as unidade documento ofício)
    public function dataShipment(int $shipment) : array
    {
        $dataUnit = (new static())->find("shipment = :sh AND location = :lo","sh={$shipment}&lo=unit")->fetch(true);
        $array = [];
        foreach($dataUnit as $dataUnitIn) {

            if (!isset($array[$dataUnitIn->id_unit])) {
                $array[$dataUnitIn->id_unit] = [
                    "unit" => $dataUnitIn->name_unit,
                    "numberOffice" => $dataUnitIn->number_office,
                    "dateFirst" => $dataUnitIn->date_send,
                    "countCard" => 0
                ];
            }
            $array[$dataUnitIn->id_unit]["countCard"]++;
        }

        return $array;
    }

    // Retorna uma lista de pessoas baseado no shipment (remessa de envio para unidade lista em excel)
    public function dataShipmentList(int $shipment) : array
    {
        $dataUnit = (new static())->find("shipment = :sh AND location = :lo","sh={$shipment}&lo=unit")->fetch(true);
        $array = [];
        
        foreach($dataUnit as $dataUnitIn) {
            $array[$dataUnitIn->id_unit][] = $dataUnitIn;
        }

        return $array;
    }

    // Retorna dados baseado no id_office (número de ofício encaminha para empresa de confecção de cartão)
    public function dataOfficeSendCompany(int $idOffice) : array
    {
        $dataUnit = (new static())->find("location = :lo AND office = :of","lo=company&of={$idOffice}")->fetch(true);

        $array = [
            "dataSend" => date_complete_string($dataUnit[0]->date_send),
            "title" =>  "Ofício Encaminhamento - " . format_number($dataUnit[0]->number_office),
            "countCard" => count($dataUnit ?? []),
            "monthDocument" => $dataUnit[0]->month_send_company, 
            "numberOffice" => format_number($dataUnit[0]->number_office), 
            "type" => "sendcompany"
        ];

        return $array;        
    }

    // Retorna lista com id_office (número de ofício encaminha para empresa de confecção de cartão)
    public function dataOfficeSendCompanyList(int $idOffice) : array
    {
        $dataUnit = (new static())->find("location = :lo AND office = :of","lo=company&of={$idOffice}")->fetch(true);
        return $dataUnit;        
    }
}
