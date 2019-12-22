<?php
include_once 'validaciones.php';
//$data = WS::validarToken();
//$idpersona = $data["idpersona"];

$idpersona = 1;
$lPersona = new LPersona();
/** @var CPersona $persona */
/** @var CPersonaMedida $medida */
$persona = ( object) $lPersona->buscarPersona($idpersona);
$fechaHoy = new DateTime("now");
$fechaNacimiento = new DateTime($persona->fecha_nacimiento);
$interval = $fechaNacimiento->diff($fechaHoy);

$medida = (object) $lPersona->buscarUltimaMedida($idpersona);

$rutina = $lPersona->buscarRutina($idpersona);

$edad = $interval->y;
$sexo = $persona->sexo;
$peso = $medida->peso;

echo $edad."-".$sexo."-".$peso;

echo json_encode($rutina);