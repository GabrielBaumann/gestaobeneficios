<?php

namespace Source\Models;

use Source\Core\Model;

class Unit extends Model
{
    public function __construct()
    {
        parent::__construct("unit",[],[], "id_unit");
    }
}
