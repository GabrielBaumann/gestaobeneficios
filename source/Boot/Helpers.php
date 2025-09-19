<?php

use Source\Support\Thumb;

/**
 * URL
 */

 function url(?string $path = null) : string
 {
    if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
        if($path) {
            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1): $path);
        }
        return CONF_URL_TEST;
    }
    
    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE;
 }

function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

 /**
  * ASSETS
  */
function user() : ?\Source\Models\SystemUser
{
    return \Source\Models\Auth::user();    
}

function messageHelpers() : \Source\Support\Message
{
    return new \Source\Support\Message();
}

function session(): \Source\Core\Session
{
    return new \Source\Core\Session();
}

function theme(?string $path = null, $theme = CONF_VIEW_THEME) : string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
        if($path) {
            return CONF_URL_TEST . "/themes/{$theme}/assets/" . ($path[0] == "/" ? mb_substr($path, 1): $path);
        }
        return CONF_URL_TEST . "/themes/{$theme}/assets";
    }
    
    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/assets/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/themes/{$theme}/assets";   
}

function image(string $image, int $width, ?int $height = null) {
    return url() . "/" . (new \Source\Support\Thumb())->make($image, $width, $height);
}

function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * REQUEST
 */
function csrf_input(): string
{
    $session = new \Source\Core\Session();
    $session->csrf();
    return "<input type='hidden' name='csrf' value='" . ($session->csrf_token ?? "") . "'/>";
}

function csrf_verify($request) : bool
{
    $session = new \Source\Core\Session();
    if (empty($session->csrf_token) || empty($request['csrf']) || $request['csrf'] != $session->csrf_token) {
        return false;
    }
    return true;
}

function flash() : ?string
{
    $session = new \Source\Core\Session();
    if ($flash = $session->flash()) {
        echo $flash;
    }
    return null;
}
 
/**
 * ####################
 * ###   PASSWORD   ###
 * ####################
 */

/**
 * @param string $password
 * @return string
 */
function passwd(string $password): string
{
    if (!empty(password_get_info($password)['algo'])) {
        return $password;
    }

    return password_hash($password, PASSWORD_DEFAULT, ["cost" => 10]);
}

/**
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * Funções de sanitização
 */

function cleanInputData(array $data, ?array $removerFilds = null): array
 {
    $allKeys = array_keys($data);

    $sanitezed = [];
    $errors = [];

    if ($removerFilds) {
        $requiredFields = array_diff($allKeys, $removerFilds);

        foreach ($removerFilds as $field) {
            $value = trim($data[$field]);
            $value = strip_tags($value);
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

            $sanitezed[$field] = mb_strtoupper($value, 'UTF-8');
        }

    } else {
        $requiredFields = $allKeys;
    }
    
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $errors[$field] = $field;
            continue;
        }

        // Remove espaços em branco
        $value = trim($data[$field]);

        // Se estiver vazio após o trim, é inválido
        if ($value === "") {
            $errors[$field] = $field;
            continue;
        }

        // Sanitize contra scripts e HTML

        $value = strip_tags($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        if($field === "cpf") {
            $value = preg_replace("/\D/", "", $data['cpf']);
        }

        if($field === "phone") {
            $value = preg_replace("/\D/", "", $data['phone']);
        }

        $sanitezed[$field] = mb_strtoupper($value, "UTF-8");
    }

    return [
        "valid" => empty($errors),
        "data" => $sanitezed,
        "errors" => $errors
    ];
}

/**
 * STRING
 */

function str_price(string $price) : string
{
    return  "R$ " . number_format($price, 2, ",", ".");
}

/**
 * DATE
 */

function date_fmt(string $date = "now", string $format = "d/m/Y H\hi"): string
{
    return (new DateTime($date))->format($format);
}

function date_simple(string $date = "now", string $format = "d/m/Y"): string
{
    return (new DateTime($date))->format($format);
}

function day_now_string(): string
{
    $dias = array(
    'Sunday' => 'Domingo',
    'Monday' => 'Segunda-feira',
    'Tuesday' => 'Terça-feira',
    'Wednesday' => 'Quarta-feira',
    'Thursday' => 'Quinta-feira',
    'Friday' => 'Sexta-feira',
    'Saturday' => 'Sábado'
    );

    $diaIngles = date('l'); // Retorna o dia em inglês
    $diaPortugues = mb_strtoupper($dias[$diaIngles]);
    return mb_strtoupper($diaPortugues);
}

