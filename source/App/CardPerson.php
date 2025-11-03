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
use Source\Models\Card\RequestCard;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\Views\Vw_card_canceled;
use Source\Models\Card\Views\Vw_recharge;
use Source\Models\Card\Views\Vw_request;
use Source\Models\Office;
use Source\Models\PersonBenefit;
use Source\Models\Unit;

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
            "title" => "Cartão Alimentação",
            "menu" => "novo"
        ]); 
    }

    // Seguda via e cartãp
    public function secondCard(array $data) : void 
    {
        if(isset($data["person-benefit"])) {
            $secundCard = new RequestCard();
            $secundCard->secondCard($data);

            if(!$secundCard) {
                $json["message"] = $secundCard->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $secundCard->message()->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Solicitar 2ª Via",
            "menu" => "segundavia",
            "personbenefit" => (new Vw_card_canceled())->find()->order("name_benefit")->limit(5000)->fetch(true)
        ]);
    }

    // Recarga
    public function recharge() : void 
    {
        echo $this->view->render("/card/start", [
            "title" => "Recarga",
            "menu" => "recarga",
            "listRecharge" => (new Vw_recharge())->find("id_card_recharge_fixed <> :id", "id=0")->fetch(true),
            "yearRecharge" => (new Vw_recharge())->showYearRecharge(),
            "monthRecharge" => (new Vw_recharge())->showMonthRecharge()
        ]);
    }

    // Gerar recarga
    public function generateRecharge(array $data) :  void
    {
        var_dump($data);
    }


    // Procurar recargas
    public function searchRecharge(array $data) : void
    {
        // Verifica se os campos de pesquisa estão vazios
        $dataEmptyInput = count(cleanInputData($data)["errors"]);
        $allInput = count($data);
        
        if($dataEmptyInput === $allInput) {
            echo json_encode("Todo os campos estão vazios não fazer pesquisa");
            return;
        }

        // Fazer a pesquisa e devolve os valores
        $searchRecharg = (new Vw_recharge())->searchRecharg(cleanInputData($data)["data"]);
        var_dump($searchRecharg);
    }

    public function rechargeExtra() : void 
    {
        echo $this->view->render("/card/start", [
            "menu" => "recarga"
        ]);
    }

    // Página de solicitação de novo cartão
    public function newCard() : void
    {
        echo $this->view->render("/card/start", [
            "menu" => "novocartao",
            "personbenefit" => (new PersonBenefit())->find()->order("name_benefit")->limit(5000)->fetch(true)
        ]); 
    }

    // Página de cartões solicitados
    public function requestCard(?array $datall) : void
    {  
        if(isset($datall["csrf"])) {

            if(empty($datall["date-month"])) {
                $json["message"] = messageHelpers()->warning("Selecione um mês!")->render();
                echo json_encode($json);
                return;
            }

            if(isset($datall["btn-send"])) {
                $month = $_SESSION["month"] = $datall["date-month"];
            } else {
                $month = $_SESSION["month"];
            }

            $newSendCard = new Card(); 
            if(!$newSendCard->checkListCardRequest()) {
                $json["message"] = messageHelpers()->warning("Erro!")->render();
                echo json_encode($json);
                return;
            }

            // Modal quest
            if(isset($data["btn-send"])) {
                $url = url("/solicitado");
                $this->modalQuest($url);
                return;
            }

            // Sessão que recebe os dados para ofício
            $numberOffice = (new Office())->lastNumberOffice(1)[0];
            $newSendCard = (new Card())->sendCardCompany($numberOffice->id_office, $month);

            $html = $this->view->render("/card/requestCard", [
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND status_card = :stc AND received = :re", "st=solicitado&stc=aguardando cartão&re=não")
                ->fetch(true)
            ]);  
            
            $json["redirectedBlank"] = url("/documento/$numberOffice->id_office/sendcompany");
            $json["redirected"] = url("/baixarexcelempresa/$numberOffice->id_office");
            $json["html"] = $html;
            $json["message"] = messageHelpers()->success("Lista gerada com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Solicitação de Cartão",
            "menu" => "solicitacao",
            "monthAll" => fncMonthAll(),
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND status_card = :stc AND received = :re", "st=solicitado&stc=aguardando cartão&re=não")
                ->fetch(true)
        ]);            
    }

    // Pagina com lista de enviados para a confecção
    public function sendCard(?array $datall) : void
    {   
        
        if(isset($datall["csrf"])) {

            if(isset($datall["btn-send"])) {
                $data = $_SESSION["data"] = $datall;
            } else {
                $data = $_SESSION["data"];
            }

            $countInput = 0;
            foreach ($data as $key => $value) {
                $string = explode("-", $key);
                if($string[0] === "received") {
                    $countInput ++;
                }
            }
            
            if ($countInput === 0) {
                $json["message"] = messageHelpers()->warning("Não há dados marcados!")->render();
                echo json_encode($json);
                return; 
            }

            // Modal quest
            if(isset($datall["btn-send"])) {
                $url = url("/enviado");
                $this->modalQuest($url);
                return;
            }

            // Dá baixa nos cartões para ficarem como enviados as unidades
            $newSendCard = (new Card())->sendCardUnit($data);
            
            $vwCard = new Vw_card();
            $arraycard = [];

            // Agrupa as solicitações por unidade
            foreach($data as $key => $value) {
                $string = explode("-", $key);

                if($string[0] === "received") {
                    $idCard = (int)fncDecrypt($value);
                    $cardAll = $vwCard->find("id_card = :id","id={$idCard}")->fetch();

                    $unidade = $cardAll->id_unit;

                    if ($unidade) {
                        if (!isset($arraycard[$unidade])) {
                            $arraycard[$unidade] = [];
                        }
                    }
                    $arraycard[$unidade][] = $cardAll; 
                }
            }

            // Número de remessa
            $shipment = (new RequestCard())->lastNumberShipment();

            // Emitir ofício e planilha excel
            $lastKey = null;
            foreach($arraycard as $key => $values) {

                foreach($values as $item) {

                    if($lastKey !== $item->id_unit) {
                        
                        $numberoffice = (new Office())->lastNumberOffice(1)[0]->id_office;
                        $lastKey = $item->id_unit;
                    }
                    $checkOffice = (new Card())->sendUnitOffice($item->id_card_request, $numberoffice, $shipment);
                }
            }

            unset($_SESSION["data"]);

            $html = $this->view->render("/card/sendCard", [
                "menu" => "enviado",
                "listCardName" => (new Vw_card())
                    ->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=confecção&re=não")
                    ->fetch(true)
            ]); 

            $json["html"] = $html;
            $json["redirectedBlank"] = url("/documentounidade/$shipment");
            $json["redirected"] = url("/baixarexcelunidade/$shipment");
            echo json_encode($json);           
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Enviados",
            "menu" => "enviado",
            "listCardName" => (new Vw_card())
                ->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=confecção&re=não")
                ->fetch(true)
        ]);             
    }

    // Cartões ativos
    public function cardActive() : void
    {
        echo $this->view->render("/card/start", [
            "title" => "Cartão Ativo",
            "menu" => "cartao",
            "listCardName" => (new Vw_card())
                ->find("received = :re AND send_card_unit = :se", "re=sim&se=sim")
                ->fetch(true)
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

    // Solicitar cartão emergencial
    public function requestEmergency(?array $data) : void
    {

        if (isset($data["csrf"])) {

            // Armazena dados
            if(isset($data["btn-send"])) {
               $dataAll = $_SESSION["data"] = $data;
            } else {
                $dataAll = $_SESSION["data"];
            }

            $requestCard = new RequestCard();

            if(!$requestCard->checkRequest($dataAll)) {
                $json["message"] = $requestCard->message()->render();
                echo json_encode($json);
                return;
            }

            // Modal quest
            if(isset($data["btn-send"])) {
                $this->modalQuest(url("/cartaoemergencial"));
                return;
            }

            $newRequestEmergency = new RequestCard();
            $dataRequest = $newRequestEmergency->requestEmergency($dataAll);
            
            unset($_SESSION["data"]);

            $json["message"] = $newRequestEmergency->message()->render();
            $json["redirectedBlank"] = url("/documento/{$dataRequest["idoffice"]}/emergency");
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "menu" => "emergencial",
            "title" =>  "Emergencial"
        ]);
    }

    // Lista de cartões emergenciais solicitados
    public function listEmergency() : void
    {



        echo $this->view->render("/card/start", [
            "menu" => "listacartaoemergencial",
            "title" =>  "Emergencial",
            "listCardName" => (new Vw_request())->find("type_request = :id","id=emergencial")->fetch(true)
        ]);        
    }

    // Modal quest
    public function modalQuest($url = null) : void
    {
        
        $html = $this->view->render("/modal/modalQuest", [
            "title" => "Confirmar Ação",
            "textMessage" => "Tem certeza que deseja encaminhar essa lista!",
            "urlYes" => $url,
            "urlNo" => null,
            "cancel" => true
        ]);

        $json["modal"] = $html;
        echo json_encode($json);
        return;
    }

    // Ofício gerado nas solicitações
    public function documentOffice (array $data) : void
    {
        $type = $data["type"];
        $idOffice = (int)$data["office"];

        switch($type) {
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

    // Ofício para unidades
    public function documentOfficeUnit(array $data) : void
    {
        echo $this->view->render("/letter/letterSendUnit", [
            "title" => "Ofícios para unidades",
            "dataDocument" => (new Vw_request())->dataShipment((int)$data["shipment"])
        ]);
    }

    public function error() : void
    {
        echo $this->view->render("/PageError/error", [
        ]);
    }
}