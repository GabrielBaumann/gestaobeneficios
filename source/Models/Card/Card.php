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

    // Verificar se existe remessa de cartões para empresa
    public function checkListCardRequest() : bool
    {
        $allNewCard = new Vw_card();
        $allCard = $allNewCard->find("status_request = :st AND type_request = :ty AND status_card = :sc","st=solicitado&ty=novo cartão&sc=aguardando cartão")->fetch(true);
        
        // Verifica o find retorna um array
        if(!$allCard) {
            return false;
        }
        return true;        
    }

    // Envia remessa de cartões para empresa que vai confeccionar os cartões
    public function sendCardCompany(bool $list = false) : bool
    {
        $allNewCard = new Vw_card();
        
        if($list) {
            $allCard = $allNewCard->find("status_request = :st AND type_request = :ty AND status_card = :sc","st=concluída&ty=novo cartão&sc=aguardando cartão")->fetch(true);
        }else {
            $allCard = $allNewCard->find("status_request = :st AND type_request = :ty AND status_card = :sc","st=solicitado&ty=novo cartão&sc=aguardando cartão")->fetch(true);
        }
            
        // Verifica o find retorna um array
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

            if($list) {
                $idCard->status_card = "confecção";
            }
        
            $idCard->save();

            // Atualizar tabela de recarga
            $recharge = new CardRecharge();
            $idRecharge = $recharge->find("id_card = :id","id={$idCard->id_card}")->fetch(true);
            foreach($idRecharge as $idRechargeItem) {
                $idRechargeItem->status_recharge = "confecção";
                $idRechargeItem->save();
            }
        }

        // Emitir documento ofício com solicitação de confecção de cartão

        return true;
    }

    // Envia cartões para suas unidades 
    public function sendCardUnit(int $idCard) : bool
    {
        // Atualizar tabela do Cartão
        $card = new Static();
        $idCard = $card->findById($idCard);
        $idCard->status_card = "ativo";
        $idCard->received = "sim";
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