function time_now(string $date = "now", string $format = "g:i A"): string
{
    return (new DateTime($date))->format($format);
}

/**
 * NUMBER
 */

 function format_number(int $number): string {
    return str_pad($number, 3, '0', STR_PAD_LEFT);
}

function mask_phone(string $phone, $simple = false): string
{   
    if($simple) {
        // Remove qualquer caractere não numérico
        $digitos = preg_replace('/\D/', '', $phone);
        
        // Verifica se tem 9 dígitos
        if (strlen($digitos) !== 9) {
            return $phone; // Retorna original se não tiver 9 dígitos
        }
        
        // Aplica a máscara: #####-####
        return substr($digitos, 0, 5) . '-' . substr($digitos, 5);
    }
        // Remove tudo que não for número
        $digits = preg_replace('/\D/', '', $phone);

        if (strlen($digits) === 11) {
            // Celular: (11) 91234-5678
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $digits);
        } elseif (strlen($digits) === 10) {
            // Fixo: (11) 1234-5678
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $digits);
        }

        // Se não for 10 ou 11 dígitos, retorna como está
        return $phone;
}

/**
 * Formats string
 */

function validateCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais (ex: 111.111.111-11)
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Cálculo do primeiro dígito verificador
    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($i = 0; $i < $t; $i++) {
            $soma += $cpf[$i] * (($t + 1) - $i);
        }
        $resto = ($soma * 10) % 11;
        $digito = ($resto == 10) ? 0 : $resto;

        if ($cpf[$t] != $digito) {
            return false;
        }
    }

    return true;
}

function formatCPF($cpf) {
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

function cleanCPF($cpf)
{
    return preg_replace("/\D/", "", $cpf);
}

function validateCNPJ($cnpj) {
    // Remove caracteres não numéricos
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    // Verifica se tem 14 dígitos
    if (strlen($cnpj) != 14) {
        return false;
    }

    // Verifica se todos os dígitos são iguais (CNPJs inválidos)
    if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
        return false;
    }

    // Calcula o primeiro dígito verificador
    $soma = 0;
    $peso = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    for ($i = 0; $i < 12; $i++) {
        $soma += $cnpj[$i] * $peso[$i];
    }

    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    // Calcula o segundo dígito verificador
    $soma = 0;
    $peso = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    for ($i = 0; $i < 13; $i++) {
        $soma += $cnpj[$i] * $peso[$i];
    }

    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    // Verifica se os dígitos estão corretos
    return $cnpj[12] == $digito1 && $cnpj[13] == $digito2;
}

function maskCNPJ($cnpj) {
    // Remove tudo que não for número
    $cnpj = preg_replace('/\D/', '', $cnpj);

    // Verifica se tem 14 dígitos
    if (strlen($cnpj) !== 14) {
        return false; // Ou retorne o próprio CNPJ sem máscara
    }

    // Aplica a máscara
    return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
}

/**
 * Função para estimar linha para gerar documento Word
 */
function estimateHeightLine(string $text): int {
    $characterLine = 60;
    $lineDear = ceil(strlen($text) / $characterLine);
    return max(800, $lineDear * 400);
}

/**
 * Crytion data
 */
function fncEncrypt($value) {

    $key = "lucasthiverysbeautifull";
    $iv = openssl_random_pseudo_bytes(16);
    $step = random_bytes(4);

    $data = $step . $value;

    $crypt = openssl_encrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);

    $payload = base64_encode($iv . $crypt);    

    return rtrim(strtr($payload, "+/", "-_"), "=");
}

function fncDecrypt($hash) {
    
    $key = "lucasthiverysbeautifull";

    $data = base64_decode(strtr($hash, "-_", "+/"));
    
    if (!$data || strlen($data) < 16) {
        return false;
    }

    $iv = substr($data, 0, 16);
    $crypto = substr($data, 16);

    $decrypetd = openssl_decrypt($crypto, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);

    if ($decrypetd === false) {
        return false;
    }

    return substr($decrypetd, 4);
}   