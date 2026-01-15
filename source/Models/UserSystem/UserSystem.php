<?php

namespace Source\Models\UserSystem;

use Source\Core\Model;

class UserSystem extends Model
{
    public function __construct()
    {
        parent::__construct("user_system",["id_user_system"],[],"id_user_system");        
    }

    // Cria novo usuário ou atualiza os dados e retorna o id
    public function createUserSystem(array $data) : int
    {

        $userSystem = new static();

        $userSystem->name_full = $data["name-user"];
        $userSystem->cpf = cleanCPF($data["document"]);
        $userSystem->date_birthday = $data["date-birth"];
        $userSystem->phone = preg_replace('/\D/','',$data["phone"]);
        $userSystem->email = $data["email"];
        $userSystem->password = "123456";

        if(!$userSystem->save()) {
            $idUser = 0;
        };
        
        $idUser = $userSystem->id_user_system;

        return $idUser;
    }

}
