<?php
include 'Clases/imports.php';
include 'Datos/imports.php';
include 'Logica/imports.php';



?>
<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<?php
$generador = new LGenerarCombinacion();
$generador->setMaxSemana(6);
$horarios=  $generador->listarHorarios();
$maxCombinacionGeneradas = LGenerarCombinacion::MAX_COMBINACIONES;
$imc = 8000;
$margenKcal = 35;
$arrCombinaciones = new CCombinacionSemana();

//echo json_encode($horarios);
date_default_timezone_set('America/Lima');
$hoy = time();
$diasSemana =[ "Domingo","Lunes", "Martes","Miércoles","Jueves","Viernes","Sábado"];
function formatDia($hoy){
    return date('d/m/Y', $hoy);
}
function agregarDia($fecha, $cantDias){
  return  strtotime("+$cantDias day", $fecha);
}

function obtenerDia($fecha){
  return date("w", $fecha);
}

$contDias = 0;
for($i=0;$i<$generador->getMaxSemana();$i++){

    $fechaDia = agregarDia($hoy, $contDias);
    $diaSemana = obtenerDia($fechaDia);
    if($diaSemana == 0){
        echo "<h2>". $diasSemana[$diaSemana] ." :  ".formatDia($fechaDia)." :DIA LIBRE </h2><br>";
        $contDias ++;
        $fechaDia = agregarDia($hoy, $contDias);
        $diaSemana = obtenerDia($fechaDia);
    }
    echo "<h2>". $diasSemana[$diaSemana] ." :  ".formatDia($fechaDia)." </h2><br>";
    foreach ($horarios as $horario) {
        /** @var CHorario $horario */
            $kcalHorario = $imc*$horario->getPorcentaje();
            $generador->filtrarXHorario($horario->getId());
            $tipos = $generador->tipos;
            $listaProductos = $generador->listaProductos;
            $nroCombinacionGeneradas = 0;

            while($nroCombinacionGeneradas< $maxCombinacionGeneradas){
                $nCombinacion = $generador->generarCombinacion();
                $nCombinacion->idhorario = $horario->id;
                $nroCombinacionGeneradas +=1;
               // $diff = $kcalHorario - $nCombinacion->kcalTotal;
                /*
                 * validar estructura combinacion
                 */
                if ( $arrCombinaciones->validaCombinacionSemanal($kcalHorario,$i, $nCombinacion) ) {
                    ?>
                    MAX <?= $kcalHorario ?><br>
                    <?php
                    $nCombinacion->imprimir();
                    $arrCombinaciones->agregarCombinacion($i,$nCombinacion);
                    ;break;

                }
            }

    }
    $contDias++;

}

?>

