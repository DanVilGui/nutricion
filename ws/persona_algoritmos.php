<?php
include_once 'validaciones.php';

$data = WS::validarToken();
$idpersona = $data["idpersona"];

//$idpersona = 9;
$lPersona = new LPersona();
/** @var CPersona $persona */
/** @var CPersonaMedida $medida */
/** @var CPersonaRutina $rutina */

$persona = ( object)$lPersona->buscarPersona($idpersona);
$fechaHoy = CFecha::hoy();
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
$gaf += 0.013 * $peso * 60 * $rutina->trabaja_ligero;

//leve
$gaf += ($sexo == "M") ? 0.016 * $peso * 60 * $rutina->caminar : 0.015 * $peso * 60 * $rutina->caminar;
$gaf += ($sexo == "M") ? 0.016 * $peso * 60 * $rutina->escaleras : 0.015 * $peso * 60 * $rutina->escaleras;
$gaf += ($sexo == "M") ? 0.016 * $peso * 60 * $rutina->trabaja_casa : 0.015 * $peso * 60 * $rutina->trabaja_casa;
//moderada
$gaf += ($sexo == "M") ? 0.017 * $peso * 60 * $rutina->ciclismo : 0.016 * $peso * 60 * $rutina->ciclismo;
$gaf += ($sexo == "M") ? 0.017 * $peso * 60 * $rutina->danza : 0.016 * $peso * 60 * $rutina->danza;
$gaf += ($sexo == "M") ? 0.017 * $peso * 60 * $rutina->tenis : 0.016 * $peso * 60 * $rutina->tenis;
$gaf += ($sexo == "M") ? 0.017 * $peso * 60 * $rutina->trabaja_activo : 0.016 * $peso * 60 * $rutina->trabaja_activo;

//intensa
$gaf += ($sexo == "M") ? 0.021 * $peso * 60 * $rutina->baloncesto : 0.019 * $peso * 60 * $rutina->baloncesto;
$gaf += ($sexo == "M") ? 0.021 * $peso * 60 * $rutina->futbol : 0.019 * $peso * 60 * $rutina->futbol;
$gaf += ($sexo == "M") ? 0.021 * $peso * 60 * $rutina->natacion : 0.019 * $peso * 60 * $rutina->natacion;
$gaf += ($sexo == "M") ? 0.021 * $peso * 60 * $rutina->trabaja_muyactivo : 0.019 * $peso * 60 * $rutina->trabaja_muyactivo;
$gaf += ($sexo == "M") ? 0.021 * $peso * 60 * $rutina->correr : 0.019 * $peso * 60 * $rutina->correr;

$get = $gaf + $ger;

$persona->kcal = $get;
$lPersona->cambiarKcal($persona);

/*
 * GENERAR LAS DIETAS
 */
$generador = new LGenerarCombinacion();
$horarios=  $generador->listarHorarios();
$maxCombinacionGeneradas = LGenerarCombinacion::MAX_COMBINACIONES;
$arrCombinaciones = new CCombinacionSemana();
for($i=0;$i<$generador->getMaxSemana();$i++){
    foreach ($horarios as $horario) {
        /** @var CHorario $horario */
        $kcalHorario = $get*$horario->getPorcentaje();
        $generador->filtrarXHorario($horario->getId());
        $tipos = $generador->tipos;
        $listaProductos = $generador->listaProductos;
        $nroCombinacionGeneradas = 0;
        while($nroCombinacionGeneradas< $maxCombinacionGeneradas){
            $nCombinacion = $generador->generarCombinacion();
            $nCombinacion->idhorario = $horario->id;
            $nroCombinacionGeneradas +=1;
            /*    * validar estructura combinacion    */
            if ( $arrCombinaciones->validaCombinacionSemanal($kcalHorario,$i, $nCombinacion) ) {
                /* ?>  MAX <?= $kcalHorario ?><br>  <?php $nCombinacion->imprimir();    */
                $arrCombinaciones->agregarCombinacion($i,$nCombinacion);
                ;break;

            }
        }

    }
}

/*
 *  PERSISTIR LAS DIETAS
 */

try{
    $lDieta = new LDieta();
    $listaRecomendacionDia= $arrCombinaciones->listaCombinaciones;

    for($i = 0;  $i< LGenerarCombinacion::SEMANAS; $i++){
        $contDia = 0;
        for($j = 0; $j< LGenerarCombinacion::DIAS_SEMANA; $j++) {
            $fechaAcumulada = CFecha::agregarDia($fechaHoy, $j + ($i* LGenerarCombinacion::DIAS_SEMANA ));
            $esDomingo = CFecha::esDomingo($fechaAcumulada);
            $cDieta = new CDieta();
            $cDieta->setIdpersona($idpersona);
            $cDieta->setFecha(CFecha::formatFechaBD( $fechaAcumulada));
            $cDieta->setAsignado(intval(!$esDomingo));
            $cDieta->setFechaRegistro(CFecha::formatFechaHoraBD($fechaHoy));
            $rptDieta = $lDieta->registrarDieta($cDieta);
            if(!$esDomingo){
                $iddieta = $rptDieta["iddieta"];
                $recomendacionDia = $listaRecomendacionDia[$contDia];
                foreach ($recomendacionDia as $combHorario) {
                    /** @var CCombinacion $combHorario */
                    $combHorario->setIddieta($iddieta);
                    $registroCombinacion = $lDieta->registrarCombinacion($combHorario);
                    if($registroCombinacion["success"]){
                        $idcombinacion = $registroCombinacion["idcombinacion"];
                        foreach ($combHorario->listaCombinacion as $combDetalle) {
                            /**@var CCombinacionDetalle $combDetalle */
                            $combDetalle->setIdcombinacion($idcombinacion);
                            $lDieta->registrarCombinacionDetalle($combDetalle);
                        }
                    }

                }
                $contDia +=1;
            }
        }
    }


    $lPersona->cambiarRecalcular($idpersona, 0);
    $lDieta->borrarDietasAntiguas($idpersona, CFecha::formatFechaHoraBD($fechaHoy));
   // echo json_encode($arrCombinaciones);
    echo json_encode(CRespuestaWs::mostrar(true, "Plan alimenticio asignado", ["kcal"=>$get]));
}catch (Exception $ex){
    echo json_encode(CRespuestaWs::mostrar(true, "Error al asignar plan alimenticio"));
}



/*
echo "GER: " . $ger . " GAF: " . $gaf . "\n";
echo "GET: " . $get . "\n";
*/



