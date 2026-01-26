<?php

namespace Source\Models\UserSystem;

use Source\Core\Model;
use Source\Models\Unit\Unit;
use Source\Models\UserSystem\Views\Vw_unit_user;
use Source\Models\UserSystem\Auth;

class UnitUserSystem extends Model
{
    public function __construct()
    {
        parent::__construct("unit_user_system", [], [], "id_unit_user_system");        
    }

    // Acesso ao sistema para uso nos benefícios
    public static function userSystemUnit() : ?Vw_unit_user
    {
        $idUserSytem = Auth::user()->id_user_system;
        return (new Vw_unit_user())
            ->find("id_user_system = :id AND status_user_unit = :st AND status_user_system = :su",
             "id={$idUserSytem}&st=ativo&su=ativo")
            ->fetch();
    }

    //Cadastrar o usuário em um novo setor
    public function createUserUnit(array $data, int $idUser) : bool
    {   
        $idUserUnit = user()->id_user_system;
        $useUnit = (new static());

        $useUnit->id_user_system = $idUser;
        $useUnit->id_unit = $data["unit"];
        $useUnit->id_function_user = $data["function-unit"];
        $useUnit->type_access_unit = $data["type-access"];
        $useUnit->id_user_system_register = $idUserUnit;

        $useUnit->save();
        return true;
    } 
    
    //Cadastrar o usuário em um novo setor (excluir depois da versão final)
    public function createUserUnitDirect(array $data, int $idUser) : bool
    {   
        $idUserSytem = user()->id_user_system;
        $useUnit = (new static());

        $useUnit->id_user_system = $idUser;
        $useUnit->id_unit = $data["unit"];
        $useUnit->id_function_user = $data["function-unit"];
        $useUnit->type_access_unit = $data["type-access"];
        $useUnit->id_user_system_register = $idUserSytem ;
        
        $useUnit->save();
        return true;
    } 
    
    // Recebe o id do técnico, baseado no id ele retorna o id da unidade, 
    // baseado do id da unidade retorna o id do coordenador ativo
    public function activeCoordinator(int $idTechinical) : int
    {   
        //Recebe o id do técnico e retorna o id da unidade 
        $idUnit = (new static())->findById($idTechinical)->id_unit;

        $coordinato = (new static())->find(
            "status = :st 
                AND type_access_unit = :fu 
                AND id_unit = :id",
            "st=ativo&fu=COORDENADORIA&id={$idUnit}")->fetch();
        
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

    // Retorna uma lista de técnicos baseado na unidade logada
    public function listTechnicalUnit(?int $idUnit = null) : array
    {
        if($idUnit) {
            $unit = (new Vw_unit_user())->find("
                id_unit = :id AND 
                (type_access_unit = :ty OR type_access_unit = :ta) AND
                status_user_unit = :st AND
                status_user_system = :stu",
                "id={$idUnit}&ty=tecnico&ta=coordenadoria&st=ativo&stu=ativo")
            ->fetch(true);
        } else {
            $unit = (new Vw_unit_user())->find("
                (type_access_unit = :ty OR type_access_unit = :ta) AND
                status_user_unit = :st AND
                status_user_system = :stu",
                "ty=tecnico&ta=coordenadoria&st=ativo&stu=ativo")
            ->fetch(true);            
        }

        return $unit;
    }

}
