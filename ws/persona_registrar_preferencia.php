<?php
include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];

$cant_comidas = WS::JSONPOST("cant_comidas");
$cant_vasos = WS::JSONPOST("cant_vasos");
$comida_hambre = WS::JSONPOST("comida_hambre");
$hace_dieta = WS::JSONPOST("hace_dieta");

$clsPersonaPreferencia  = new CPersonaPreferencia();
$clsPersonaPreferencia->setIdpersona($idpersona);
$clsPersonaPreferencia->setCantComidas($cant_comidas);
$clsPersonaPreferencia->setCantVasos($cant_vasos);
$clsPersonaPreferencia->setComidaHambre($comida_hambre);
$clsPersonaPreferencia->setHaceDieta($hace_dieta);

$lPersona = new LPersona();
$res = $lPersona->registrarPreferencia($clsPersonaPreferencia);
if($res){
    $preferencia = $lPersona->buscarPreferencia($idpersona);
    echo json_encode(CRespuestaWs::mostrar(true, "Preferencia registrada!", ["preferencia"=> $preferencia ]));
}else{
    echo json_encode(CRespuestaWs::mostrar(false, "Error al guardar la rutina!"));
}

