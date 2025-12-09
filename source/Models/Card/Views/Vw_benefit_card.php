<?php

namespace Source\Models\Card\Views;

use Source\Core\Model;

class Vw_benefit_card extends Model
{
    public function __construct()
    {
        parent::__construct("vw_benefit_card",[],[],"id_person_benefit");
    }

    // Pesquisar lista de cartões
    public function searchCard(array $data) : array
    {
        $recipient = $data["recipientname"];

        $conditions = [];
        $params = [];

        if (!empty($recipient)) {
            $conditions[] = "(name_benefit LIKE :na OR cpf LIKE :na)";
            $params["na"] = "%{$recipient}%";
        }

        $where = implode(" AND ", $conditions);

        $resultSearch = (new static())
            ->find($where, http_build_query($params))
            ->fetch(true) ?? [];

        return $resultSearch;
    }

}
