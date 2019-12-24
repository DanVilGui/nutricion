<?php
include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];
$idpersona = 9;
$fecha = CFecha::hoy();
$lDieta = new LDieta();
$dieta = $lDieta->buscarDietaPersonaFecha($idpersona, CFecha::formatFechaBD($fecha));
$horarios = $lDieta->buscarHorarios();

echo json_encode( CRespuestaWs::mostrar(true, "", ["dieta"=>$dieta, "horarios"=>$horarios]));

