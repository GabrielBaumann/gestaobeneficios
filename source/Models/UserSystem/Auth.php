<?php

namespace Source\Models\UserSystem;

use Source\Core\Email;
use Source\Core\Model;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\UserSystem\UserSystem;

class Auth extends Model
{
    public function __construct()
    {
        parent::__construct("user_system", ["id_user_system"], ["email", "password","cpf"], "id_user_system");        
    }

    public static function user() : ?UserSystem
    {
        $session = new Session();
        
        if (!$session->has("authUser")){
            return null;
        }

        return (new UserSystem())->findById($session->authUser);    
    }

    public static function logout() : void
    {
        $session = new Session();
        $session->unset("authUser");
    }

    public function login(string $cpf, string $passwordUser) : bool
    {
        $instanciaUser = (new UserSystem())->find("cpf = :u", "u={$cpf}");
        $userData = $instanciaUser->fetch();

        if(!$userData) {
            $this->message->error("Usuário não cadastrado no sistema!");
            return false;
        }

        if ($userData->active === 2) {
            $this->message->error("Usuário desativado do sistema!");
            return false;
        }
        
        if (!password_verify($passwordUser, $userData->password)) {
            $this->message->error("A senha informada não confere!");
            return false;
        }

        // LOGIN

        (new Session())->set("authUser", $userData->id_user_system);
        // $this->message->success("Login efetuado com sucesso")->flash();
        return true;
    }    

    public function register(UserSystem $user): bool
    {
        if (!$user->save()) {
            $this->message = $user->message;
            return false;
        }

        $view = new View(__DIR__ . "/../../themes/emailweb/email");
        $message = $view->render("confirm", [
            "name" => $user->name,
            "email" => $user->email,
            "id" => $user->id_user,
            "confirm_link" => url("/obrigado/" . base64_encode($user->email))
        ]);

        (new Email())->bootstrap(
            "Ative sua conta na SysCerberus",
            $message,
            $user->email,
            "{$user->name}"
        )->send();
        
        return true;
    }
}
