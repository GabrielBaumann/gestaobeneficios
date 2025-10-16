<?php

namespace Source\Models;

use Source\Core\Model;

class PersonBenefit extends Model
{
    public function __construct()
    {
        parent::__construct("person_benefit",[],[], "id_person_benefit");
    }
}
