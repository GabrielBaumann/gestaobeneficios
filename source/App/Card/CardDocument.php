<?php

namespace Source\App\Card;

use DateTime;
use IntlDateFormatter;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Source\Core\Controller;
use Source\Models\Card\Card;
use Source\Models\Card\CardBalance;
use Source\Models\Card\CardNotFound;
use Source\Models\Card\Views\Vw_recharge;
use Source\Models\Card\Views\Vw_request;
use Source\Models\Unit\Unit;
use Source\Support\Upload;

class CardDocument extends Controller
{
    private $user;

    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");
        
        // if (!$this->user = Auth::user()) {
        //     $this->message->warning("Efetue login para acessar o sistema.")->flash();
        //     redirect("/");
        // }        
    }


    // Ofício gerado nas solicitações
    public function documentOffice (array $data) : void
    {
        $type = $data["type"];
        $idOffice = (int)$data["office"];
        
        switch($type) {
            
            case "sendcompanyrecharge":
            $dataType = (new Vw_recharge())->dataOfficeRecharge($idOffice);
            $unit = $dataType["unit"];
            $datenow = $dataType["dataSend"];
            $title = $dataType["title"];
            $office = $dataType["numberOffice"];
            
            break;

            case "sendcompany":
                $dataType = (new Vw_request())->dataOfficeSendCompany(($idOffice));
                $datenow = $dataType["dataSend"];
                $title = $dataType["title"];
                $office = $dataType["numberOffice"];
                break;

            case "emergency":
                $dataType = (new Vw_request())->find("office = :id","id={$idOffice}")->fetch();
                $datenow = date_complete_string($dataType->date_send);
                $title = "Ofício Emergencial - " . format_number($dataType->number_office);
                $office = format_number($dataType->number_office);
                $unit = $dataType->abbreviation_unit;
            default:
            break;
        }

        echo $this->view->render("/letter/letter", [
            "dateNow" => $datenow,
            "dataDocument" => $dataType,
            "typedocument" => $type,
            "title" => $title,
            "numberOffice" => $office,
            "unit" => $unit ?? null
        ]);
    }

    // Lista em excel para enviar cartões para empresa e para unidade
    public function listExcelSendCard(array $data) : void
    {   
        $listNewCard = (new Vw_request())->dataOfficeSendCompanyList((int)$data["office"]);

        // Criar planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setTitle("Usuários");

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

            $sheet->setCellValue("A{$count}", $listNewCardItem->name_benefit);
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

        // Ajuste automático de largura
        foreach(range("A", "B") as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Preparar download
        $filename = "Lista de Cartões_" . date_simple(date("Y-m-d")) . ".xlsx";

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");
        
        // Enviar arquivo
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
        unset($_SESSION["dataExcel"]);
        return;       
    }

    // Ofício para unidades
    public function documentOfficeUnit(array $data) : void
    {
        echo $this->view->render("/letter/letterSendUnit", [
            "title" => "Ofícios para unidades",
            "dataDocument" => (new Vw_request())->dataShipment((int)$data["shipment"])
        ]);
    }

    // Lista em excel de recarga do mês
    public function listExcelRecharge(array $data) : void
    {
        $listRecharge = (new Vw_recharge())->listRecharge($data["office"]);
        $monthToString = $listRecharge[0]->month_recharge;
        
        // Criar planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setTitle("Geral");

        // Mesclar células da primeira linha
        $sheet->mergeCells("A1:B1");

        // Definir título
        $sheet->setCellValue("A1","LISTA DE USUÁRIOS QUE IRÃO PERMANCER NO MÊS DE " . fncMonthString($monthToString));
        $sheet->getStyle("A1")->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 12,
            ],
            "alignment" => [
                "horizontal" => Alignment::HORIZONTAL_CENTER,
                "vertical" => Alignment::VERTICAL_CENTER,
            ],

        ]);

        // SubTítulo
        $sheet->mergeCells("A2:B2");
        $sheet->setCellValue("A2","CARTÃO SOCIAL - WEB CARD");
        $sheet->getStyle("A2")->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 12,
            ],
            "alignment" => [
                "horizontal" => Alignment::HORIZONTAL_CENTER,
                "vertical" => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Cabeçalhos
        $sheet->setCellValue("A3", "NOME");
        $sheet->setCellValue("B3", "CPF");

        $sheet->getStyle("A3:B3")->applyFromArray([
            "font" => [
                "size" => 12,
            ],
            "alignment" => [
                "horizontal" => Alignment::HORIZONTAL_CENTER,
                "vertical" => Alignment::VERTICAL_CENTER,
            ],
            "fill" => [
                "fillType" => Fill::FILL_SOLID,
                "startColor" => ["rgb" => "538DD5"]
            ]
        ]);

        // Dados
        $count = 4;
        foreach($listRecharge as $listRechargeItem) {

            $sheet->setCellValue("A{$count}", $listRechargeItem->name_benefit);
            $sheet->setCellValueExplicit("B{$count}", $listRechargeItem->cpf, DataType::TYPE_STRING);
            
            $sheet->getStyle("A{$count}:B{$count}")->applyFromArray([
                "alignment" => [
                    "horizontal" => Alignment::HORIZONTAL_CENTER,
                    "vertical" => Alignment::VERTICAL_CENTER,
                ]
            ]);
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

        // Ajuste automático de largura
        foreach(range("A", "B") as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Preparar download
        $filename = "Cartão Social DESBLOQUEIO " . fncMonthString($monthToString) . " - " . date("Y") . ".xlsx";

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");
        
        // Enviar arquivo
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
        unset($_SESSION["dataExcel"]);
        return;
    }


    public function listExcelSendCardRecharge() : void
    {
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

    // Baixar lista excel de usuarários que tem saldo, mas não estão no sistema
    public function downloadsListExcel(array $data) : void
    {   
        $month = $data["month"];

        $json["redirected"] = url("/documentocartao/baixarnaoencontrado/{$month}");
        $json["status"] = true;
        echo json_encode($json);
        return;
    }

    // Lista de usuário não encontrado na lista de pagamentos
    public function listNotFoundDownload(array $data) : void
    {
        $listNotFound = (new CardNotFound())
            ->find("month_reference = :mo", "mo={$data["month"]}")
            ->order("name")
            ->fetch(true);

        // Criar planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setTitle("Not_found_balance");

        // Mesclar células da primeira linha
        $sheet->mergeCells("A1:C1");

        // Definir título
        $sheet->setCellValue("A1","USUÁRIOS NÃO ENCONTRADOS");
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
        $sheet->setCellValue("C2", "VALOR");

        $sheet->getStyle("A2:C2")->applyFromArray([
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
        foreach($listNotFound as $listNotFoundItem) {

            $sheet->setCellValue("A{$count}", $listNotFoundItem->name);
            $sheet->setCellValueExplicit("B{$count}", $listNotFoundItem->cpf, DataType::TYPE_STRING);
            $sheet->setCellValue("C{$count}", $listNotFoundItem->value);
            $sheet->getStyle("C{$count}")
                ->getNumberFormat()
                ->setFormatCode('"R$" #,##0.00;[Red]"R$" -#,##0.00');
            $count ++;

        }

        $lastLine = $count - 1;
        $step = "A1:C{$lastLine}";

        $sheet->getStyle($step)->applyFromArray([
            "borders" => [
                "allBorders" => [
                    "borderStyle" => Border::BORDER_THIN,
                    "color" => ["rgb" => "000000"],
                ],
            ],
        ]);

        // Ajuste automático de largura
        foreach(range("A", "C") as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

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

    // Baixar tabela com todos os usuário de suas unidades por aba do excel
    public function listExcelUnitSend(array $data) : void
    {
        $dataRequest = (new Vw_request())->dataShipmentList((int)$data["shipment"]);

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

        // Criar planilha
        $spreadsheet = new Spreadsheet();
        
        $first = true;
        foreach($dataRequest as $key => $value) {
            $unit = (new Unit())->findById((int)$key);

            if($first) {
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle($unit->abbreviation_unit);
                $first = false;
            } else {
                $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $key);
                $sheet->setTitle($unit->abbreviation_unit);
                $spreadsheet->addSheet($sheet);
            }

            // Mesclar células da primeira linha
            $sheet->mergeCells("A1:B1");
            $sheet->mergeCells("A2:B2");

            // Definir título
            $sheet->setCellValue("A1","LISTA DE CARTÕES DO MÊS DE " . $monthUpper . "/" . date("Y"));
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

            // Cabeçalhos
            $sheet->setCellValue("A2", "NOME");
            $sheet->setCellValue("B2", "CPF");

            $sheet->getStyle("A2:B2")->applyFromArray([
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
            $count = 3;
            foreach($value as $valueItem) {

                $sheet->setCellValue("A{$count}", $valueItem->name_benefit);
                $sheet->setCellValue("B{$count}", $valueItem->cpf);
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

            // Ajuste automático de largura
            foreach(range("A", "B") as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        $spreadsheet->setActiveSheetIndex(0);

        // Preparar download
        $filename = "Lista para Unidades " . $monthUpper . " - ". date("Y") .".xlsx";

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");
        
        // Enviar arquivo
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
        unset($_SESSION["dataexcel"]);
        return;       
    }

    // Receber lista de excel para atualizar o saldo
    public function uploadExcel($data) : void
    {
        $upload = new Upload();
   
        if (isset($data["valid"])) {

            if (empty($_FILES["list-xls"]["name"])) {
                $json["message"] = messageHelpers()->warning("Não há arquivo anexado!")->render();
                echo json_encode($json);
                return;
            }

            $dataClean = cleanInputData($data);

            if (empty($dataClean["valid"])) {
                $json["message"] = messageHelpers()->warning("Selecione um mês de pagamento!")->render();
                echo json_encode($json);
                return;
            }

            $fileType = $_FILES["list-xls"]["type"];
           
            $allowed = [
                "application/vnd.ms-excel", // XLS
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" // XLSX            
            ];

            if (!in_array($fileType, $allowed)) {
                $json["message"] = messageHelpers()->warning("O formato do arquivo deve ser em xls (Excel)!")->render();
                echo json_encode($json);
                return;
            }

            $json["status"] = true;
            echo json_encode($json);            
            return;
        }

            $dataClean = cleanInputData($data);
            $month = (int)$dataClean["data"]["month"];

            $locationFile = ("storage/uploads/" . $upload->file($_FILES["list-xls"], "lista"));

            //  ----------- LER O EXCEL -------------
            $spread = IOFactory::load($locationFile);
            $sheet = $spread->getActiveSheet();
            $rows = $sheet->toArray();

            $i = 0;
            $arrayAll = [];
            
            foreach($rows as $rowsitem) {
                $arrayAll[$i]= $rows[$i][0]  . " ; " . $rows[$i][1];
                $i++;
            }
            
            $lastElement = array_pop($arrayAll);
            $twoElemente = array_pop($arrayAll);
            $firstElemente = array_shift($arrayAll);

            $firstElemente = str_replace(["\r", "\n"], "", $firstElemente);           
            $firstElementeVer = explode(";", $firstElemente);

            // Verifica se a planilha é a planilha de pagamento correta
            if (trim($firstElementeVer[0]) !== "PagamentosFatura") {
                $json["message"] = messageHelpers()->warning("Verfique a planilha enviada, erro no formato de dados!")->render();
                echo json_encode($json);
                return;
            }

            $cardBalance = new CardBalance();
            $listNotFound = $cardBalance->checkedListExcel($arrayAll, $month);
                
            if ($listNotFound) {

                $html = $this->view->render("/modal/modalList", [
                    "title" => $data["title"] ?? "Confirmar Ação",
                    "textMessage" => $data["text"] ?? " teste",
                    "listFound" => $listNotFound
                ]);
                
                $upload->remove($locationFile);

                $json["modal"] = $html;
                $json["status"] = true;
                echo json_encode($json);
                return;
            }

        $listNotFound = $cardBalance->balanceCard($arrayAll, $month);
        $upload->remove($locationFile);

        $json["message"] = messageHelpers()->warning("Saldos atualizados com sucesso!")->render();
        echo json_encode($json);
        return;
    }

}