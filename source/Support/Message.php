<?php

namespace Source\Support;

use Source\Core\Session;

class Message
{
/** @var string */
private string $text;

private string $color;

private string $icon;

private string $colorTitle;

private string $title;

private string $colorText;

private string $borderColor;

private bool $info = false;

/** @var string */
// private string $type;

private string $before;

private string $after;

/**
 * @return string
 */
public function __toString()
{
    return $this->render();
}

/**
 * @return string
 */
public function getText(): ?string
{
    return $this->before . $this->text . $this->after;
}

/**
 * @return string
 */
// public function getType(): ?string
// {
//     return $this->type;
// }

public function before(string $text) : Message
{
    $this->before = $text;
    return $this;
}

public function after(string $text) : Message
{
    $this->after = $text;
    return $this;    
}

/**
 * @param string $message
 * @return Message
 */
public function info(string $message, string $title = "Mais Informações"): Message
{
    // $this->type = CONF_MESSAGE_BUTTON;
    $this->text = $this->filter($message);
    $this->title = $this->filter($title);
    $this->color = 'border-blue-100';
    $this->icon = 'fa-info-circle text-blue-500';
    $this->colorTitle = 'text-blue-800';
    $this->colorText = 'text-blue-600';
    $this->borderColor = 'bg-blue-100';
    $this->info = true;
    return $this;
}

/**
 * @param string $message
 * @return Message
 */
public function success(string $message, string $title = "Sucesso"): Message
{
    // $this->type = CONF_MESSAGE_SUCCESS;
    $this->text = $this->filter($message);
    $this->title = $this->filter($title);
    $this->color = 'border-green-100';
    $this->icon = 'fa-check-circle text-green-500';
    $this->colorTitle = 'text-green-800';
    $this->colorText = 'text-green-600';
    $this->borderColor = 'bg-green-100';
    return $this;
}

/**
 * @param string $message
 * @return Message
 */
public function warning(string $message, string $title = "Atenção"): Message
{
    // $this->type = CONF_MESSAGE_WARNING;
    $this->text = $this->filter($message);
    $this->title = $this->filter($title);
    $this->color = 'border-yellow-100';
    $this->icon = 'fa-exclamation-triangle text-yellow-500';
    $this->colorTitle = 'text-yellow-800';
    $this->colorText = 'text-yellow-600';
    $this->borderColor = 'bg-yellow-100';
    return $this;
}

/**
 * @param string $message
 * @return Message
 */
public function error(string $message, string $title = "Erro"): Message
{
    // $this->type = CONF_MESSAGE_ERROR;
    $this->text = $this->filter($message);
    $this->title = $this->filter($title);
    $this->color = 'border-red-100';
    $this->icon = 'fa-times-circle text-red-500';
    $this->colorTitle = 'text-red-800';
    $this->colorText = 'text-red-600';
    $this->borderColor = 'bg-red-100';
    return $this;
}

/**
 * @return string
 */
public function render(): string
{

    if($this->info === true) {
        return '
        <div class="alert-container space-y-3">
            <div class="alert-message bg-white border ' . $this->color . ' rounded-lg overflow-hidden">
                <div class="flex items-start p-4">
                    <div class="flex-shrink-0 pt-0.5">
                        <div class="h-8 w-8 rounded-full ' . $this->borderColor . ' flex items-center justify-center">
                            <i class="fas ' . $this->icon . ' text-lg"></i>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-semibold ' . $this->colorTitle . '">' . $this->title . '</h3>
                        <div class="mt-1 text-sm ' . $this->colorText . '">
                            <p>' . $this->text . '</p>
                        </div>
                    </div>
                    <button id="botao" class="ml-2 text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="bg-blue-50 px-4 py-2.5 border-t border-blue-100">
                    <button id="info" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                        Ver detalhes
                    </button>
                </div>
            </div>
        </div>
        ';
    }

    return '
    <div class="alert-container space-y-3">
        <div class="alert-message bg-white border ' . $this->color . ' rounded-lg overflow-hidden">
            <div class="flex items-start p-4">
                <div class="flex-shrink-0 pt-0.5">
                    <div class="h-8 w-8 rounded-full ' . $this->borderColor . ' flex items-center justify-center">
                        <i class="fas ' . $this->icon . ' text-lg"></i>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-semibold ' . $this->colorTitle . '">' . $this->title . '</h3>
                    <div class="mt-1 text-sm ' . $this->colorText . '">
                        <p>' . $this->text . '</p>
                    </div>
                </div>
                <button id="button-close" class="ml-2 text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    ';
}

/**
 * @return string
 */
public function json(): string
{
    return json_encode(["error" => $this->getText()]);
}

/**
 * Set flash Session Key
 */
public function flash(): void
{
    (new Session())->set("flash", $this);
}

/**
 * @param string $message
 * @return string
 */
private function filter(string $message): string
{
    return filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}
}