<?php

namespace Source\Models\Card\Views;

use Source\Core\Model;
use Source\Models\Card\Card;
use Source\Models\Office;

class Vw_card extends Model
{
    public function __construct()
    {
        parent::__construct("vw_card",[],[],"id_card_request");
    }

    public function issueDocuments(array $data, int $shipment) : bool
    {

        $vwCard = (new static());
        $arraycard = [];

        // Agrupa os ID por unidades
        foreach ($data["received"] as $idCardHash) {

            $idCard = (int)fncDecrypt($idCardHash);
            $cardAll = $vwCard->find("id_card = :id","id={$idCard}")->fetch();

            $unidade = $cardAll->id_unit;

            if ($unidade) {
                if (!isset($arraycard[$unidade])) {
                    $arraycard[$unidade] = [];
                }
            }
            $arraycard[$unidade][] = $cardAll; 
        }

        // Baseado no agrupamento por unidades salva os ofícios
        $lastKey = null;
        foreach($arraycard as $key => $values) {

            foreach($values as $item) {
                if($lastKey !== $item->id_unit) {
                    
                    $numberoffice = (new Office())->lastNumberOffice(1)[0]->id_office;
                    $lastKey = $item->id_unit;
                }
                $checkOffice = (new Card())->sendUnitOffice($item->id_card_request, $numberoffice, $shipment);
            }
        }

        return true;
    }

}
