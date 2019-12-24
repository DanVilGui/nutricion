<?php
include_once 'validaciones.php';

$data = WS::validarToken();
$idpersona = $data["idpersona"];

$lPersona = new LPersona();

$datos = $lPersona->buscarPersonaDatos($idpersona);
echo json_encode( CRespuestaWs::mostrar(true, "", $datos));

