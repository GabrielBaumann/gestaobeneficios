<?php

namespace Source\Core;

use Source\Support\Message;

class Session
{
    private $timeout;
    
    /**
     * Session constructor.
     */
    public function __construct()
    {
        // $this->initSession();

        if (!session_id()) {
            session_start();
        }
    }

    public function initSession($timeoutMinutes = 30)
    {
        $this->timeout = $timeoutMinutes * 60;
        // Iniciar sessão
        if (session_status() === PHP_SESSION_NONE) {
            // Configurações de sessão
            ini_set('session.gc_maxlifetime', $this->timeout);
            session_set_cookie_params($this->timeout);
            session_start();
        }

        $this->checkTimeout();
        $this->updateActive();
        $this->regenerate();

    }


    // Verifica se a sessão expirou por inatividade
    private function checkTimeout()
    {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $this->timeout)) {
            $this->destroy();
            header('Location: '. CONF_URL_TEST);
            exit;
        }
    }

    public function updateActive() 
    {
        $_SESSION['LAST_ACTIVITY'] = time();    
    }

    /**
     * @param $name
     * @return null|mixed
     */
    public function __get($name)
    {
        if (!empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return $this->has($name);
    }

    /**
     * @return null|object
     */
    public function all(): ?object
    {
        return (object)$_SESSION;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Session
     */
    public function set(string $key, $value): Session
    {
        $_SESSION[$key] = (is_array($value) ? (object)$value : $value);
        return $this;
    }

    /**
     * @param string $key
     * @return Session
     */
    public function unset(string $key): Session
    {
        unset($_SESSION[$key]);
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {   
        $this->initSession();
        return isset($_SESSION[$key]);
    }

    /**
     * @return Session
     */
    public function regenerate(): Session
    {
        if (!isset($_SESSION["CREATED"])) {
            $_SESSION["CREATED"] = time();
        } elseif (time() - $_SESSION["CREATED"] > $this->timeout) {
            session_regenerate_id(true);
            $_SESSION["CREATED"] = time();
        }
        return $this;
    }

    /**
     * @return Session
     */
    public function destroy(): Session
    {
        session_destroy();
        return $this;
    }

    /**
     * @return null|Message
     */
    public function flash(): ?Message
    {
        if ($this->has("flash")) {
            $flash = $this->flash;
            $this->unset("flash");
            return $flash;
        }
        return null;
    }

    /**
     * CSRF Token
     */
    public function csrf(): void
    {
        $_SESSION['csrf_token'] = md5(uniqid(rand(), true));
    }
}