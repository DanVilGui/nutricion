<?php
include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];
$idpersona = 9;
$fecha = WS::JSONPOST("fecha");
$lDieta = new LDieta();
$dietaInfo = $lDieta->buscarDietaPersonaInfo($idpersona, $fecha);
$dieta = $lDieta->buscarDietaPersonaFecha($idpersona, $fecha);
$horarios = $lDieta->buscarHorarios();

if($dietaInfo === false){
    echo json_encode( CRespuestaWs::mostrar(false, "No hay una asignada para esta fecha"));

}else{
    echo json_encode( CRespuestaWs::mostrar(true, "", ["info"=> $dietaInfo, "dieta"=>$dieta, "horarios"=>$horarios]));
}

