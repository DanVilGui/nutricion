<?php

include_once 'validaciones.php';

$data = WS::validarToken();
$idpersona = $data["idpersona"];
$sexo = WS::JSONPOST("sexo");
$fecha_nacimiento = WS::JSONPOST("fecha_nacimiento");


try{
    $fechaHoy = new DateTime("now");
    $fechaNacimiento = new DateTime($fecha_nacimiento);
    $interval = $fechaNacimiento->diff($fechaHoy);
    $anios = $interval->y;
    if($anios<16)  exit(json_encode( CRespuestaWs::mostrar(false, "Usted tiene menos de 16 años")));
    if($anios>60)  exit(json_encode( CRespuestaWs::mostrar(false, "Usted tiene más de 60 años")));

}catch (Exception $ex){
    exit(json_encode( CRespuestaWs::mostrar(false, "Formato de fecha Incorrecto")));
}

$clsPersona  = new CPersona();
$clsPersona->setIdpersona($idpersona);
$clsPersona->setSexo($sexo);
$clsPersona->setFechaNacimiento($fecha_nacimiento);

$dPersona = new DPersona();
$ok = $dPersona->cambiarSexoEdad($clsPersona);
echo  json_encode( CRespuestaWs::mostrar(true, "Información Actualizada"));