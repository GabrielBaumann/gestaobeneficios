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
use Source\Models\Card\CardRecharge;
use Source\Models\Card\RequestCard;
use Source\Models\Card\Views\Vw_card;
use Source\Models\Card\Views\Vw_card_canceled;
use Source\Models\Card\Views\Vw_recharge;
use Source\Models\Card\Views\Vw_request;
use Source\Models\Office;
use Source\Models\PersonBenefit;
use Source\Models\Unit\Unit;
use Source\Models\UserSystem\UnitUserSystem;

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
            "listRecharge" => (new Vw_recharge())
                ->find("id_card_recharge_fixed <> :id", "id=0")
                ->fetch(true),
            "yearRecharge" => (new Vw_recharge())
                ->showYearRecharge(),
            "monthRecharge" => (new Vw_recharge())
                ->showMonthRecharge(),
            "shipmentRecharge" => (new Vw_recharge())
                ->showShipmentRecharge()
        ]);
    }

    // Gerar recarga
    public function generateRecharge(array $data) :  void
    {
        // Creditar valores da recarga do mês e retorna o número da remessa de envio
        $creditRecharge = (new Vw_recharge())->creditRecharge($data);
        $numberOffice = $creditRecharge["numberOffice"];

        $html = $this->view->render("/card/listRecharge",[
            "listRecharge" => (new Vw_recharge())
                ->find("id_card_recharge_fixed <> :id", "id=0")
                ->fetch(true)
        ]);

        $json["html"] = $html;
        $json["contentajax"] = "ajax-update";
        $json["redirectedBlank"] = url("/documento/$numberOffice/sendcompanyrecharge");
        $json["redirected"] = url("/baixarexcelerecarga/$numberOffice");
    
        echo json_encode($json);           
        return;
    }

    // Procurar recargas
    public function searchRecharge(array $data) : void
    {
        // Verifica se os campos de pesquisa estão vazios
        $dataEmptyInput = count(cleanInputData($data)["errors"]);
        $allInput = count($data);
        
        if($dataEmptyInput === $allInput) {
            $json["message"] = messageHelpers()->warning("Selecione uma opção ou digite um nome para pesquisar!")->render();
            echo json_encode($json);
            return;
        }

        // Fazer a pesquisa e devolve os valores
        $searchRecharg = (new Vw_recharge())->searchRecharg(cleanInputData($data)["data"]);
        
        if(!$searchRecharg) {
            $json["message"] = messageHelpers()->warning("Não há dados para pesquisa!")->render();
            echo json_encode($json);
            return;            
        }

        $html = $this->view->render("/card/listRecharge", [
            "listRecharge" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);
    }

    // Procura solicitados
    public function searchRequest(array $data) : void
    {
        // Verifica se os campos de pesquisa estão vazios
        $dataEmptyInput = count(cleanInputData($data)["errors"]);
        $allInput = count($data);

        if($dataEmptyInput === $allInput) {
            $json["message"] = messageHelpers()->warning("Digite um nome ou CPF para pesquisar!")->render();
            echo json_encode($json);
            return;
        }

        // Fazer a pesquisa e devolve os valores
        $searchRecharg = (new Vw_card())->searchRequest(cleanInputData($data)["data"]);

        if(!$searchRecharg) {
            $json["message"] = messageHelpers()->warning("Não há dados para pesquisa!")->render();
            echo json_encode($json);
            return;            
        }

        $html = $this->view->render("/card/requestCard", [
            "title" => "Solicitação de Cartão",
            "menu" => "solicitacao",
            "monthAll" => fncMonthAll(),
            "listCardName" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);
    }

    // Procurar enviados
    public function searchSend(array $data) : void  
    {
        // Verifica se os campos de pesquisa estão vazios
        $dataEmptyInput = count(cleanInputData($data)["errors"]);
        $allInput = count($data);
        
        if($dataEmptyInput === $allInput) {
            $json["message"] = messageHelpers()->warning("Digite um nome ou CPF para pesquisar!")->render();
            echo json_encode($json);
            return;
        }

        // Fazer a pesquisa e devolve os valores
        $searchRecharg = (new Vw_card())->searchSend(cleanInputData($data)["data"]);

        if(!$searchRecharg) {
            $json["message"] = messageHelpers()->warning("Não há dados para pesquisa!")->render();
            echo json_encode($json);
            return;            
        }

        $html = $this->view->render("/card/requestCard", [
            "title" => "Enviados",
            "menu" => "enviado",
            "listCardName" => $searchRecharg
        ]);

        $json["html"] = $html;
        echo json_encode($json);     
    }

    public function rechargeExtra() : void 
    {
        var_dump(true);
        // echo $this->view->render("/card/start", [
        //     "menu" => "recarga"
        // ]);
    }

    public function rechargCard(?array $data) : void
    {
        if(isset($data["person-benefit"])) {
            $recharg = (new CardRecharge());

            $response = $recharg->checkRecharge($data);

            if(!$response) {
                $json["message"] = $recharg->message()->render();
                echo json_encode($json);    
                return;
            }

            $json["message"] = $recharg->message()->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render("/card/start", [
            "title" => "Recarga Cartão",
            "menu" => "recargageral",
            "personbenefit" => (new Vw_card())
                ->find("status_card = :st AND type_request <> :ty", "st=ativo&ty=emergencial")
                ->fetch(true),
            "technicalUnit" => (new UnitUserSystem())->listTechnicalUnit()
        ]);
    }

    // Página de solicitação de novo cartão
    public function newCard() : void
    {
        echo $this->view->render("/card/start", [
            "menu" => "novocartao",
            "personbenefit" => (new PersonBenefit())
                ->find()
                ->order("name_benefit")
                ->limit(5000)
                ->fetch(true)
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
                ->find("status_request = :st AND
                    status_card = :stc AND
                    received = :re", 
                    "st=solicitado&
                    stc=aguardando cartão&
                    re=não")
                ->fetch(true)
            ]);  
            
            $json["redirectedBlank"] = url("/documento/$numberOffice->id_office/sendcompany");
            $json["redirected"] = url("/baixarexcelempresa/$numberOffice->id_office");
            $json["contentajax"] = "content-ajax";
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
                ->find("status_request = :st 
                    AND status_card = :stc 
                    AND received = :re", 
                    "st=solicitado&stc=aguardando cartão&re=não")
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

            if(!isset($data["received"])) {
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

            // Último número de remessa enviada
            $shipment = (new RequestCard())->lastNumberShipment();

            // Agrupa as solicitações por unidade e Emitir ofício e planilha excel
            $vwCard = (new Vw_card())->issueDocuments($data, $shipment);

            unset($_SESSION["data"]);

            $html = $this->view->render("/card/sendCard", [
                "menu" => "enviado",
                "listCardName" => (new Vw_card())
                    ->find("status_request = :st AND status_card = :stc AND received = :re", "st=concluída&stc=confecção&re=não")
                    ->fetch(true)
            ]); 

            $json["html"] = $html;
            $json["contentajax"] = "content-ajax";
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

    // Exluir solicitação de cartão
    public function deleteRequestCard(array $data) : void
    {
        // Modal quest
        if(!isset($data["btn-yes"])) {
            $url = url("/deletarsolicitacaocartao");
            $_SESSION["data"] = $data;
            $this->modalQuest($url, ["title" => "Atenção", "textMessage" => "Tem certeza que deseja excluir essa solicitação?!"]);
            return;
        }

        $idcard = (int)$_SESSION["data"]["id-request"];

        // Excluir solicitação de cartão previsão de recarga
        $deleCard = new RequestCard();
        $response = $deleCard->deleteRequestCard($idcard);

        if(!$response) {
            $json["message"] = $deleCard->message()->render();
            echo json_encode($json);
            return;
        }

        $json["message"] = $deleCard->message()->flash();
        $json["redirected"] = url("/solicitado");
        echo json_encode($json);
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

    // Cancelar cartão
    public function cardCancel(array $data) : void 
    {
        $idRequest = (int)$data["id-request"];
        $cardCanele = (new CardRecharge())->cardCancel($idRequest);

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
    public function modalQuest($url = null, ?array $data = null) : void
    {
        
        $html = $this->view->render("/modal/modalQuest", [
            "title" => $data["title"] ?? "Confirmar Ação",
            "textMessage" => $data["textMessage"] ?? "Tem certeza que deseja encaminhar essa lista!",
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