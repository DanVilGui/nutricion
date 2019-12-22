<?php
include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];


/*
 *  rutinas
 */
$caminar = WS::JSONPOST("caminar");
$escaleras = WS::JSONPOST("escaleras");
$trabaja_ligero = intval ( WS::JSONPOST("trabaja_ligero",false));
$trabaja_casa =  intval( WS::JSONPOST("trabaja_casa",false));
$trabaja_activo = intval( WS::JSONPOST("trabaja_activo",false));
$trabaja_muyactivo = intval( WS::JSONPOST("trabaja_muyactivo",false));
$trabaja = WS::JSONPOST("trabaja",false)!=null ?  WS::JSONPOST("trabaja",false) : 1;

/*
 * deportes
 */

$ciclismo = WS::JSONPOST("ciclismo");
$futbol = WS::JSONPOST("futbol");
$danza = WS::JSONPOST("danza");
$baloncesto = WS::JSONPOST("baloncesto");
$natacion = WS::JSONPOST("natacion");
$tenis = WS::JSONPOST("tenis");
$correr = WS::JSONPOST("correr");

$clsPersonaRutina = new CPersonaRutina();
$clsPersonaRutina->setIdpersona($idpersona);
$clsPersonaRutina->setCaminar($caminar);
$clsPersonaRutina->setEscaleras($escaleras);
$clsPersonaRutina->setTrabaja($trabaja);
$clsPersonaRutina->setTrabajaLigero($trabaja_ligero);
$clsPersonaRutina->setTrabajaCasa($trabaja_casa);
$clsPersonaRutina->setTrabajaActivo($trabaja_activo);
$clsPersonaRutina->setTrabajaMuyactivo($trabaja_muyactivo);

$clsPersonaRutina->setCiclismo($ciclismo);
$clsPersonaRutina->setFutbol($futbol);
$clsPersonaRutina->setDanza($danza);
$clsPersonaRutina->setBaloncesto($baloncesto);
$clsPersonaRutina->setNatacion($natacion);
$clsPersonaRutina->setTenis($tenis);
$clsPersonaRutina->setCorrer($correr);

$lPersona = new LPersona();

$res = $lPersona->registrarRutina($clsPersonaRutina);
if($res){
    $rutina = $lPersona->buscarRutina($idpersona);
    echo json_encode(CRespuestaWs::mostrar(true, "Rutina registrada!", ["rutina"=> $rutina ]));
}else{
    echo json_encode(CRespuestaWs::mostrar(false, "Error al guardar la rutina!"));
}

