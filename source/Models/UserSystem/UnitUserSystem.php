<?php

namespace Source\Models\UserSystem;

use Source\Core\Model;
use Source\Models\Unit;

class UnitUserSystem extends Model
{
    public function __construct()
    {
        parent::__construct("unit_user_system", [], [], "id_unit_user_system");        
    }

    // Retorna o coordeandor ativo baseado no id da unidade
    public function activeCoordinator(int $idTechnical) : int
    {   
        $idunitCoordinator = (new static)->findById($idTechnical);
        $coordinato = $this->find("status = :st AND function_user = :fu AND id_unit = :id","st=ativo&fu=COORDENADOR(A)&id={$idunitCoordinator->id_unit}")->fetch();
        $coordinato ? $id = $coordinato->id_unit_user_system : $id = 0;

        return $id;    
    }

    // Retorna o nome da unidade baseado no id do técnico
    public function unitOfTechnical(int $idTechnical) : object
    {
        $idUnit = $this->findById($idTechnical);
        $unit = (new Unit())->findById($idUnit->id_unit);
        
        $names = (object)[
            "name_full" => $unit->name_unit, 
            "name_abrreviation" => $unit->abbreviation_unit
        ];

        return $names;
    }

}
