<?php

namespace Source\Models\UserSystem;

use Source\Core\Model;

class UserSystem extends Model
{
    public function __construct()
    {
        parent::__construct("user_system",["id_user_system"],[],"id_user_system");        
    }
}
