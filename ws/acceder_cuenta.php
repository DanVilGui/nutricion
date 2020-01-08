<?php
include_once 'validaciones.php';
$correo = WS::JSONPOST("correo");
$contrasenia = WS::JSONPOST("contrasenia");

$clsPersona = new CPersona();
$clsPersona->correo = $correo;
$clsPersona->contrasenia = $contrasenia;

$lPersona = new LPersona();
$respuesta = $lPersona->accederCuenta($clsPersona);
if($respuesta !=null){
    $idpersona = $respuesta["idpersona"];
    $res =  $lPersona->buscarPersonaDatos($idpersona);
    echo json_encode( CRespuestaWs::mostrar(true, "Bienvenido!", $res));

}else{
    echo json_encode(CRespuestaWs::mostrar(false, "Correo o contraseña incorrecta!"));

}