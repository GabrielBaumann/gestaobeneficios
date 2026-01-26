<?php

namespace Source\App\UserSystem;

use Source\Core\Controller;
use Source\Core\Email;
use Source\Core\View;
use Source\Models\UserSystem\UnitUserSystem;
use Source\Models\UserSystem\UserSystem;

class User extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");        
    }

    public function addUser(?array $data) : void
    {

        if (isset($data["csrf"]) && !empty($data["csrf"])) {

            // Campo criado no javascript para marcar que é somente para validação dos campos
            if(isset($data["valid"])) {
                $dataClean = cleanInputData($data);
                
                // Campos vazios
                if(!$dataClean["valid"]) {
                    $json["message"] = messageHelpers()->warning("Preeencha todos os campos obrigatórios (*)")->render();
                    echo json_encode($json);
                    return;
                }
                
                // Verifica se o cpf é válido   
                $cpfCheck = validateCPF(filter_var(cleanCPF($data["document"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                if(!$cpfCheck) {
                    $json["message"] = messageHelpers()->warning("Esse CPF não é válido!")->render();
                    echo json_encode($json);
                    return;
                }

                // Verifica se já está cadastraod na base de dados
                $cpf = filter_var(cleanCPF($data["document"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
                $userSystem = (new UserSystem())
                    ->find("cpf = :cp", "cp={$cpf}")
                    ->fetch();
                if($userSystem) {
                    $json["message"] = messageHelpers()->warning("Usuário já está cadastrado na base de dados!")->render();
                    echo json_encode($json);
                    return;
                }

                // Verificar se o email é válido
                if(!is_email($data["email"])) {
                    $json["message"] = messageHelpers()->warning("Esse E-mail não é válido!")->render();
                    echo json_encode($json);
                    return;
                }

                // Verificar se o email já existe na base de dados
                $email = filter_var($data["email"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $emailExist = (new UserSystem())
                    ->find("email = :em", "em={$email}")
                    ->fetch();
                if($emailExist) {
                    $json["message"] = messageHelpers()->warning("Esse e-mail já está cadastrado na base de dados!")->render();
                    echo json_encode($json);
                    return;
                }

                $json["status"] = true;
                echo json_encode($json);
                return;  

            }            
            
            $userSystem = (new UserSystem());
            $userSytemUnit = (new UnitUserSystem());

            $idUserSystem = $userSystem->createUserSystem($data);

            if($idUserSystem === 0) {

                $json["message"] = messageHelpers()->warning("Erro ao cadastrar usuário!")->render();
                echo json_encode($json);
                return;
            };

            // Cadastro realizado com sucesso
            $userSytemUnit->createUserUnit($data, $idUserSystem);

            // Enviar email de confirmação
            $view = new View(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/email");
            $message = $view->render("confirm", [
                "name" => $data["name-user"],
                "email" => $data["email"],
                "id" => "1",
                "confirm_link" =>url("/")
            ]);

            (new Email())->bootstrap(
                "Conta criada com sucesso",
                $message,
                $data["email"],
                $data["name-user"]
            )->send();

            $json["message"] = messageHelpers()->success("Regitro cadastrado com sucesso! Uma senha automatica (123456) foi encaminhada para o e-mail do usuário cadastrado!")->flash();
            $json["redirected"] = url("/usuario/usuario");
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/usersystem/formNewUser", [

        ]); 
    }

    public function checkCpf(array $data) : void
    {
        // Verifica se o cpf é válido   
        $cpfCheck = validateCPF(filter_var(cleanCPF($data["cpf"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if(!$cpfCheck) {

            $json["message"] = messageHelpers()->warning("Esse CPF não é válido!")->render();
            $json["status"] = false;
            echo json_encode($json);
            return;
        }

        // Verifica se já está cadastraod na base de dados
        $cpf = filter_var(cleanCPF($data["cpf"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $userSystem = (new UserSystem())
            ->find("cpf = :cp", "cp={$cpf}")
            ->fetch();

        if($userSystem) {

            $json["message"] = messageHelpers()->warning("Usuário já está cadastrado na base de dados!")->render();
            $json["status"] = false;
            echo json_encode($json);
            return;
        }

        $json["status"] = true;
        echo json_encode($json);
        return;
    }

    public function checkEmail(array $data) : void
    {
        // Verificar se o email é válido
        if(!is_email($data["email"])) {
            $json["message"] = messageHelpers()->warning("Esse E-mail não é válido!")->render();
            $json["status"] = false;
            echo json_encode($json);
            return;
        }

        // Verificar se o email já existe na base de dados
        $email = filter_var($data["email"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $emailExist = (new UserSystem())
            ->find("email = :em", "em={$email}")
            ->fetch();
        
        if($emailExist) {

            $json["message"] = messageHelpers()->warning("Esse e-mail já está cadastrado na base de dados")->render();
            $json["status"] = false;
            echo json_encode($json);
            return;
        }
        
        $json["status"] = true;
        echo json_encode($json);
        return;
    }

    // Modal quest
    public function modalQuest(?array $data) : void
    {
        if (isset($data["btn-yes"])) {


            $json["response"] = true;
            echo json_encode($json);
            return;
        }

        $html = $this->view->render("/modal/modalQuest", [
            "title" => $data["title"] ?? "Confirmar Ação",
            "textMessage" => $data["text"]
        ]);

        $json["modal"] = $html;
        echo json_encode($json);
        return;
    }

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}