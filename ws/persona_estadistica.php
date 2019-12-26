<?php
include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];
$fecha = CFecha::formatFechaBD( CFecha::hoy());
$lDieta = new LDieta();
$estadistica = $lDieta->buscarEstadisticaDietas($idpersona, $fecha);

if($estadistica["total"] == 0){
    echo json_encode( CRespuestaWs::mostrar(false, "No tiene registros"));
}else{
    echo json_encode( CRespuestaWs::mostrar(true, "", ["estadistica"=>$estadistica]));
}

