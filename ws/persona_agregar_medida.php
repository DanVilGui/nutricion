<?php
include_once 'validaciones.php';

$data = WS::validarToken();
$idpersona = $data["idpersona"];
$peso = WS::JSONPOST("peso");
$medida = WS::JSONPOST("medida");
$cintura =  WS::JSONPOST("cintura");
$cadera =  WS::JSONPOST("cadera");
$imc = WS::JSONPOST("imc");

$cMedida = new CPersonaMedida();
$cMedida->setIdpersona($idpersona);
$cMedida->setPeso($peso);
$cMedida->setMedida($medida);
$cMedida->setCadera($cadera);
$cMedida->setCintura($cintura);
$cMedida->setImc($imc);
$fechaHoy = date('Y-m-d', time());
$cMedida->setFecha($fechaHoy);

$dPersonaMedida = new DPersonaMedida();
$res = $dPersonaMedida->agregarMedida($cMedida);
$dPersona  = new DPersona();
$medidas = $dPersona->buscarMedidasControles($idpersona);
if($res){
    echo json_encode(CRespuestaWs::mostrar(true, "Control registrado!", ["medidas"=> $medidas ]));
}else{
    echo json_encode(CRespuestaWs::mostrar(false, "Error al guardar el control!"));
}