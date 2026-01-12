<?php

/** @var \CoffeeCode\Router\Router $route */


$route->namespace("Source\App\Card");

// $route;

/**
 *  Cartão 
 **/ 
  $route->group("/cartao");
  $route->get("/cartao", "CardPerson:startPage");
  $route->get("/enivardesbloqueiocartao", "CardPerson:listExcelSendCardRecharge");

  $route->get("/enviado", "CardPerson:sendCard");
  $route->post("/enviado", "CardPerson:sendCard");
  $route->post("/procurarenviados", "CardPerson:searchSend");

  $route->get("/solicitado", "CardPerson:requestCard");
  $route->post("/solicitado", "CardPerson:requestCard");
  $route->post("/procurarsolicitacao", "CardPerson:searchRequest");
  $route->post("/deletarsolicitacaocartao", "CardPerson:deleteRequestCard");

  $route->get("/novocartao", "CardPerson:requestCard");
  $route->get("/cartaoativo", "CardPerson:cardActive");
  $route->get("/solicitarnovocartao", "CardPerson:newCard");
  $route->post("/procurarcartao", "CardPerson:searchCard");

  $route->get("/beneficiario", "CardPerson:benefit");

  $route->get("/solicitaremergencial","CardPerson:listEmergency");
  $route->get("/cartaoemergencial","CardPerson:requestEmergency");
  $route->post("/cartaoemergencial","CardPerson:requestEmergency");
  $route->post("/procuraremergencial", "CardPerson:searchEmergency");

  // $route->post("/gerarrecarga","CardPerson:generateRecharge");
  $route->post("/procurarrecarga", "CardPerson:searchRecharge");

  $route->get("/atualizarsaldo", "CardPerson:balanceUpdate");

  $route->get("/solicitarsegundaviacartao", "CardPerson:secondCard");
  $route->post("/solicitarsegundaviacartao", "CardPerson:secondCard");
  $route->get("/recarga","CardPerson:recharge");
  $route->post("/gerarrecarga","CardPerson:recharge");

  $route->get("/recargaextra","CardPerson:rechargeExtra");
  $route->post("/recargaextra","CardPerson:rechargeExtra");
  $route->get("/recargacartao", "CardPerson:rechargCard");
  $route->post("/recargacartao", "CardPerson:rechargCard");

  $route->post("/cancelarcard", "CardPerson:cardCancel");
  $route->get("/cancelarcard/{idcard}", "CardPerson:cardCancel");
  $route->get("/cancelarcardedit/{idCard}", "CardPerson:editModalCanceledCard");

  // Rotas para solicitação de cartão feito nas unidades
  $route->get("/solicitarcartao", "CardPerson:formCardRequest");
  $route->post("/solicitarcartao", "CardPerson:formCardRequest");

  //  $route->get("/deletesolicitacaocartao", "CardRequest:deleteRequestCard");
  //  $route->post("/deletesolicitacaocartao", "CardRequest:deleteRequestCard");

  $route->post("/modalquest", "CardPerson:modalQuest");
  // $route->get("/modalrecarga/{idBenefiti}", "CardPerson:modalExtractRecharge");
  $route->get("/recargabeneficiario/{idBenefiti}", "CardPerson:extractRechargeBenefit");
  $route->get("/cardsbeneficiario/{idBenefiti}", "CardPerson:cardBenefit");
  // $route->get("/modalcancelarcard/{idcard}", "CardPerson:modalCanceledCard");
 
   
/**
 * Ipressão de documento e baixar excel
 */
   $route->group("/documentocartao");

   $route->get("/documento/{office}/{type}", "CardDocument:documentOffice");
   $route->get("/documentounidade/{shipment}", "CardDocument:documentOfficeUnit");
   $route->get("/baixarexcelempresa/{office}", "CardDocument:listExcelSendCard");
   $route->get("/baixarexcelunidade/{shipment}", "CardDocument:listExcelUnitSend");
   $route->get("/baixarexcelerecarga/{office}", "CardDocument:listExcelRecharge");
   $route->post("/baixarlista", "CardDocument:downloadsListExcel");
   $route->post("/receberexcel", "CardDocument:uploadExcel");
   $route->get("/baixarnaoencontrado/{month}", "CardDocument:listNotFoundDownload");