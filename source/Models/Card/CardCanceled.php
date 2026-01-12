<?php

namespace Source\Models\Card;

use Source\Core\Model;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\CardRecharge;

class CardCanceled extends Model
{
    public function __construct()
    {
        parent::__construct("card_canceled",[],[], "id_card_canceled");
    }

    public function cardCancel(array $data): bool
    {
        $cardAll = (new Vw_card())->findById((int)fncDecrypt($data["id-card-request"]));

        // Cancelar cartão
        $card = (new Card())->findById($cardAll->id_card);
        $card->status_card = "cancelado";

        if (!$card->save()) {
            $this->message->warning("Erro atualize a página e tente novamente!");
            return false;
        }

        // Cancelar recarga
        $recharge = (new CardRecharge())->find(
            "id_card = :id AND id_card_recharge_fixed <> :ca",
            "id={$cardAll->id_card}&ca=0"
        )
        ->fetch(true);

        foreach ($recharge as $rechargeItem) {
            if ($rechargeItem->status_recharge === "solicitado") {
                $rechargeItem->status_recharge = "cancelado ocorrencia";
                $rechargeItem->save();
            }
        }

        // Salvar dados dos cancelamento
        $canceledCard = new Static();

        if ($data["id-card-canceled"] ?? false) {
            $canceledCard->id_card_canceled = (int)fncDecrypt($data["id-card-canceled"]);
            $canceledCard->id_user_system_update = 2;
        }

        $canceledCard->id_card = $cardAll->id_card;
        $canceledCard->reason = $data["reason-canceled"];
        $canceledCard->observation = $data["observation"];
        $canceledCard->id_user_system_register = 1;

        $canceledCard->save();

        return true;
    }

}
