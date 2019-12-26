<?php

include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];
$fecha = CFecha::formatFechaBD( CFecha::hoy());
$lDieta = new LDieta();
$termino = $lDieta->terminarDia($idpersona, $fecha);
if($termino == 0){
    echo json_encode( CRespuestaWs::mostrar(false, "Ya se terminó este día con anterioridad."));
}else{
    echo json_encode( CRespuestaWs::mostrar(true, "Día terminado"));
}

