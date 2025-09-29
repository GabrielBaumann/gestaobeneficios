<?php

namespace Source\Models\UserSystem;

use Source\Core\Model;

class UnitUserSystem extends Model
{
    public function __construct()
    {
        parent::__construct("unit_user_system", [], [], "id_unit_user_system");        
    }

    // Retorna o coordeandor ativo baseado no id da unidade
    public function activeCoordinator(int $idUnit) : int
    {
        $coordinato = $this->find("status = :st AND function_user = :fu AND id_unit = :id","st=ativo&fu=COORDENADOR(A)&id={$idUnit}")->fetch();
        $coordinato ? $id = $coordinato->id_unit_user_system : $id = 0;
        return $id;    
    }

    // public function activeTechnician() : Returntype {
        
    // }

}
