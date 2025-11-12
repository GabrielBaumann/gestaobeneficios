<?php

namespace Source\Models\Card;

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;
use Source\Core\Model;
use Source\Models\Card\Views\Vw_card;

class CardRecharge extends Model
{
    public function __construct()
    {
        parent::__construct("card_recharge", [], [], "id_card_recharge");
    }

    public function addRecharge(int $idCard, int $idRequestCard, array $data): bool
    {
        // Registro espelho
        $idFixed = $this->bootstrap($idCard, $idRequestCard, 0, 0, $data);

        // Criar os registros fixos (as recargas de fato)
        for ($i = (int)$data["month-start"]; $i <= (int)$data["month-end"]; $i++) {
            $newCardRecharge = new static;
            $newCardRecharge->bootstrap($idCard, $idRequestCard, $i, $idFixed, $data);
        }
        return true;
    }

    public function bootstrap(int $idCard, int $idRequestCard, int $monthRecharge, int $idFifixed, array $data): int
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

    public function cardCancel(int $idRequest): bool
    {

        $cardAll = (new Vw_card())->findById($idRequest);

        // Cancelar cartão
        $card = (new Card())->findById($cardAll->id_card);
        $card->status_card = "cancelado";

        if (!$card->save()) {
            $this->message->warning("Erro atualize a página e tente novamente!");
            return false;
        }

        // Cancelar recarga
        $recharge = (new static())->find(
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
        return true;
    }

    public function checkRecharge(array $data): bool
    {
        $monthStart = (int)$data["month-start"];
        $monthEnd = (int)$data["month-end"];

        if ($monthEnd > 12 || $monthEnd <= 0 || $monthStart > 12 || $monthStart <= 0) {
            $this->message->warning("Número não permitidos!");
            return false;
        }

        if((int)$monthStart < (int)date("m")) {
            $this->message->warning("Não é possível solicitar recergas para meses anterior ao mês atual!");
            return false;
        }

        $monthAll = [];
        if ($monthStart > $monthEnd) {

            for ($i = $monthStart; $i <= 12; $i++) {
                $monthAll[] = format_number($i, 2) . ";" . date("Y");
            }

            for ($i = 1; $i <= $monthEnd; $i++) {
                $monthAll[] = format_number($i, 2) . ";" . date("Y") + 1;
            }
        } else {
            for ($i = $monthStart; $i <= $monthEnd; $i++) {
                $monthAll[] = format_number($i, 2) . ";" . date("Y");
            }
        }

        if(count($monthAll) > 3) {
            $this->message->warning("A solicitação não pode ser maior que três meses!");
            return false;
        }

        $idBenefit = (int)$data["person-benefit"];

        $checkRecharge = (new Vw_card())
            ->find(
                "id_person_benefit = :id AND type_request <> :ty AND status_card = :st",
                "id={$idBenefit}&ty=emergencial&st=ativo"
            )
            ->fetch();

        $recharge = (new static())
            ->find(
                "id_card_request = :id AND id_card_recharge_fixed <> :ca",
                "id={$checkRecharge->id_card_request}&ca=0"
            )
            ->fetch(true);

        $arraInfoStatus = [];
        foreach ($recharge as $rechargeItem) {

            foreach ($monthAll as $monthAllItem) {
                $allData = explode(";", $monthAllItem);
                $year = (int)$allData[1];
                $month = (int)$allData[0];

                if ($rechargeItem->month_recharge === $month && $rechargeItem->year_recharge === $year) {
                    $arraInfoStatus[$rechargeItem->status_recharge][] = $monthAllItem;
                }
            }
        }

        // Mensagem caso já exista mês pago ou solicitado
        $countPaidRecharge = count($arraInfoStatus["credito liberado"] ?? []);
        $countRequestRecharge = count($arraInfoStatus["solicitado"] ?? []);


        // Recargas já solicitadas
        $messageRequest = "";
        if ($countRequestRecharge) {
            $messageRequest = $this->messageCheckRecharge($arraInfoStatus["solicitado"], ["stringsing" => "solicitado", "stringplu" => "solicitados"], $countRequestRecharge);
        }

        // Recargas já pagas
        $messagePaid = "";
        if($countPaidRecharge) {
            $messagePaid = $this->messageCheckRecharge($arraInfoStatus["credito liberado"], ["stringsing" => "pago", "stringplu" => "pagos"], $countPaidRecharge);
        }

        // Mensagem sobre mensamgem já paga ou solicitadas
        if($countPaidRecharge > 0 || $countRequestRecharge > 0) {
            $messageComplete = ($messageRequest ?? "")  . (($messagePaid !== null) ? " " . ($messagePaid ?? "") : "");
            $this->message->warning($messageComplete);
            return false;
        }

        var_dump($messageComplete);

        return true;
    }

    // Função usanda na função de verificação da recarga, retorna uma mensagem com a lista de meses
    function messageCheckRecharge(array $data, array $text, int $count): string
    {
        $textAll = array_map(function ($item) {
            return str_replace(";", "/", $item);
        }, $data);

        if ($count === 1) {
            $textFirst = "O mês ";
            $textLast = " já foi " . $text["stringsing"] . "!";
        } else {
            $textFirst = "Os meses ";
            $textLast = " já foram " . $text["stringplu"] . "!";
        }

        if (count($textAll) > 1) {
            $last = array_pop($textAll);
            $textBody = implode(", ", $textAll) .  " e " . $last;
        } else {
            $textBody = $textAll[0];
        }

        $finishiString = $textFirst . $textBody . $textLast;

        return $finishiString;
    }
}
