<?php

namespace Source\Models\Card;

use Source\Core\Model;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\CardNotFound;
use Source\Models\Card\Views\Vw_recharge;
use Source\Models\PersonBenefit;

class CardBalance extends Model
{
    public function __construct()
    {
        parent::__construct("card_balance",[],[], "id_card_balance");
    }

    // Verficar listade saldos
    public function checkedListExcel(array $data, int $month) : array
    {
        // Verifica se existe dados relacionados ao mês de verificação no card_not_found, se existir apaga
        $verificNotFound = (new CardNotFound())->delete("month_reference = :re","re={$month}");

        foreach($data as $dataItem) {

            $dataAll = explode(";", $dataItem);
            $value = trim($dataAll[1]);

            $nameCpf = explode("(", $dataAll[0]);

            $name = trim($nameCpf[0]);
            $cpf = str_replace([")"], [""], trim($nameCpf[1]));
            // $cpf = str_replace([".","-",")"], [""], trim($nameCpf[1]));

            // Verifica se é cartão emergencial, e atualiza o valor do saldo
            if (explode(" ", $name)[0] === "Beneficio") {
                $numberEmergency = ltrim(strrchr($name, " "));

                // Função para inserir dados na tabela de saldo com id do beneficiário e valor do saldo
                $checkEmergence = $this->checkdCardEmergenci($numberEmergency, $month);

                if (!$checkEmergence) {
                    // Enviar dados de beneficiários não encontrado para atualização de saldo
                    $this->createdListNotFound(
                        [
                            "name" => $name, 
                            "cpf" => $cpf, 
                            "value" => (float)$value, 
                            "monthReference" => $month
                        ]);
                }

            } else {

                // verifica se o usuário tem cartão ativo, se não tivar criar uma lista de não cadastrados
                $checkCard = $this->checkdBenefitCardActive($cpf);

                if (!$checkCard) {
                    // Enviar dados de beneficiários não encontrado para atualização de saldo
                    $this->createdListNotFound(
                        [
                            "name" => $name, 
                            "cpf" => $cpf, 
                            "value" => (float)$value, 
                            "monthReference" => $month
                        ]);

                }
            }
        }        

        $notFaund = (new CardNotFound())->find("month_reference = :mo", "mo={$month}")->fetch(true) ?? [];

        return $notFaund;
    }

    // Atualiza o valor dos saldos dos cartões
    public function balanceCard(array $data, int $month) : void
    {   

        foreach($data as $dataItem) {

            $dataAll = explode(";", $dataItem);
            $value = trim($dataAll[1]);

            $nameCpf = explode("(", $dataAll[0]);

            $name = trim($nameCpf[0]);
            $cpf = str_replace([")"], [""], trim($nameCpf[1]));
            // $cpf = str_replace([".","-",")"], [""], trim($nameCpf[1]));

            // Verifica se é cartão emergencial, e atualiza o valor do saldo
            if (explode(" ", $name)[0] === "Beneficio") {
                $numberEmergency = ltrim(strrchr($name, " "));

                // Função para inserir dados na tabela de saldo com id do beneficiário e valor do saldo
                $checkEmergence = $this->checkdCardEmergenci($numberEmergency, $month);

                if (!$checkEmergence) {
                    // Enviar dados de beneficiários não encontrado para atualização de saldo
                    $this->createdListNotFound(
                        [
                            "name" => $name, 
                            "cpf" => $cpf, 
                            "value" => (float)$value, 
                            "monthReference" => $month
                        ]);
                } else {
                    // Dar baixa na recarga e atualizar o saldo do cartão
                    $this->updateOrCreatedBalance($checkEmergence[0]->id_person_benefit, (float)($value));
                }

            } else {

                // verifica se o usuário tem cartão ativo, se não tivar criar uma lista de não cadastrados
                $checkCard = $this->checkdBenefitCardActive($cpf);

                if (!$checkCard) {
                    // Enviar dados de beneficiários não encontrado para atualização de saldo
                    $this->createdListNotFound(
                        [
                            "name" => $name, 
                            "cpf" => $cpf, 
                            "value" => (float)$value, 
                            "monthReference" => $month
                        ]);
                } else {
                    // Dar baixa na recarga e atualizar o saldo do cartão
                    $this->updateOrCreatedBalance($checkCard[0]->id_person_benefit, (float)($value));
                }
            }
        }
        return;
    }

    // A partir do cpf do beneficiário verifica se tem cartão ativo (novo cartão ou segunda via)
    private function checkdBenefitCardActive(string $cpfPersonBenefit) : array
    {   
        $personBenefit = (new Vw_card())
            ->find("cpf = :cp AND (type_request = :nv OR type_request = :se) AND status_card = :st", 
            "cp={$cpfPersonBenefit}&nv=novo cartão&se=segunda via&st=ativo")
            ->fetch();
        $arrayResult = [];

        if(!$personBenefit) {
            return $arrayResult;
        }

        $arrayResult[] = $personBenefit;

        return $arrayResult;
    }

    // A partir do número do cartão emergencial verifica se exite o número do cartão baseado no mês de solicitação
    private function checkdCardEmergenci(string $numberCard, int $month) : array 
    {
        $vwCard = (new Vw_card())->find("number_card = :nu","nu={$numberCard}")->fetch(true);
        // var_dump($vwCard);

        if(!$vwCard) {
            return[];
        }
        $result = [];
            foreach ($vwCard as $vwCardItem) {

                $recharge = (new Vw_recharge());
                $rechargeEmergence = $recharge->find("id_card_request = :id AND id_card_recharge_fixed <> :ca", "id={$vwCardItem->id_card_request}&ca=0")->fetch();
                
                if ($rechargeEmergence->month_recharge === $month) {
                    // Retorna o registro do usuário que solicitou o emergencial
                    $result[] = $rechargeEmergence;
                }
            }

        return $result;
    }

    // Atualizar o saldo do beneficiário ou criar um registro se não existir, atualizar baseado no id_usuario
    private function updateOrCreatedBalance(int $idBenefit, float $value) : bool
    {
        // Verificar se o beneficiário já existe na tabela card_balance se não existir cria
        $cardBalance = new static();
        $balanceBenefit = $cardBalance->find("id_person_benefit = :id", "id={$idBenefit}")->fetch();

        if (!$balanceBenefit) {
            // Cria registro na tabela card_balance

            $newBalance = new static();
            $newBalance->id_person_benefit = $idBenefit;
            $newBalance->value = $value;
            $newBalance->id_user_system_register = 1;
            
            $newBalance->save();
            return true;
        }

        // Atualiza o valor
        $updateBalance = new static();
        $updateBalance->id_card_balance = $balanceBenefit->id_card_balance;
        $updateBalance->id_person_benefit = $idBenefit;
        $updateBalance->value = $value;
        $updateBalance->id_user_system_update = 2;
            
        $updateBalance->save();
        return true;
    }

    // Criar lista de cartões não encontrados ou cartão cancelado
    private function createdListNotFound(array $data) : bool
    {
        $cardNotFound = (new CardNotFound());

        $cardNotFound->name = $data["name"];
        $cardNotFound->cpf = $data["cpf"];
        $cardNotFound->value = $data["value"];
        $cardNotFound->month_reference = $data["monthReference"];
        $cardNotFound->id_user_system_register = 1;

        $cardNotFound->save();
        return true;
    }
}
