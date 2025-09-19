<?php

namespace Source\Models;

use Source\Core\Model;

class SendEmail extends Model
{
  public function __construct()
  {
    parent::__construct(
      "send_mail", ["id_mail"], 
      [], 
      "id_mail"
    );
  }

  public function photo(): ?string 
  {
    if($this->photo && filter_var(__DIR__ . "/../../" . CONF_UPLOAD_DIR . "/$this->photo")) {
      return $this->photo;
    }
    return null;  
  }

}