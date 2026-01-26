<?php

namespace Source\Models\Card;

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\StandardDeviations;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;
use Source\Core\Model;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\Views\Vw_recharge;
use Source\Models\UserSystem\UnitUserSystem;
use Source\Models\Card\CardValue;

class CardRecharge extends Model
{
    public function __construct()
    {
        parent::__construct("card_recharge", [], [], "id_card_recharge");
    }

    // Inserir recargar a partir do novo cartão
    public function addRecharge(int $idCard, int $idRequestCard, array $data): bool
    {
        $monthStart = (int)$data["month-start"];
        $monthEnd = (int)$data["month-end"];
        $idValueCard = (new CardValue())->valueCard();

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

        // Registro espelho
        [$month, $year] = explode(";", $monthAll[0]);
        $data["month"] = 0;
        $data["year"] = $year;
        $data["id_card_value"] = 0;

        $idFixed = (new static())->bootstrap($idCard, $idRequestCard, 0, $data);

        // Criar os registros fixos (as recargas de fato)
        foreach ($monthAll as $monthItem) {
            [$month, $year] = explode(";", $monthItem);
            $data["month"] = $month;
            $data["year"] = $year;
            $data["id_card_value"] = (int)$idValueCard;

            $newCardRecharge = new static;
            $newCardRecharge->bootstrap($idCard, $idRequestCard, $idFixed, $data);
        }

        return true;
    }

    public function bootstrap(int $idCard, int $idRequestCard, int $idFifixed, array $data): int
    {
        $this->id_card_request = $idRequestCard;
        $this->id_card_recharge_fixed = $idFifixed;
        $this->id_card = $idCard;
        $this->month_start = $data["month-start"];
        $this->month_end = $data["month-end"];
        $this->month_recharge = $data["month"];
        $this->year_recharge = $data["year"];
        if (isset($data["status_recharge"])) {
            $this->status_recharge = $data["status_recharge"];
        }
        $this->id_card_value = $data["id_card_value"];
        $this->id_user_system_register = 1;

        $this->save();

        return $this->id_card_recharge;
    }

    // Regras de verificação para as solicitações de meses
    public function checkRechargeMonth(array $data) : bool
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

        return true;       
    }

    // Checar recargas e inserir recargas
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
                "id_card = :id AND id_card_recharge_fixed <> :ca AND (status_recharge = :st OR status_recharge = :sa)",
                "id={$checkRecharge->id_card}&ca=0&st=solicitado&sa=credito liberado"
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

        // Inserir novas recargas
        $this->addRechargeGeneral($checkRecharge->id_card, $data, $monthAll);
        $this->message->success("Registro cadastrado com sucesso!");
        return true;
    }

    // Função usada na função de verificação da recarga, retorna uma mensagem com a lista de meses
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

    // Inserir recargas e criar 
    function addRechargeGeneral(int $idCard, array $data, array $month) : bool
    {   
        $idValueCard = (new CardValue())->valueCard();
        $idRequest = (new RequestCard())->rechargeCard($data);
        $cardRechargFixed = (new static());

        // Registro espelho
        [$months, $year] = explode(";", $month[0]);
        $data["month"] = 0;
        $data["year"] = $year;
        $data["status_recharge"] = "ativo";
        $data["id_card_value"] = 0;
        $idFixed = $cardRechargFixed->bootstrap($idCard, $idRequest, 0, $data);
               
        foreach($month as $monthItem) {
            [$month, $year] = explode(";", $monthItem);

            $data["month"] = $month; 
            $data["year"] = $year;
            $data["status_recharge"] = "solicitado";
            $data["id_card_value"] = (int)$idValueCard;

            $newCardRecharge = (new static());
            $newCardRecharge->bootstrap($idCard, $idRequest, $idFixed, $data);
        }

        return true;
    }

    // Inserir recarga extra
    function addRechargeExtra(array $data) : bool
    {
        $idBenefit = (int)$data["person-benefit"];
        $idValueCard = (new CardValue())->valueCard();

        // Procurar cartão ativo baseado no id do beneficiário
        $idCard = (new Vw_card())->find("id_person_benefit = :id AND status_card = :st AND type_request <> :ty",
            "id={$idBenefit}&st=ativo&ty=emergencial")
            ->fetch()->id_card;

        // Procurar id_card_recharge_fixed a partir do id o cartão
        $idCardRechargeFixed = (new Vw_recharge())
            ->find("id_card = :id AND id_card_recharge_fixed <> :ca","id={$idCard}&ca=0")
            ->fetch()->id_card_recharge_fixed;

        $idRequest = (new RequestCard())->requestRechargeExtraCard($data);
        $cardRechargFixed = (new static());

        // Registro espelho
        $data["month"] = (int)date("m");
        $data["year"] = (int)date("Y");
        $data["month-start"] = (int)date("m");
        $data["month-end"] = (int)date("m");
        $data["status_recharge"] = "credito liberado";
        $data["id_card_value"] = $idValueCard;
        $cardRechargFixed->bootstrap($idCard, $idRequest, $idCardRechargeFixed, $data);
            
        return true;
    }

}