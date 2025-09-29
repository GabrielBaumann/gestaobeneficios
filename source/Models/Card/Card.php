<?php

namespace Source\Models\Card;

use Source\Core\Model;
use Source\Models\Card\CardValue;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\Views\Vw_recharge;

class Card extends Model
{
    public function __construct()
    {
        parent::__construct("card",[],[], "id_card");
    }

    // Cadastra os dados de solicitação na tabela de cartão
    public function dataCard(int $id_resquest) : int
    {       
        $idValue = (new CardValue())->valueCard();
        $card = new static;

        $card->id_card_request = $id_resquest;
        $card->id_card_value = $idValue;
        $card->id_user_system_register = 1;

        $card->save();
        return $card->id_card;
    }

    // Envia remessa de cartões para empresa que vai confeccionar os cartões
    public function sendCardCompany() : bool
    {
        $allNewCard = new Vw_card();
        $allCard = $allNewCard->find("status_request = :st AND type_request = :ty AND status_card = :sc","st=solicitado&ty=novo cartão&sc=aguardando cartão")->fetch(true);

        // Criar lista em excel com os novos cartões

        
        if(!$allCard) {
            return false;
        }

        foreach($allCard as $allCardItem) {

            // Atualizar tabela de solicitação
            $request = new RequestCard();
            $idRequest = $request->findById($allCardItem->id_card_request);
            $idRequest->status_request = "concluída";
            $idRequest->save();          

            // Atualizar tabela do Cartão
            $card = new Static();
            $idCard = $card->find("id_card_request = :id","id={$allCardItem->id_card_request}")->fetch();
            $idCard->status_card = "Confecção";
            $idCard->save();

            // Atualizar tabela de recarga
            $recharge = new CardRecharge();
            $idRecharge = $recharge->find("id_card = :id","id={$idCard->id_card}")->fetch(true);
            foreach($idRecharge as $idRechargeItem) {
                $idRechargeItem->status_recharge = "Confecção";
                $idRechargeItem->save();
            }
        }

        // Emitir documento ofício com solicitação de confecção de cartão

        return true;
    }

    // Envia cartões para suas unidades 
    public function sendCardUnit() : bool
    {
        $allNewCard = new Vw_card();
        $allCard = $allNewCard->find("status_request = :ty AND status_card = :sc","ty=concluída&sc=confecção")->fetch(true);

        // Criar lista em excel com os novos cartões
        // var_dump($allCard);
        
        if(!$allCard) {
            return false;
        }

        foreach($allCard as $allCardItem) {
    
            // Atualizar tabela do Cartão
            $card = new Static();
            $idCard = $card->find("id_card_request = :id","id={$allCardItem->id_card_request}")->fetch();
            $idCard->status_card = "ativo";
            $idCard->save();

            // Atualizar tabela de recarga
            $recharge = new CardRecharge();
            $idRecharge = $recharge->find("id_card = :id","id={$idCard->id_card}")->fetch(true);
            foreach($idRecharge as $idRechargeItem) {

                if($idRechargeItem->id_card_recharge_fixed === 0) {
                    $idRechargeItem->status_recharge = "ativo";
                    $idRechargeItem->save();
                } else {
                    $idRechargeItem->status_recharge = "solicitado";
                    $idRechargeItem->save();
                }
            }
        }

        // Emitir documento ofício com solicitação de confecção de cartão

        return true;
    }

    // Envia lista de desbloqueio do mês
    public function sendRecharge() : array
    {
        list($month, $year, $status) = [date("n"), date("Y"), "solicitado"];
        $recharge = (new Vw_recharge())->find("month_recharge = :mo AND year_recharge = :ye AND status_recharge = :st", "mo={$month}&ye={$year}&st={$status}")->fetch(true);
        return $recharge ?? [];
    }

}
