<?php
include_once 'validaciones.php';
//$data = WS::validarToken();
//$idpersona = $data["idpersona"];

$idpersona = 1;
$lPersona = new LPersona();
/** @var CPersona $persona */
/** @var CPersonaMedida $medida */
/** @var CPersonaRutina $rutina */

$persona = ( object)$lPersona->buscarPersona($idpersona);
$fechaHoy = new DateTime("now");
$fechaNacimiento = new DateTime($persona->fecha_nacimiento);
$interval = $fechaNacimiento->diff($fechaHoy);

$medida = (object)$lPersona->buscarUltimaMedida($idpersona);

$rutina = ( object)$lPersona->buscarRutina($idpersona);

$edad = $interval->y;
$sexo = $persona->sexo;
$peso = $medida->peso;

$ger = $gaf = 0;

//echo $edad . "-" . $sexo . "-" . $peso . "\n";
switch (true) {
    case $edad > 0 && $edad <= 3:
        $ger = ($sexo == "M") ? 60.9 * $peso - 54 : 61 * $peso - 51;
        break;
    case $edad > 3 && $edad <= 10:
        $ger = ($sexo == "M") ? 22.7 * $peso + 495 : 22.5 * $peso + 499;
        break;
    case $edad > 10 && $edad <= 18:
        $ger = ($sexo == "M") ? 17.5 * $peso + 651 : 12.2 * $peso + 746;
        break;
    case $edad > 18 && $edad <= 30:
        $ger = ($sexo == "M") ? 15.3 * $peso + 679 : 14.7 * $peso + 496;
        break;
    case $edad > 30 && $edad <= 60:
        $ger = ($sexo == "M") ? 11.6 * $peso + 879 : 14.7 * $peso + 746;
        break;
    case $edad > 60:
        $ger = ($sexo == "M") ? 13.5 * $peso + 487 : 10.5 * $peso + 596;
        break;
}
//muy leve
$gaf += 0.013 * $peso * $rutina->trabaja_ligero * 60;
//leve
$gaf += ($sexo == "M") ? 0.016 * $peso * $rutina->caminar : 0.015 * $peso * $rutina->caminar;
$gaf += ($sexo == "M") ? 0.016 * $peso * $rutina->escaleras : 0.015 * $peso * $rutina->escaleras;
$gaf += ($sexo == "M") ? 0.016 * $peso * $rutina->trabaja_casa : 0.015 * $peso * $rutina->trabaja_casa;
//moderada
$gaf += ($sexo == "M") ? 0.017 * $peso * $rutina->ciclismo : 0.016 * $peso * $rutina->ciclismo;
$gaf += ($sexo == "M") ? 0.017 * $peso * $rutina->danza : 0.016 * $peso * $rutina->danza;
$gaf += ($sexo == "M") ? 0.017 * $peso * $rutina->tenis : 0.016 * $peso * $rutina->tenis;
$gaf += ($sexo == "M") ? 0.017 * $peso * $rutina->trabaja_activo : 0.016 * $peso * $rutina->trabaja_activo;

//intensa
$gaf += ($sexo == "M") ? 0.021 * $peso * $rutina->baloncesto : 0.019 * $peso * $rutina->baloncesto;
$gaf += ($sexo == "M") ? 0.021 * $peso * $rutina->futbol : 0.019 * $peso * $rutina->futbol;
$gaf += ($sexo == "M") ? 0.021 * $peso * $rutina->natacion : 0.019 * $peso * $rutina->natacion;
$gaf += ($sexo == "M") ? 0.021 * $peso * $rutina->trabaja_muyactivo : 0.019 * $peso * $rutina->trabaja_muyactivo;
$gaf += ($sexo == "M") ? 0.021 * $peso * $rutina->correr : 0.019 * $peso * $rutina->correr;

echo "GER: " . $ger . " GAF: " . $gaf . "\n";
$get = $gaf + $ger;
echo "GET: " . $get . "\n";

echo json_encode($rutina);