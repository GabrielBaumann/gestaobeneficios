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
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=ativo&re=não")
                ->fetch(true)
        ]); 
    }

    // Enviar novos pedidos de cartões para a empresa de confecção de cartão
    public function sendCardCompany(array $data) : void
    {
        // $newSendCard = new CardCard();
        // var_dump($newSendCard->sendCardCompany());
        $this->listExcelSendCard(1);
    }

    // Lista em excel para enviar cartões para empresa e para unidade
    public function listExcelSendCard(int $type = 1) : void
    {   
        // Tipo de lista
        // 1 - Enivar para empresa
        // 2 - Enivar para unidade

        if($type === 1) {
            $listCard = (new Vw_card())->find("status_request = :st AND status_card = :stc AND received = :re", "st=solicitado&stc=aguardando cartão&re=não");
            $listNewCard = $listCard->fetch(true); 
        } else {
            $listCard = (new Vw_card())->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=ativo&re=não");
            $listNewCard = $listCard->fetch(true);
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
    public function sendCardUnit(array $data) : void
    {
        // var_dump($data);
        foreach($data as $key => $value) {
            var_dump(fncDecrypt($value));
        }

        // $newSendCard = new CardCard();
        // var_dump($newSendCard->sendCardUnit());
        // $this->listExcelSendCard(2);
        return;
    }

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}