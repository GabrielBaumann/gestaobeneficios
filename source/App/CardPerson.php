<?php

namespace Source\App;

use DateTime;
use IntlDateFormatter;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Card\Card;
use Source\Models\Card\Views\Vw_card;

class CardPerson extends Controller
{
    private $user;

    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_APP . "/");
        
        // if (!$this->user = Auth::user()) {
        //     $this->message->warning("Efetue login para acessar o sistema.")->flash();
        //     redirect("/");
        // }        
    }

    // Página inicial para o módulo de cartão social
    public function startPage() : void
    {
        echo $this->view->render("/card/start", [
            "menu" => "novo"
        ]); 
    }

    // Página de solicitação de novo cartão
    public function newCard() : void
    {
        echo $this->view->render("/card/start", [
            "menu" => "novocartao"
        ]); 
    }

    // Página de cartões solicitados
    public function requestCard(?array $data) : void
    {   
        if(isset($data["csrf"])) {
           
            $newSendCard = new Card(); 
            if(!$newSendCard->checkListCardRequest()) {
                $json["message"] = messageHelpers()->warning("Erro!")->render();
                echo json_encode($json);
                return;
            }

            $newSendCard->sendCardCompany();

            $html = $this->view->render("/card/requestCard", [
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND status_card = :stc AND received = :re", "st=solicitado&stc=aguardando cartão&re=não")
                ->fetch(true)
            ]);  
            
            $json["redirected"] = url("/baixar/1");
            $json["html"] = $html;
            $json["message"] = messageHelpers()->success("Lista gerada com sucesso!")->render();
            echo json_encode($json);
            return;
        }
        
        echo $this->view->render("/card/start", [
            "menu" => "soliticao",
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND status_card = :stc AND received = :re", "st=solicitado&stc=aguardando cartão&re=não")
                ->fetch(true)
        ]);            
    }

    // Pagina com lista de enviados para a confecção
    public function sendCard(?array $data) : void
    {   
        if(isset($data["csrf"])) {

            $newSendCard = new Card();
            foreach($data as $key => $value) {
                $string = explode("-", $key);
                if($string[0] === "received") {
                    $newSendCard->sendCardUnit((int)fncDecrypt($value));
                }
            }

            $html = $this->view->render("/card/sendCard", [
                "menu" => "enviado",
                "listCardName" => (new Vw_card())
                    ->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=confecção&re=não")
                    ->fetch(true)
            ]); 

            $json["html"] = $html;
            $json["redirected"] = url("/baixar/2");
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "menu" => "enviado",
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=confecção&re=não")
                ->fetch(true)
        ]);             
    }

    public function cardActive() : void
    {
        echo $this->view->render("/card/start", [
            "menu" => "cartao",
            "listCardName" => (new Vw_card())
                ->find("received = :re AND send_card_unit = :se", "re=sim&se=sim")
                ->fetch(true)
        ]);           
    }

    // Lista em excel para enviar cartões para empresa e para unidade
    public function listExcelSendCard($data) : void
    {   
        // Tipo de lista
        // 1 - Enivar para empresa
        // 2 - Enivar para unidade

        if($data["type"] == 1) {
            $newSendCard = new Card(); 
            $listCard = (new Vw_card())->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=aguardando cartão&re=não");
            $listNewCard = $listCard->fetch(true);
            $newSendCard->sendCardCompany(true);
        } else {
            $listCard = (new Vw_card())->find("received = :re AND send_card_unit = :se", "re=sim&se=não");
            $listNewCard = $listCard->fetch(true);
            
            foreach($listNewCard as $listNewCardItem) {
                $newSendCard = (new Card())->findById($listNewCardItem->id_card);
                $newSendCard->send_card_unit = "sim";
                $newSendCard->save();
            }
        }

        // Criar planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Mesclar células da primeira linha
        $sheet->mergeCells("A1:B1");

        // Definir título
        $sheet->setCellValue("A1","PLANILHA DE NOVOS CARTÕES");
        $sheet->getStyle("A1")->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 14,
            ],
            "alignment" => [
                "horizontal" => Alignment::HORIZONTAL_CENTER,
                "vertical" => Alignment::VERTICAL_CENTER,
            ],
            "fill" => [
                "fillType" => Fill::FILL_SOLID,
                "startColor" => ["rgb" => "B0C4DE"],
            ],
        ]);

        // Cabeçalhos
        $sheet->setCellValue("A2", "NOME");
        $sheet->setCellValue("B2", "CPF");

        $sheet->getStyle("A2:B2")->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 12,
            ],
            "alignment" => [
                "horizontal" => Alignment::HORIZONTAL_CENTER,
                "vertical" => Alignment::VERTICAL_CENTER,
            ],
            "fill" => [
                "fillType" => Fill::FILL_SOLID,
                "startColor" => ["rgb" => "EEEEEE"]
            ]
        ]);

        // Dados
        $count = 3;
        foreach($listNewCard as $listNewCardItem) {

            $sheet->setCellValue("A{$count}", $listNewCardItem->name);
            $sheet->setCellValueExplicit("B{$count}", $listNewCardItem->cpf, DataType::TYPE_STRING);
            $count ++;
        }

        $lastLine = $count - 1;
        $step = "A1:B{$lastLine}";

        $sheet->getStyle($step)->applyFromArray([
            "borders" => [
                "allBorders" => [
                    "borderStyle" => Border::BORDER_THIN,
                    "color" => ["rgb" => "000000"],
                ],
            ],
        ]);

        // Preparar download
        $filename = "Lista de Cartões_" . date_simple(date("Y-m-d")) . ".xlsx";

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");
        
        // Enviar arquivo
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
        return;       
    }

    public function listExcelSendCardRecharge() : void
    {
        if (!(new Card())->sendRecharge()) {
            var_dump("Não há lista");
            return;
        }

        $month = new DateTime();

        $format = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN,
            "MMMM"
        );

        $monthUpper = mb_strtoupper($format->format($month));

        $listRecharge = (new Card())->sendRecharge();

        // Criar planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Mesclar células da primeira linha
        $sheet->mergeCells("A1:B1");
        $sheet->mergeCells("A2:B2");

        // Definir título
        $sheet->setCellValue("A1","LISTA DE USUÁRIOS QUE IRÃO PERMANCER NO MÊS DE " . $monthUpper . "/" . date("Y"));
        $sheet->getStyle("A1")->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 12,
                "name" => "Arial",
            ],
            "alignment" => [
                "horizontal" => Alignment::HORIZONTAL_CENTER,
                "vertical" => Alignment::VERTICAL_CENTER,
            ],
            "fill" => [
                "fillType" => Fill::FILL_SOLID,
                "startColor" => ["rgb" => "B0C4DE"],
            ],
        ]);

        // Sub título
        $sheet->setCellValue("A2","CARTÃO SOCIAL - WEB CARD");
        $sheet->getStyle("A2")->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 12,
                "name" => "Arial",
            ],
            "alignment" => [
                "horizontal" => Alignment::HORIZONTAL_CENTER,
                "vertical" => Alignment::VERTICAL_CENTER,
            ],
            "fill" => [
                "fillType" => Fill::FILL_SOLID,
                "startColor" => ["rgb" => "EEEEEE"],
            ],
        ]);

        // Cabeçalhos
        $sheet->setCellValue("A3", "NOME");
        $sheet->setCellValue("B3", "CPF");

        $sheet->getStyle("A3:B3")->applyFromArray([
            "font" => [
                "size" => 12,
                "name" => "Arial",
            ],
            "alignment" => [
                "horizontal" => Alignment::HORIZONTAL_CENTER,
                "vertical" => Alignment::VERTICAL_CENTER,
            ],
            "fill" => [
                "fillType" => Fill::FILL_SOLID,
                "startColor" => ["rgb" => "EEEEEE"]
            ]
        ]);

        // Dados
        $count = 4;
        foreach($listRecharge as $listRechargeItem) {

            $sheet->setCellValue("A{$count}", $listRechargeItem->name);
            $sheet->setCellValue("B{$count}", $listRechargeItem->cpf);
            // $sheet->setCellValueExplicit("B{$count}", $listRechargeItem->cpf, DataType::TYPE_STRING);
            $count ++;
        }

        $lastLine = $count - 1;
        $step = "A1:B{$lastLine}";

        $sheet->getStyle($step)->applyFromArray([
            "borders" => [
                "allBorders" => [
                    "borderStyle" => Border::BORDER_THIN,
                    "color" => ["rgb" => "000000"],
                ],
            ],
        ]);

        // Preparar download
        $filename = "Cartão Social DESBLOQUEIO " . $monthUpper . " - ". date("Y") .".xlsx";

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");
        
        // Enviar arquivo
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
        return;       
    }

    // Enviar cartões para as unidades
    // public function sendCardUnit(array $data) : void
    // {
    //     $newSendCard = new Card();
    //     // var_dump($newSendCard->sendCardUnit());
    //     $dataCard = [];
    //     foreach($data as $key => $value) {
    //         $string = explode("-", $key);
    //         if($string[0] === "received") {
    //             var_dump($newSendCard->sendCardUnit((int)fncDecrypt($value)));
    //         }
    //     }

    //     $json["redirected"] = url("/baixar/2");
    //     echo json_encode($json);
    //     return;
    // }

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}