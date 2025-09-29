<?php

namespace Source\Core;

use Source\Support\Message;

class Controller
{
    protected $view;
    protected $message;

    public function __construct(?string $pathToViews = null)
    {
        $this->view = new View($pathToViews);
        $this->message = new Message();
    }
}