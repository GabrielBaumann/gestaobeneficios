<?php

namespace Source\Models;

use Source\Core\Model;

class Office extends Model
{
    public function __construct()
    {
        parent::__construct("office",[],[],"id_office");
    }


    // Cria novos números de ofício
    public function createdNewNumberOffice() : bool
    {
        
    }

    // Verficar a quantidade de números e a quantidade solicitada, caso a quantidade solicitada seja menos ou proximo a finalizar gera mais números
    public function lastNumberOffice(int $amountRequest) : array 
    {
        // Quantidade de números livres
        $numberOffice = count((new Office())->find("used = :us","us=0")->fetch(true) ?? []);

        // Quantidade de números solicitados mais o dobro (segurança para não faltar números de ofício)
        $amouteRequestDouble =  $amountRequest * 2;

        if($amouteRequestDouble >= $numberOffice) {
            // var_dump("Gerar mais número de ofício");
            // $this->createdNewNumberOffice();
        }

        // retorna um array com os numeros para uso
        $Office = (new static())->find("used = :us","us=0")->order("number_office")->fetch(true);

        $count = 1;
        foreach($Office as $OfficeItem) {
            $arrayData[] = $OfficeItem;

            $OfficeItem->used = 1;
            $OfficeItem->date_send = date("Y-m-d");
            $OfficeItem->id_user_system_update = 2;
            $OfficeItem->save();

            if($amountRequest == $count) {
                break;
            }
            $count ++;
        }
        return $arrayData;
    }

}
