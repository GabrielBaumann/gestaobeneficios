<?php

namespace Source\Models;

use Source\Core\Email;
use Source\Core\Model;
use Source\Core\View;

class Auth extends Model
{
    public function __construct()
    {
        parent::__construct("user", ["id_user"], ["email", "senha"], "id_user");        
    }

    public function register(User $user): bool
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
